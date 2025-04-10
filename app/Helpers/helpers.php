<?php

use Illuminate\Support\Facades\Config;

function H_api400($errors = [], $message = 'Bad Request.') {
    $response = (object) [
        'status'    => 400,
        'message'   => $message,
        'errors'    => $errors
    ];

    return response()->json($response, $response->status);
}

function H_api404($identifier = 'Data') {
    $response = (object) [
        'data'      => null,
        'status'    => 404,
        'message'   => $identifier . ' is Not Found'
    ];

    return response()->json($response, 404);
}

function H_api500($message) {
    $message = Config::get('app.debug') ? $message : 'Something went wrong. Please try again later.';
    $response = (object) [
        'status'    => 500,
        'message'   => $message
    ];
    
    return response()->json($response, $response->status);
}

function H_apiSuccess($data, $status = 200, $message = 'success') {
    $response = (object) [
        'status'    => $status,
        'message'   => $message,
        'data'      => $data
    ];

    return response()->json($response, $response->status);
}

function H_responseMsg($action)
{
    $phrase = '';
    if($action == 'c') $phrase = 'Created';
    else if($action == 'u') $phrase = 'Updated';
    else if($action == 'd') $phrase = 'Deleted';
    
    return ' Data Successfully ' . $phrase;
}