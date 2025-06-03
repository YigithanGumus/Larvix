<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;

class MakeRepository extends Command
{
    protected $signature = 'make:repository
                            {name : The name of the repository}
                            {--model= : Model name to bind to the repository}';

    protected $description = 'Create a new repository class with interface';

    public function handle()
    {
        $name = $this->argument('name');
        $modelOption = $this->option('model');
        $modelName = $modelOption ?: 'Model';

        $repositoryName = Str::studly($name) . 'Repository';
        $interfaceName = 'I' . Str::studly($name) . 'Repository';

        $basePath = app_path('Repositories');
        $repositoryPath = $basePath . '/' . $repositoryName;
        $interfacePath = $repositoryPath . '/Interfaces';

        // Klasörleri oluştur
        if (!File::exists($repositoryPath)) {
            File::makeDirectory($repositoryPath, 0755, true);
        }

        if (!File::exists($interfacePath)) {
            File::makeDirectory($interfacePath, 0755, true);
        }

        // Repository dosyasını oluştur
        $repositoryFile = $repositoryPath . '/' . $repositoryName . '.php';
        if (!File::exists($repositoryFile)) {
            File::put($repositoryFile, $this->getRepositoryContent($repositoryName, $interfaceName, $modelName));
            $this->info("Created: {$repositoryFile}");
        } else {
            $this->warn("Repository already exists: {$repositoryFile}");
        }

        // Interface dosyasını oluştur
        $interfaceFile = $interfacePath . '/' . $interfaceName . '.php';
        if (!File::exists($interfaceFile)) {
            File::put($interfaceFile, $this->getInterfaceContent($interfaceName));
            $this->info("Created: {$interfaceFile}");
        } else {
            $this->warn("Interface already exists: {$interfaceFile}");
        }
    }

    protected function getRepositoryContent($repositoryName, $interfaceName, $modelClass)
    {
        $modelClass = $modelClass ?: 'Model';
        $modelVariable = lcfirst(class_basename($modelClass));
        $modelNamespace = $modelClass === 'Model'
            ? 'Illuminate\\Database\\Eloquent\\Model'
            : "App\\Models\\$modelClass";

        return <<<PHP
<?php

namespace App\Repositories\\$repositoryName;

use App\Repositories\BaseRepository\BaseRepository;
use App\Repositories\\$repositoryName\\Interfaces\\$interfaceName;
use $modelNamespace;

class $repositoryName extends BaseRepository implements $interfaceName
{
    public function __construct($modelClass \$$modelVariable)
    {
        parent::__construct(\$$modelVariable);
    }

    public function all()
    {
        return \$this->model->all();
    }

    public function find(\$id)
    {
        return \$this->model->find(\$id);
    }

    public function create(array \$data)
    {
        return \$this->model->create(\$data);
    }

    public function update(\$id, array \$data)
    {
        \$record = \$this->find(\$id);
        if (!\$record) {
            return null;
        }
        \$record->update(\$data);
        return \$record;
    }

    public function delete(\$id)
    {
        \$record = \$this->find(\$id);
        if (!\$record) {
            return false;
        }
        return \$record->delete();
    }
}
PHP;
    }

    public function getInterfaceContent($interfaceName)
    {
        return <<<PHP
<?php

namespace App\Repositories\\$interfaceName\\Interfaces;

interface $interfaceName
{
    public function all();
    public function find(\$id);
    public function create(array \$data);
    public function update(\$id, array \$data);
    public function delete(\$id);
}
PHP;
    }

}
