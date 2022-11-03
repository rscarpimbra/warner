<?php

session_start();
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING | E_DEPRECATED));



use Dotenv\Dotenv;
use Slim\Views\Twig;
use Slim\Flash\Messages;
use Slim\Csrf\Guard;
use Slim\Factory\AppFactory;
use Slim\Views\TwigExtension;
use Slim\Psr7\Factory\UriFactory;
use Dotenv\Exception\InvalidPathException;


use app\functions\FCheckIsLoged;
use app\functions\FCheckCSRF;



require_once __DIR__ . '/../vendor/autoload.php';

try {
    (new Dotenv(__DIR__ . '/../'))->load();
} catch (InvalidPathException $e) {
    //
}

$container = new DI\Container();

AppFactory::setContainer($container);

$app = AppFactory::create();

$container->set('settings', function () {
    return [
        'app' => [
            'name' => getenv('APP_NAME')
        ]
    ];
});

/* Adding the CSRF Protection */
$container->set('csrf', function () use ($app){

    return new Guard($app->getResponseFactory());
});

$container->set('view', function ($container) use ($app) {

    /* Defining all the Paths to the Views/Layouts/Partials and so on */
    $toPaths = [
        __DIR__ . "/../resources/forms",
        __DIR__ . "/../resources/layouts",
        __DIR__ . "/../resources/partials",
        __DIR__ . "/../resources/views",
                
                __DIR__ . "/../resources/views/panel",
                __DIR__ . "/../resources/views/site"
        
    ];
    $twig = new Twig($toPaths, [
        'cache' => false
    ]);

    /* Adding Custom Functions  */
    $twig->addExtension(
        new TwigExtension(
            $app->getRouteCollector()->getRouteParser(),
            (new UriFactory)->createFromGlobals($_SERVER),
            '/'
        )
    );

    /* Adding the Function to Check if the User is Logged. */
    $twig->addExtension(new FCheckIsLoged);

    /* Adding the csrf Checking  */
    $twig->addExtension(new FCheckCSRF($container->get('csrf')));

    return $twig;
});

/* Adding Flash Messages. */
$container->set('flash', function (){

    return  new Messages();
});



$app->add('csrf');

/* Better Errors. */
$errorMiddleware = $app->addErrorMiddleware(true, true, true);


require_once __DIR__ . '/../routes/web.php';
require_once __DIR__ . '/../app/models/dbIlluminatiCon.php';
