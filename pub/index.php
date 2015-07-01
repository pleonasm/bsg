<?php
namespace Pleo\BSG;

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
$em = getEM();

$slim->get('/', function () use ($slim) {
    $slim->render('home.html');
});

$slim->get('/register', function () use ($slim) {
    $slim->render('register.html');
});

$slim->post('/register', function () use ($slim, $em) {
    $id = mt_rand(0, mt_getrandmax());
    $dispname = $slim->request()->post('dispname');
    $username = $slim->request()->post('username');
    $password = $slim->request()->post('password');
    $phone = $slim->request()->post('phone');
    $user = new User($id, $dispname, $username, $password, $phone);
    $em->persist($user);
    $em->flush();
    $slim->response()->status(303);
    $slim->response()->header('Location', $slim->request()->getScheme() . '://' . $slim->request()->getHostWithPort() . '/');
});

$slim->run();
