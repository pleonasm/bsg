<?php
namespace Pleo\BSG;

use Doctrine\ORM\EntityManagerInterface;
use Pleo\BSG\Ctrl\HomePageSubmit;
use Pleo\BSG\Entities\User;
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


$slim->container->singleton('em', function () {                      return getEM();                    });
$slim->container->singleton('redirector', function () use ($slim) {  return new Redirector($slim);      });
$slim->container->singleton('session', function () {                 return new Session;                });
$slim->container->singleton('page-home', function () use ($slim) {   return new HomePageSubmit($slim);  });


$slim->get('/', function () use ($slim) {
    $slim->render('home.html');
});

$slim->post('/', function () use ($slim) {
    /** @var HomePageSubmit $ctrl */
    $ctrl = $slim->container->get('page-home');
    $ctrl();
});

$slim->get('/register', function () use ($slim) {
    $slim->render('register.html');
});

$slim->post('/register', function () use ($slim) {
    $dispname = $slim->request()->post('dispname');
    $username = $slim->request()->post('username');
    $password = $slim->request()->post('password');
    $phone = $slim->request()->post('phone');
    /** @var EntityManagerInterface $em */
    $em = $slim->container->get('em');
    /** @var callable $redir */
    $redir = $slim->container->get('redirector');

    $id = mt_rand(0, mt_getrandmax());
    $user = new User($id, $dispname, $username, $password, $phone);
    $em->persist($user);
    $em->flush();
    $redir(303, '/');
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
