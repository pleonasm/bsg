<?php
namespace Pleo\BSG;

use Slim\Slim;

class SlimStop
{
    /**
     * @var Slim
     */
    private $slim;

    /**
     * @param Slim $slim
     */
    public function __construct(Slim $slim)
    {

        $this->slim = $slim;
    }

    /**
     * @return callable
     */
    public function stoppingFunction()
    {
        $slim = $this->slim;
        return function () use ($slim) {
            $slim->stop();
        };
    }
}
