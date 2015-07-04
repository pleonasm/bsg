<?php
namespace Pleo\BSG\Ctrl;

use Pleo\BSG\LoginGuard;
use Slim\Slim;
use Slim\View;

class GameListPage
{
    /**
     * @param Slim $slim
     */
    public function __construct(Slim $slim)
    {
        /** @var LoginGuard loginGuard */
        $this->loginGuard = $slim->container->get('login-guard');
        /** @var View view */
        $this->view = $slim->view();
    }

    public function __invoke()
    {
        if (!call_user_func($this->loginGuard)) {
            return;
        }
        $this->view->display('games.html');
    }
}