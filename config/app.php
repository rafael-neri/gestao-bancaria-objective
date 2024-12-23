<?php

use Psr\Container\ContainerInterface;
use Slim\Factory\AppFactory;

return function (ContainerInterface $container) {
    $app = AppFactory::createFromContainer($container);

    // Registra as rotas
    (require __DIR__ . '/routes.php')($app);

    // Registra os middleware
    (require __DIR__ . '/middleware.php')($app);

    return $app;
};
