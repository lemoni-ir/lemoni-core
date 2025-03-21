<?php

use backend\application;

try {
    application::up();

    require APP . '/initial/router.php';



    $controller = 'backend\\controllers\\' . str_replace('/', '\\', application::$controller);
    $method = 'action' . ucfirst(application::$method);
    $params = application::$parameters;


    try {
        $flag = (class_exists($controller) and method_exists($controller, $method));
        if (!$flag)
            throw new Exception("The controller or method does not exist.");
        try {
            call_user_func_array(array($controller, $method), $params);
        } catch (\Throwable $th) {
            header("HTTP/1.1 500 Internal Server Error");
            $data = [
                'message' => '',
                'request' => application::$controller . '/' . application::$method,
                'post' => $_POST,
                'get' => $_GET,
                'debug' => debug_backtrace(),
                'cookie' => $_COOKIE,
                'server' => $_SERVER,
            ];
            if (DEV_MODE)
                $data['message'] = $th->getMessage();
            echo json_encode([
                'status' => 500,
                'error' => 'Application Error.',
                'message' => 'An unexpected error occurred in the application environment.',
                'code' => 'Controller_Method_500',
                'data' => $data
            ]);
        }
    } catch (\Throwable $th) {
        header("HTTP/1.1 404 Not Found");
        $data = [
            'request' => application::$controller . '/' . application::$method,
        ];
        if (DEV_MODE) {
            $data['controller'] = $controller;
            $data['method'] = $method;
            $data['class_exist'] = class_exists($controller);
            $data['method_exist'] = method_exists($controller, $method);
            $data['debug'] =  debug_backtrace();
        }
        echo json_encode([
            'status' => 404,
            'error' => 'Not Found.',
            'message' => $th->getMessage(),
            'code' => 'Controller_Method_404',
            'data' => $data
        ]);
    }
    application::down();
} catch (\Throwable $e) {
    header("HTTP/1.1 500 Internal Server Error");

    echo json_encode([
        'status' => 500,
        'error' => 'Application Error.',
        'message' => 'An unexpected error occurred in the application environment.',
        'code' => 'BESMELLAH_ERROR',
        'data' => [
            'message' => DEV_MODE ? $e->getMessage() : ''
        ]
    ]);
}
