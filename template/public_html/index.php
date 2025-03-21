<?php
try {

    header('Content-Type: application/json');

    define('APP', realpath(dirname(__DIR__) . '/backend') ?: '');
    require dirname(APP) . '/vendor/autoload.php';

    $dotenv = Dotenv\Dotenv::createImmutable(dirname(APP . ''));
    $dotenv->load();
    $dotenv->load();

    define('WWW', realpath(__DIR__));
    define('IS_LOCAL', strtoupper(substr(PHP_OS, 0, 3)) === 'WIN');
    define('DEV_MODE', IS_LOCAL || ($_ENV['APP_ENV'] ?? $_SERVER['APP_ENV'] ?? 'production') === 'development');

    define('AJAX', strtolower($_SERVER["HTTP_X_REQUESTED_WITH"] ?? '') === 'xmlhttprequest');


    ini_set('log_errors', 1);
    ini_set('error_log', APP . '/storage/errors/' . PHP_OS . '-' . date('Y-m-d') . '.log');
    ini_set('display_errors', DEV_MODE ? 'On' : 'off');

    error_reporting(DEV_MODE ? E_ALL : 0);
    date_default_timezone_set('UTC');

    require APP . '/initial/besmellah.php';


} catch (\Throwable $e) {


    header("HTTP/1.1 500 Internal Server Error");
    echo json_encode([
        'status' => 500,
        'error' => 'Server Error.',
        'message' => 'something is wrong.',
        'code' => 'WWW_Index_ERROR',
        'data' => DEV_MODE ? [
            'message' => $e->getMessage(),
            'www_root' => WWW,
            'app_root' => APP,
            'is_local' => IS_LOCAL,
            'dev_mode' => DEV_MODE,
            'ajax' => AJAX,
            'frontend_entry_point' => FRONTEND_ENTRY_POINT
        ] : [

            'dev_mode' => DEV_MODE,
        ]
    ]);
}



die;