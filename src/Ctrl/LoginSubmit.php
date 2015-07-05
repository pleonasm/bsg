<?php
namespace Pleo\BSG\Ctrl;

use Pleo\BSG\Entities\UserRepository;
use Pleo\BSG\LoginContext;
use Pleo\BSG\Redirector;
use Pleo\BSG\Session;
use Slim\Http\Request;
use Slim\View;

class LoginSubmit
{
    /**
     * @var View
     */
    private $view;

    /**
     * @var string
     */
    private $username;

    /**
     * @var string
     */
    private $password;

    /**
     * @var Redirector
     */
    private $redir;

    /**
     * @var Session
     */
    private $session;

    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @param View $view
     * @param Request $request
     * @param UserRepository $userRepository
     * @param Session $session
     * @param Redirector $redir
     */
    public function __construct(View $view, Request $request, UserRepository $userRepository, Session $session, Redirector $redir)
    {
        $this->view = $view;
        $this->username = $request->post('username');
        $this->password = $request->post('password');
        $this->userRepository = $userRepository;
        $this->session = $session;
        $this->redir = $redir;
    }

    public function __invoke()
    {
        $user = $this->userRepository->authenticate($this->username, $this->password);
        if (false !== $user) {
            $this->session->set(LoginContext::LOGIN_VAR, $user->id());
            $this->redir->redirect(303, '/games');
            return;
        }

        $this->view->display('home.html', ['msg' => 'Invalid login']);
    }
}
