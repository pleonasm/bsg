<?php
namespace Pleo\BSG;

class LoginGuard
{
    /**
     * @var LoginContext
     */
    private $loginContext;
    /**
     * @var Redirector
     */
    private $redirector;

    /**
     * @param LoginContext $loginContext
     * @param Redirector $redirector
     */
    public function __construct(LoginContext $loginContext, Redirector $redirector)
    {
        $this->loginContext = $loginContext;
        $this->redirector = $redirector;
    }

    /**
     *
     */
    public function __invoke()
    {
        $loggedIn = $this->loginContext->currentUser();

        if (!$loggedIn) {
            $this->redirector->redirect(303, '/');
            return false;
        }
        return true;
    }
}
