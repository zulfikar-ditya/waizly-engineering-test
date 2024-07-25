<?php

namespace App\Console\Commands\Services;

use App\Support\Str;
use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\Artisan;
use Symfony\Component\Console\Input\InputOption;

class MakeServiceTestCrudCommand extends GeneratorCommand
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $name = 'app:make-service-test-crud';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create a new service test';

    /**
     * Build the class with the given name.
     *
     * @param  string  $name
     * @return string
     *
     * @throws \Illuminate\Contracts\Filesystem\FileNotFoundException
     */
    protected function buildClass($name)
    {
        $stub = $this->replaceModel(parent::buildClass($name), $this->option('model'));

        return $stub;
    }

    /**
     * Replace the model for the given stub.
     *
     * @param  string  $stub
     * @param  string  $model
     * @return string
     */
    protected function replaceModel($stub, $model)
    {
        $model = str_replace('/', '\\', $model);

        if (str_starts_with($model, '\\')) {
            $namespacedModel = trim($model, '\\');
        } else {
            $namespacedModel = $this->qualifyModel($model);
        }

        $model = class_basename(trim($model, '\\'));

        $dummyUser = class_basename($this->userProviderModel());

        $dummyModel = Str::camel($model) === 'user' ? 'model' : $model;

        // create store update request
        $storeRequest = '\\Tests\\' . $model . "\\"  . 'Store' . $model . 'Request';
        $storeRequestNamespace = 'App\\Http\\Requests' .  $storeRequest;

        // create update request
        $updateRequest = '\\Tests\\' . $model . "\\"  . 'Update' . $model . 'Request';
        $updateRequestNamespace = 'App\\Http\\Requests' .  $updateRequest;

        Artisan::call('make:request', [
            'name' => $storeRequest,
        ]);

        Artisan::call('make:request', [
            'name' => $updateRequest,
        ]);

        // model get table mysql name
        $tableName = Str::plural(Str::snake($model));

        $replace = [
            'NamespacedDummyModel' => $namespacedModel,
            '{{ namespacedModel }}' => $namespacedModel,
            '{{namespacedModel}}' => $namespacedModel,
            'DummyModel' => $model,
            '{{ model }}' => $model,
            '{{model}}' => $model,
            'dummyModel' => Str::camel($dummyModel),
            '{{ modelVariable }}' => Str::camel($dummyModel),
            '{{modelVariable}}' => Str::camel($dummyModel),
            'DummyUser' => $dummyUser,
            '{{ user }}' => $dummyUser,
            '{{user}}' => $dummyUser,
            '$user' => '$' . Str::camel($dummyUser),
            'tableName' => $tableName,
            '{{tableName}}' => $tableName,
            '{{ tableName }}' => $tableName,

            'storeRequestNamespace' => $storeRequestNamespace,
            '{{storeRequestNamespace}}' => $storeRequestNamespace,
            'updateRequestNamespace' => $updateRequestNamespace,
            '{{updateRequestNamespace}}' => $updateRequestNamespace,
        ];

        $stub = str_replace(
            array_keys($replace),
            array_values($replace),
            $stub
        );

        return preg_replace(
            vsprintf('/use %s;[\r\n]+use %s;/', [
                preg_quote($namespacedModel, '/'),
                preg_quote($namespacedModel, '/'),
            ]),
            "use {$namespacedModel};",
            $stub
        );
    }

    /**
     * Get the stub file for the generator.
     *
     * @return string
     */
    protected function getStub()
    {
        return base_path('stubs/services/service-crud-test.stub');
    }

    /**
     * Get the destination class path.
     *
     * @param  string  $name
     * @return string
     */
    protected function getPath($name)
    {
        $name = Str::replaceFirst($this->rootNamespace(), '', $name);

        return base_path('tests') . str_replace('\\', '/', $name) . '.php';
    }

    /**
     * Get the default namespace for the class.
     *
     * @param  string  $rootNamespace
     * @return string
     */
    protected function getDefaultNamespace($rootNamespace)
    {
        return $rootNamespace . "\Unit\Services";
    }

    /**
     * Get the root namespace for the class.
     *
     * @return string
     */
    protected function rootNamespace()
    {
        return 'Tests';
    }

    /**
     * Get the console command options.
     */
    protected function getOptions()
    {
        return [
            ['model', '-m', InputOption::VALUE_REQUIRED, 'The model field'],
            ['repository', '-r', InputOption::VALUE_OPTIONAL, 'The repository class'],
        ];
    }
}
