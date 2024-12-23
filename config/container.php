<?php

use App\Middleware\ExceptionMiddleware;
use App\Renderer\JsonRenderer;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\ORMSetup;
use Nyholm\Psr7\Factory\Psr17Factory;
use Psr\Container\ContainerInterface;
use Psr\Http\Message\ResponseFactoryInterface;
use Selective\BasePath\BasePathMiddleware;
use Slim\App;
use Slim\Interfaces\RouteParserInterface;
use Symfony\Component\Cache\Adapter\ArrayAdapter;
use Symfony\Component\Cache\Adapter\FilesystemAdapter;

// Container de Injeção de Dependência

return [
    'settings' => require __DIR__ . '/settings.php',
    App::class => require __DIR__ . '/app.php',

    ResponseFactoryInterface::class => function (ContainerInterface $container) {
        return $container->get(Psr17Factory::class);
    },

    RouteParserInterface::class => function (ContainerInterface $container) {
        return $container->get(App::class)->getRouteCollector()->getRouteParser();
    },

    BasePathMiddleware::class => function (ContainerInterface $container) {
        return new BasePathMiddleware($container->get(App::class));
    },

    ExceptionMiddleware::class => function (ContainerInterface $container) {
        return new ExceptionMiddleware(
            $container->get(ResponseFactoryInterface::class),
            $container->get(JsonRenderer::class),
        );
    },

    EntityManager::class => function (ContainerInterface $container) {
        $doctrine = $container->get('settings')['doctrine'];
        $is_dev_mode = $_ENV['APP_ENV'] === 'dev';

        $proxy = null;
        if($is_dev_mode) {
            $proxy = $doctrine['proxy_dir'];
        }

        $cache = new FilesystemAdapter(directory: $doctrine['cache_dir']);
        if($is_dev_mode) {
            $cache = new ArrayAdapter();
        }

        $config = ORMSetup::createAttributeMetadataConfiguration(
            $doctrine['metadata_dirs'],
            $is_dev_mode,
            $proxy,
            $cache,
        );

        $connection = \Doctrine\DBAL\DriverManager::getConnection($doctrine['connection']);

        return new EntityManager($connection, $config);
    },
];
