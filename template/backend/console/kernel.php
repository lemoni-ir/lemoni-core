<?php

namespace backend\console;


class kernel
{
    protected array $commands = [
        'model' => ['backend\\console\\model', 'create'],
        'controller' => ['backend\\console\\controller', 'create'],
        'api' => ['backend\\console\\controller', 'create'],

    ];

    public function handle($argv)
    {
        array_shift($argv);
        $command = $argv[0] ?? null;
        $param = array_slice($argv, 1) ?? [];

        if (!$command or !@$this->commands[$command]) {
            die("Invalid command! Available commands: " . implode(', ', array_keys($this->commands)) . "\n");
        }

        try {
            call_user_func_array(array($this->commands[$command][0], $this->commands[$command][1]), $param);
        } catch (\Throwable $th) {
            die("command error.\n" . $th->getMessage());
        }
    }
}
