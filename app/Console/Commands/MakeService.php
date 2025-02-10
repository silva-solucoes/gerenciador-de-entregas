<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Filesystem\Filesystem;

class MakeService extends Command
{
    protected $signature = 'make:service {name}';
    protected $description = 'Cria um novo Service dentro de app/Services';

    public function handle()
    {
        $name = $this->argument('name');
        $servicePath = app_path("Services/{$name}.php");

        if (file_exists($servicePath)) {
            $this->error("O Service {$name} já existe!");
            return false;
        }

        // Criar diretório Services caso não exista
        if (!is_dir(app_path('Services'))) {
            mkdir(app_path('Services'), 0755, true);
        }

        // Criar o arquivo do service
        file_put_contents($servicePath, $this->getStub($name));

        $this->info("Service {$name} criado com sucesso!");
    }

    protected function getStub($name)
    {
        return <<<EOT
<?php

namespace App\Services;

class {$name}
{
    public function handle()
    {
        // Implementação do serviço aqui
    }
}
EOT;
    }
}
