<?php

use Symfony\Component\Dotenv\Dotenv;

require dirname(__DIR__).'/vendor/autoload.php';

function execute_command($cmd) {
    $exitCode = 0;
    passthru(sprintf('APP_ENV=test php %s/../bin/console ', __DIR__). $cmd, $exitCode);

    if ($exitCode !== 0) {
        exit($exitCode);
    }
}

execute_command('doctrine:database:drop --force --if-exists --no-interaction');
execute_command('doctrine:database:create --no-interaction');
execute_command('doctrine:migrations:migrate --no-interaction -q');
execute_command('cache:clear');

if (file_exists(dirname(__DIR__).'/config/bootstrap.php')) {
    require dirname(__DIR__).'/config/bootstrap.php';
} elseif (method_exists(Dotenv::class, 'bootEnv')) {
    (new Dotenv())->bootEnv(dirname(__DIR__).'/.env');
}
