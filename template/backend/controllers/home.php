<?php

namespace backend\controllers;

use Exception;

class home
{

    /**
     * Handles the index action for the home controller.
     *
     * If the request is not an AJAX request, it sets the content type to HTML and includes the index view.
     * Otherwise, it outputs a JSON response with home index status, a message, 
     * and the current microtime.
     *
     * @throws Exception
     */
    public static function actionIndex()
    {


        if (!AJAX) {
            $frontend_entry_point = realpath(WWW . '/views/index.html');

            if (!$frontend_entry_point)
                throw new Exception("The entry point of the frontend application was not found.");

            header('Content-Type: text/html');
            require_once $frontend_entry_point;
        } else {
            echo json_encode([
                'homeIndex' => true,
                'homeIndexSay' => 'hello world',
                'homeIndexMicroTime' => microtime(true)
            ]);
        }
    }
}