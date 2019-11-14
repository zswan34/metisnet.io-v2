<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class MakeLibClass extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'make:class {name}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a library class';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $name = $this->argument('name');
        if (!file_exists(app_path('Libs'))) {
            mkdir(app_path('Libs'));
        }

        if (file_exists(app_path('Libs/' . $name . '.php'))) {
            $this->error("Class \"{$name}\" already exists.");
        } else {
            $file = fopen(app_path('Libs/' . $name . '.php'), "w") or die("Unable to open file!");

            $txt ="<?php \n\nnamespace App\\Libs;\n\nclass {$name} {\n\t//\n}";
            $data = rtrim($txt);
            fwrite($file, $data);
            fclose($file);
            $this->info("{$name} created successfully!");
        }
    }
}
