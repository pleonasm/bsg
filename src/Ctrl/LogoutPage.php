<?php
namespace Pleo\BSG\Ctrl;

use Pleo\BSG\Redirector;
use Pleo\BSG\Session;

class LogoutPage
{
    /**
     * @var Session
     */
    private $session;
    /**
     * @var Redirector
     */
    private $redirector;

    /**
     * @param Session $session
     * @param Redirector $redirector
     */
    public function __construct(Session $session, Redirector $redirector)
    {
        $this->session = $session;
        $this->redirector = $redirector;
    }

    public function __invoke()
    {
        $this->session->destroy();
        $this->redirector->redirect(303, '/');
    }
}