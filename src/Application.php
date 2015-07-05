<?php
namespace Pleo\BSG;

use Slim\Http\Request;
use Slim\Slim;
use Symfony\Component\DependencyInjection\ContainerBuilder;

class Application
{
    /**
     * @var ContainerBuilder
     */
    private $dic;

    /**
     * @param ContainerBuilder $dic
     */
    public function __construct(ContainerBuilder $dic)
    {
        $this->dic = $dic;
    }

    /**
     *
     */
    public function run()
    {
        /** @var Slim $slim */
        $slim = $this->dic->get('slim');
        /** @var RouteLoader $router */
        $router = $this->dic->get('router');

        $router->load();
        $slim->run();
    }
}
