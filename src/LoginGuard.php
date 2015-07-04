<?php
namespace Pleo\BSG;

use Slim\Slim;

class LoginGuard
{
    /**
     * @var LoginContext
     */
    private $loginContext;

    /**
     * @var Redirector
     */
    private $redir;

    /**
     * @param Slim $slim
     */
    public function __construct(Slim $slim)
    {
        /** @var LoginContext $loginContext */
        $loginContext = $slim->container->get('login-context');
        /** @var Redirector $redir */
        $redir = $slim->container->get('redirector');

        $this->loginContext = $loginContext;
        $this->redir = $redir;
    }

    /**
     *
     */
    public function __invoke()
    {
        $loggedIn = call_user_func($this->loginContext);
        if (!$loggedIn) {
            call_user_func($this->redir, 303, '/');
            return false;
        }
        return true;
    }
}
