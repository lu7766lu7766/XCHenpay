<?php

namespace App\Traits;

use App\ErrorLog;
use Validator;
use Redirect;
use Response;

trait ControllerResponse
{
    protected function RedirectBackWith($state, $validator){
        $messages ="";

        $errors = $validator->errors();
        foreach ($errors->all(':message') as $message) {
            $messages .= $message;
        }

        return Redirect::back()->withInput()->with($state, $message);
    }

    protected function validateErrorResponseInJson($validator){
        $messages ="";

        $errors = $validator->errors();
        foreach ($errors->all(':message') as $message) {
            $messages .= $message;
        }

        return Response::json(array(
            'Result' => 'error',
            'Message'=> $messages
        ));
    }

    protected function validateErrorResponseInJsonWithLi($validator){
        $messages ="";

        $errors = $validator->errors();
        foreach ($errors->all('<li>:message</li>') as $message) {
            $messages .= $message;
        }

        return Response::json(array(
            'Result' => 'error',
            'Message'=> $messages
        ));
    }

    protected function okayResponse($message = null){
        return Response::json(array(
            'Result' => 'OK',
            'Message' => $message
        ));
    }

    protected function errorResponse($message){
        return Response::json(array(
            'Result' => 'error',
            'Message' => $message
        ));
    }

    protected function errorLog( $message)
    {
        ErrorLog::create(['log' => $message]);
    }
}