<?php
namespace Pleo\BSG;

use Slim\Slim;
use Symfony\Component\Config\FileLocatorInterface;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Yaml\Yaml;

class RouteLoader
{
    /**
     * @var Slim
     */
    private $app;

    /**
     * @var ContainerBuilder
     */
    private $dic;

    private $file;

    /**
     * @param Slim $app
     * @param ContainerBuilder $dic
     * @param string $definitionFile
     */
    public function __construct(Slim $app, ContainerBuilder $dic, $definitionFile)
    {
        $this->app = $app;
        $this->dic = $dic;
        $this->file = $definitionFile;
    }

    public function load()
    {
        $parser = new Yaml;
        $definitions = $parser->parse($this->file);

        foreach ($definitions as $methodAndUrl => $middlewareKeys) {
            list($method, $url) = $this->splitMethodAndUrl($methodAndUrl);
            $callableStack = $this->convertMiddlewareKeysToCallables($middlewareKeys);
            array_unshift($callableStack, $url);
            call_user_func_array(array($this->app, $method), $callableStack);
        }
    }

    /**
     * @param string $methodAndUrl
     * @return string[]
     */
    private function splitMethodAndUrl($methodAndUrl)
    {
        $methodAndUrl = explode(' ', $methodAndUrl);
        $method = strtolower(array_shift($methodAndUrl));
        $url = array_pop($methodAndUrl);

        return array($method, $url);
    }

    /**
     * @param string[] $middlewareKeys
     * @return callable[]
     */
    private function convertMiddlewareKeysToCallables(array $middlewareKeys)
    {
        $dic = $this->dic;

        $pageHandler = array_pop($middlewareKeys);

        foreach ($middlewareKeys as &$key) {
            $serviceName = $key;
            $key = function () use ($dic, $serviceName) {
                /** @var callable $middleware */
                $middleware = $dic->get($serviceName);
                call_user_func($middleware);
            };
        }

        $pageBootstrap = function () use ($pageHandler, $dic) {
            /** @var callable $pageHandler */
            $pageHandler = $dic->get($pageHandler);
            call_user_func($pageHandler);
        };

        $middlewareKeys[] = $pageBootstrap;

        return $middlewareKeys;
    }
}
