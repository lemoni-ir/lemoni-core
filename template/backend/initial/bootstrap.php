<?php
namespace backend\initial;


class bootstrap
{
    public static function boot()
    {
        spl_autoload_register(function ($class) {
            if (strpos($class, 'backend') === 0) {
                $file = realpath(dirname(__DIR__) . substr($class, strlen('backend')) . ".php");
                if ($file) {
                    require_once $file;
                    if (class_exists($class, false) or interface_exists($class, false))
                        if (method_exists($class, 'init'))
                            $class::init();
                }
            }
        }, true, true);
    }
}
bootstrap::boot();