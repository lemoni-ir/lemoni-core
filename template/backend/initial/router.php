<?php
use backend\application;


use lemoni\header\url;
use lemoni\router\router;

if (AJAX) {

    url::regex('#^/$#', function () {
        router::set('home');
    });

    url::regex('#^\/.+\/.+$#', function ($url, $regex) {
        $u = array_values(array_filter(explode('/', $url), 'strlen'));
        $c = implode('/', array_slice($u, 0, -1));
        $m = array_slice($u, -1)[0];
        router::set($c, $m);
    });



} else {
    application::$controller = 'home';
    application::$method = 'index';
}
