<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Illuminate\Validation\ValidationException;

class SimpleJsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  \Closure $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $request->headers->set('Accept', 'application/json');
        $response = $next($request);
        $content = [];
        if (config('app.debug')) {
            $content['client_request_body'] = $request->request->all();
            $content['query_loq'] = \DB::getQueryLog();
        }
        if ($response instanceof JsonResponse) {
            // exception occur.
            if (method_exists($response, 'withException') && !is_null($response->exception)) {
                $tmpContent = $this->formatExceptionToJson($response->exception);
                $content['code'] = $tmpContent['code'] ?: $response->getStatusCode();
                $content['data'] = config('app.debug') ? $tmpContent['data'] :
                    'A team of highly trained monkeys has been dispatched to deal with this situation';
            } else {
                $tmpContent = $response->getData(true);
                $content['code'] = $tmpContent['code'] ?? $response->getStatusCode();
                $content['data'] = $tmpContent['data'] ?? $tmpContent;
            }
            $response->setData($content);
        } elseif (($response instanceof Response)) {
            if (!is_null($tmpContent = $response->getContent()) || $tmpContent !== '') {
                $tmpContent = json_decode($tmpContent, true);
            }
            if (is_scalar($tmpContent) || is_null($tmpContent)) {
                $content['code'] = $response->getStatusCode();
                $content['data'] = $response->getContent();
            } else {
                $content['code'] = $tmpContent['code'] ?? $response->getStatusCode();
                $content['data'] = $tmpContent['data'] ?? $tmpContent;
            }
            $response->setContent($content);
        }

        return $response;
    }

    /**
     * @param \Throwable $e
     * @return array
     */
    private function formatExceptionToJson(\Throwable $e)
    {
        if ($e instanceof ValidationException) {
            $msg = $e->validator->getMessageBag()->all();
            $trace = [];
            $code = $e->status;
        } else {
            $msg = $e->getMessage();
            $trace = $e->getTrace();
            $code = $e->getCode();
        }
        $result = [
            'code' => $code,
            'data' => [
                'line'  => $e->getLine(),
                'msg'   => $msg,
                'trace' => $trace
            ]
        ];

        return $result;
    }
}
