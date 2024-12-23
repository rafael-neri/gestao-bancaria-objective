<?php

return function(): array {
    $settings = [];

    // Error handler
    $settings['error'] = [
        'display_error_details' => $_ENV['APP_ENV'] === 'dev',
    ];

    // Database settings
    $settings['doctrine'] = [
        'cache_dir' => APP_ROOT . '/var/doctrine/cache',
        'proxy_dir' => APP_ROOT . '/var/doctrine/proxies',
        'metadata_dirs' => [
            APP_ROOT . '/src/Domain',
        ],
        'migrations' => [
            'table_storage' => [
                'table_name' => 'migrations',
                'version_column_name' => 'version',
                'version_column_length' => 1024,
                'executed_at_column_name' => 'executed_at',
                'execution_time_column_name' => 'execution_time',
            ],
            'migrations_paths' => [
                'App\Migrations' => APP_ROOT . '/resources/migrations',
            ],
        ],
        'connection' => [
            'driver' => 'pdo_mysql',
            'host' => $_ENV['DB_HOST'],
            'port' => $_ENV['DB_PORT'],
            'dbname' => $_ENV['DB_NAME'],
            'user' => $_ENV['DB_USER'],
            'password' => $_ENV['DB_PASS'],
            'charset' => 'utf8mb4',
            'collation' => 'utf8mb4_unicode_ci',
        ],
    ];

    return $settings;
};
