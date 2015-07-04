<?php
namespace Pleo\BSG;

use Pleo\BSG\Ctrl\HomePageSubmit;
use Pleo\BSG\Ctrl\RegisterPageSubmit;
use Slim\Log;
use Slim\Slim;

require_once __DIR__ . '/../bootstrap.php';

$settings = [
    'mode' => 'development',
    'debug' => true,
    'log.level' => Log::DEBUG,
    'log.enabled' => true,
    'templates.path' => __DIR__ . '/../tpl',
];

$slim = new Slim($settings);


$slim->container->singleton('em',            function () {             return getEM();                       });
$slim->container->singleton('redirector',    function () use ($slim) { return new Redirector($slim);         });
$slim->container->singleton('session',       function () {             return new Session;                   });
$slim->container->singleton('page-home',     function () use ($slim) { return new HomePageSubmit($slim);     });
$slim->container->singleton('page-register', function () use ($slim) { return new RegisterPageSubmit($slim); });


$slim->get('/', function () use ($slim) {
    $slim->render('home.html');
});

$slim->post('/', function () use ($slim) {
    /** @var HomePageSubmit $ctrl */
    $ctrl = $slim->container->get('page-home');
    $ctrl();
});

$slim->get('/logout', function () use ($slim) {
    /** @var Redirector $redir */
    $redir = $slim->container->get('redirector');
    /** @var Session $session */
    $session = $slim->container->get('session');

    $session->destroy();
    $redir(303, '/');
});

$slim->get('/register', function () use ($slim) {
    $slim->render('register.html');
});

$slim->post('/register', function () use ($slim) {
    /** @var RegisterPageSubmit $ctrl */
    $ctrl = $slim->container->get('page-register');
    $ctrl();
});

$slim->get('/dashboard', function () use ($slim) {
    /** @var Session $session */
    $session = $slim->container->get('session');
    /** @var callable $redir */
    $redir = $slim->container->get('redirector');

    if (!$session->get('login')) {
        $redir(303, '/');
        return;
    }
    $slim->render('dashboard.html');
});

$slim->run();
