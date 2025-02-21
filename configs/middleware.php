<?php

declare(strict_types = 1);

use Slim\App;
use App\Config;
use Slim\Views\Twig;
use Slim\Views\TwigMiddleware;
use App\Middleware\ValidationExceptionMiddleware;

return function (App $app) {
    $container = $app->getContainer();
    $config    = $container->get(Config::class);

    // Twig
    $app->add(TwigMiddleware::create($app, $container->get(Twig::class)));

    $app->add(ValidationExceptionMiddleware::class);

    // Logger
    $app->addErrorMiddleware(
        (bool) $config->get('display_error_details'),
        (bool) $config->get('log_errors'),
        (bool) $config->get('log_error_details')
    );
};
