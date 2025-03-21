<?php
namespace backend;

use lemoni\database\mysql\model;

class application
{

    public static string $controller = '', $method = '';
    public static array $parameters = [];

    public static function up()
    {
        model::connect($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASS']);
    }
    public static function down()
    {
    }

}