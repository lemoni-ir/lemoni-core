<?php

function _dd()
{
    call_user_func_array('_d', func_get_args());
    die;
}

function _ed()
{
    call_user_func_array('_e', func_get_args());
    die;
}

function _d()
{
    if (AJAX or lemoni\header\mime::get() === 'application/json') {
        echo json_encode(func_get_args(), JSON_PRETTY_PRINT);
    } else {
        echo '<div
    style="background:#2d2d2d; color:#f8f8f2; font-size:14px; padding:10px; margin:10px; border-radius:8px; font-family: Consolas,monospace; box-shadow: 0 0 10px rgba(0,0,0,0.5); white-space: pre-wrap;">
    ';
        foreach (func_get_args() as $arg) {
            $bgColor = is_bool($arg) ? ($arg ? '#00ff00' : '#ff4444') : '#444';
            echo '<div style="background:' . $bgColor . '; padding:5px; margin:5px; border-radius:5px; font-size:12pt;"><code>';
            var_dump($arg);
            echo '</code></div>';
        }
        echo '</div>';
    }
}

function _e()
{
    if (AJAX or lemoni\header\mime::get() === 'application/json') {
        echo json_encode(func_get_args(), JSON_PRETTY_PRINT);
    } else {
        echo '<div
    style="background:#444; color:#fff; font-size:14px; padding:10px; margin:10px; border-radius:8px; font-family: Consolas,monospace; box-shadow: 0 0 10px rgba(0,0,0,0.5); white-space: pre-wrap;">
    ';
        foreach (func_get_args() as $arg) {
            echo '<div style="background:#666; padding:5px; margin:5px; border-radius:5px; font-size:12pt;"><code>';
            var_export($arg);
            echo '</code></div>';
        }
        echo '</div>';
    }
}