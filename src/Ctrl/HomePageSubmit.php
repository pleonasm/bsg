<?php
namespace Pleo\BSG\Ctrl;

use Doctrine\ORM\EntityManagerInterface;
use Pleo\BSG\Entities\UserRepository;
use Pleo\BSG\LoginContext;
use Pleo\BSG\Redirector;
use Pleo\BSG\Session;
use Slim\Slim;

class HomePageSubmit
{
    private $username;
    private $password;
    private $repo;
    private $redir;
    private $session;
    private $view;

    /**
     * @param Slim $slim
     */
    public function __construct(Slim $slim)
    {
        $this->username = $slim->request()->post('username');
        $this->password = $slim->request()->post('password');

        /** @var EntityManagerInterface $em */
        $em = $slim->container->get('em');
        /** @var UserRepository $repo */
        $repo = $em->getRepository('Pleo\\BSG\\Entities\\User');
        /** @var Redirector $redir */
        $redir = $slim->container->get('redirector');
        /** @var Session $session */
        $session = $slim->container->get('session');

        $this->repo = $repo;
        $this->redir = $redir;
        $this->session = $session;
        $this->view = $slim->view();
    }

    public function __invoke()
    {
        $user = $this->repo->authenticate($this->username, $this->password);
        if (false !== $user) {
            $this->session->set(LoginContext::LOGIN_VAR, $user->id());
            call_user_func($this->redir, 303, '/games');
            return;
        }

        $this->view->display('home.html', ['msg' => 'Invalid login']);
    }
}
