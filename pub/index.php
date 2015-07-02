<?php
namespace Pleo\BSG;

use Doctrine\ORM\EntityManagerInterface;
use Pleo\BSG\Entities\User;
use Pleo\BSG\Entities\UserRepository;
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
$slim->container->singleton('em', function () {
    return getEM();
});
$slim->container->set('redirector', function () use ($slim) {
    $scheme = $slim->request()->getScheme();
    $host = $slim->request()->getHost();
    $port = $slim->request()->getPort();
    $response = $slim->response();

    if ('http' === $scheme && 80 !== $port) {
        $host .= ':' . $port;
    }
    if ('https' === $scheme && 443 !== $port) {
        $host .= ':' . $port;
    }

    return function ($status, $urlPath) use ($scheme, $host, $response) {
        $urlPath = ltrim($urlPath, '/');
        $baseUrl = $scheme . '://' . $host . '/' . $urlPath;
        $response->status($status);
        $response->header('Location', $baseUrl);
    };
});

$slim->get('/', function () use ($slim) {
    $slim->render('home.html');
});

$slim->post('/', function () use ($slim) {
    $u = $slim->request()->post('username');
    $p = $slim->request()->post('password');
    /** @var EntityManagerInterface $em */
    $em = $slim->container->get('em');
    /** @var UserRepository $repo */
    $repo = $em->getRepository('Pleo\\BSG\\Entities\\User');
    /** @var callable $redir */
    $redir = $slim->container->get('redirector');

    $user = $repo->authenticate($u, $p);
    if (false !== $user) {
        $redir(303, '/dashboard');
        return;
    }

    $slim->render('home.html', ['msg' => 'Invalid login']);
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
    $slim->render('dashboard.html');
});

$slim->run();
