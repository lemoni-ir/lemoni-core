<?php
namespace backend\console;
class model
{
    /**
     * Create a new model file
     *
     * @param string $model_name
     * @param string $force
     * @return void
     */
    public static function create($model_name, $force = "")
    {
        $model_name_array = explode('_', $model_name);
        $namespace = implode('\\', array_merge(['backend\models'], array_slice($model_name_array, 0, -1)));
        $class_name = $model_name_array[count($model_name_array) - 1];
        $file_path = dirname(__DIR__) . '/models/' . implode('/', $model_name_array) . '.php';
        $file_dir = dirname($file_path);


        if (is_file($file_path) and $force !== '-f')
            die('file already exists.');
        if (!is_dir($file_dir))
            mkdir($file_dir, 0755, true);


        $file_code = [];
        $file_code[] = '<?php';
        $file_code[] = "namespace $namespace;\n";
        $file_code[] = "\n\n";
        $file_code[] = "use lemoni\database\mysql\migartion;\n";
        $file_code[] = "use lemoni\database\mysql\\table\create;\n";
        $file_code[] = "use lemoni\database\mysql\\table\crud;\n";
        $file_code[] = "\n\n";

        $file_code[] = "class $class_name extends crud {\n";
        $file_code[] = "\tpublic \$statuses = ['draft', 'publish', 'deleted', 'active', 'inactive'];\n";
        $file_code[] = "\tpublic function __construct() {\n";
        $file_code[] = "\t\tparent::__construct();\n";
        $file_code[] = "\t\t\$create_table = (new create)\n";
        $file_code[] = "\t\t\t->column('id')->autoIncrement()->bigInt()->primary()\n";
        $file_code[] = "\t\t\t->column('token')->unique()->varchar(16)->default(null)\n";
        $file_code[] = "\t\t\t->column('status')->enum(\$this->statuses)->default(\$this->statuses[0])\n";
        $file_code[] = "\t\t\t->column('create_time')->bigInt()->unsigned()\n";
        $file_code[] = "\t\t\t->column('update_time')->bigInt()->unsigned()->default(null)\n";
        $file_code[] = "\t\t\t->query(\$this->table());\n";


        $file_code[] = "\t\t\tmigartion::exe(\$this, [\n";
        $file_code[] = "\t\t\t\$create_table,\n";
        $file_code[] = "\t\t\t'CREATE TRIGGER update_time BEFORE UPDATE ON @TABLE FOR EACH ROW SET NEW.update_time = UNIX_TIMESTAMP();'\n";
        $file_code[] = "\t\t]);";
        $file_code[] = "\t}";

        $file_code[] = "\t\tpublic function delete(){return \$this->update(['status' => 'deleted']);}";
        $file_code[] = "}";

        fwrite(fopen($file_path, 'w+'), implode("\n", $file_code));
        echo "\n\n" . realpath($file_path) . "\n\n";
    }
}