<?php

use DI\ContainerBuilder;
use Slim\App;

try {
    // Define o diretório raiz do projeto
    define("APP_ROOT", __DIR__ . '/..');

    // Define o fuso horário padrão
    date_default_timezone_set('America/Sao_Paulo');

    // Carrega o autoloader do Composer
    require_once APP_ROOT . '/vendor/autoload.php';

    // Carrega as variáveis de ambiente do arquivo .env
    if (file_exists(APP_ROOT . '/.env')) {
        $dotenv = Dotenv\Dotenv::createUnsafeMutable(APP_ROOT, '.env');
        $dotenv->load();
    }

    // Define o modo de exibição de erros
    if ($_ENV['APP_ENV'] === 'dev') {
        error_reporting(E_ALL);
        ini_set('display_errors', true);
        ini_set('display_startup_errors', true);
    } else {
        error_reporting(0);
        ini_set('display_errors', false);
        ini_set('display_startup_errors', false);
    }

    $container = (new ContainerBuilder())
        ->addDefinitions(__DIR__ . '/container.php')
        ->build();

    return $container->get(App::class);

} catch (Throwable $e) {
    die($e->getMessage());
}
