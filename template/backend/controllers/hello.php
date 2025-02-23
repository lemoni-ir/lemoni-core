<?php

namespace backend\controllers;

class hello
{
    /**
     * Returns a JSON message saying hello world.
     *
     * @return void
     */
    public function actionWorld()
    {
        echo json_encode([
            'helloWorld' => true,
        ]);
    }
}