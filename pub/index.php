<?php
namespace Pleo\BSG;

use Exception;
use Pleo\BSG\Ctrl\GameCreatePage;
use Pleo\BSG\Ctrl\GameCreatePageSubmit;
use Pleo\BSG\Ctrl\GameListPage;
use Pleo\BSG\Ctrl\HomePageSubmit;
use Pleo\BSG\Ctrl\RegisterPageSubmit;
use Slim\Log;
use Slim\Slim;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBag;
use Symfony\Component\Yaml\Yaml;

$root = implode('/', array_slice(explode('/', __DIR__), 0, -1));
require $root . '/vendor/autoload.php';

$parser = new Yaml();
$config = $parser->parse(file_get_contents($root . '/cfg/config.yml'));
$config = new ParameterBag($config);

$dic = new ContainerBuilder($config);
$locator = new FileLocator([$root . '/cfg']);
$dil = new YamlFileLoader($dic, $locator);
$dil->load('main.di.yml');
$dil->load('app.di.yml');
$dil->load('pages.di.yml');
$dic->setParameter('root', $root);
$dic->set('dic', $dic);

/** @var Slim $app */
$app = $dic->get('app');
$app->run();
