<?php
namespace Pleo\BSG;

use Doctrine\ORM\EntityManager;
use Doctrine\ORM\Mapping\Driver\YamlDriver;
use Doctrine\ORM\Tools\Setup;

require __DIR__ . '/vendor/autoload.php';

/**
 * @return EntityManager
 * @throws \Doctrine\ORM\ORMException
 */
function getEM()
{
    $paths = [__DIR__ . '/orm'];
    $isDevMode = true;

    $dbParams = [
        'driver' => 'pdo_sqlite',
        'path' => __DIR__ . '/dat/data.sqlite'
    ];

    $driver = new YamlDriver($paths, '.yaml');
    $config = Setup::createConfiguration($isDevMode);
    $config->setMetadataDriverImpl($driver);
    $em = EntityManager::create($dbParams, $config);

    return $em;
}
