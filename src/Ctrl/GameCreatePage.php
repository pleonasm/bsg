<?php
namespace Pleo\BSG\Ctrl;

use Pleo\BSG\LoginGuard;
use Slim\Slim;
use Slim\View;

class GameCreatePage
{
    public function __construct(Slim $slim)
    {
        /** @var LoginGuard $loginGuard */
        $loginGuard = $slim->container->get('login-guard');
        /** @var View loginGuard */
        $view = $slim->view();

        $this->loginGuard = $loginGuard;
        $this->view = $view;
    }

    public function __invoke()
    {
        if (!call_user_func($this->loginGuard)) {
            return;
        }
        $this->view->display('games-create.html');
    }
}