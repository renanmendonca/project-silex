<?php

use Silex\Application;
use Silex\Provider\ServiceControllerServiceProvider;
use Symfony\Component\HttpFoundation\Response;
use InstagramRest\Repository\InstagramRepository;
use InstagramRest\Controller\InstagramController;

$app = new Application();
$app->register(new ServiceControllerServiceProvider());

// Register View Engine
$app['mustache'] = new Mustache_Engine(
    [
    'loader' => new Mustache_Loader_FilesystemLoader('app/Views', ['extension' => '.html']),
    ]
);

// Register repositories
$app['instagram.repository'] = $app->share(function() use ($app) {
    return new InstagramRepository($app['instagram.base_uri']);
});

// Register controller
$app['instagram.controller'] = $app->share(function() use ($app) {
    return new InstagramController($app['instagram.repository'],$app['instagram.access_token']);
});

// Register the error handler
$app->error(function (\Exception $e, $code) use ($app) {
    if ($app['debug']) {
        return;
    }
    switch ($code) {
        case 404:
            $message = 'The requested page could not be found.';
            break;
        default:
            $message = 'We are sorry, but something went terribly wrong.';
    }
    return new Response($message, $code);
});

return $app;
