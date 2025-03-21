<?php
namespace backend\console;
class controller
{
    public static function create($api, $force = "")
    {
        if ($api[0] === '/')
            $api = substr($api, 1);
        $api_name_array = explode('/', $api);
        if (count($api_name_array) < 2)
            die('api name error.');
        $namespace = implode('\\', array_merge(['backend\controllers'], array_slice($api_name_array, 0, -2)));
        $class_name = $api_name_array[count($api_name_array) - 2];
        $method_name = ucfirst($api_name_array[count($api_name_array) - 1]);
        $file_path = dirname(__DIR__) . '/controllers/' . implode(
            '/',
            array_slice($api_name_array, 0, -1)
        ) . '.php';
        $file_dir = dirname($file_path);


        if (is_file($file_path) and $force !== '-f')
        die('file already exists.');
    if (!is_dir($file_dir))
        mkdir($file_dir, 0755, true);



        $file_code = [];
        $file_code[] = '<?php';
        $file_code[] = "namespace $namespace;";
        $file_code[] = "class $class_name {";
        $file_code[] = "\tpublic static function action$method_name() {";
        $file_code[] = "\t\techo json_encode([]);";
        $file_code[] = "\t}";
        $file_code[] = "}";
        fwrite(fopen($file_path, 'w+'), implode("\n", $file_code));
        echo "\n\n" . realpath($file_path) . "\n\n";
    }

}