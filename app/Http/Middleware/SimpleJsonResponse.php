<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;

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
        $response = $next($request);
        $content = [];
        if (config('app.debug')) {
            $content['client_request_body'] = $request->request->all();
            $content['query_loq'] = \DB::getQueryLog();
        }
        if ($response instanceof JsonResponse) {
            $tmpContent = $response->getData(true);
            $content['data'] = $tmpContent['data'] ?? $tmpContent;
            $content['code'] = $tmpContent['code'] ?? $response->getStatusCode();
            $response->setData($content);
        } elseif (($response instanceof Response)) {
            // exception occur.
            if (method_exists($response, 'withException') && !is_null($response->exception)) {
                if (config('app.debug')) {
                    return $response; // this resp is a exception trace page.
                } else {
                    $content['data'] = config('app.debug') ? $response->exception->getMessage() :
                        'A team of highly trained monkeys has been dispatched to deal with this situation';
                    $content['code'] = $response->getStatusCode();
                }
            } else {
                if (!is_null($tmpContent = $response->getContent()) || $tmpContent !== '') {
                    $tmpContent = json_decode($tmpContent, true);
                }
                if (is_scalar($tmpContent) || is_null($tmpContent)) {
                    $content['data'] = $response->getContent();
                    $content['code'] = $response->getStatusCode();
                } else {
                    $content['data'] = $tmpContent['data'] ?? $tmpContent;
                    $content['code'] = $tmpContent['code'] ?? $response->getStatusCode();
                }
            }
            $response->setContent($content);
        }

        return $response;
    }
}
