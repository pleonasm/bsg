<?php
namespace Pleo\BSG;

use Pleo\BSG\Ctrl\GameCreatePage;
use Pleo\BSG\Ctrl\GameCreatePageSubmit;
use Pleo\BSG\Ctrl\GameListPage;
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

$slim->container->singleton('em',               function () {             return getEM();                         });
$slim->container->singleton('redirector',       function () use ($slim) { return new Redirector($slim);           });
$slim->container->singleton('session',          function () {             return new Session;                     });
$slim->container->singleton('page-home',        function () use ($slim) { return new HomePageSubmit($slim);       });
$slim->container->singleton('page-register',    function () use ($slim) { return new RegisterPageSubmit($slim);   });
$slim->container->singleton('page-game-list',   function () use ($slim) { return new GameListPage($slim);         });
$slim->container->singleton('page-game-create', function () use ($slim) { return new GameCreatePage($slim);       });
$slim->container->singleton('page-game-submit', function () use ($slim) { return new GameCreatePageSubmit($slim); });
$slim->container->singleton('login-context',    function () use ($slim) { return new LoginContext($slim);         });
$slim->container->singleton('login-guard',      function () use ($slim) { return new LoginGuard($slim);           });


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

$slim->get('/games', function () use ($slim) {
    /** @var GameListPage $ctrl */
    $ctrl = $slim->container->get('page-game-list');
    $ctrl();
});

$slim->get('/games/create', function () use ($slim) {
    /** @var GameCreatePage $ctrl */
    $ctrl = $slim->container->get('page-game-create');
    $ctrl();
});

$slim->post('/games/create', function () use ($slim) {
    /** @var GameCreatePageSubmit $ctrl */
    $ctrl = $slim->container->get('page-game-submit');
    $ctrl();
});

$slim->run();
