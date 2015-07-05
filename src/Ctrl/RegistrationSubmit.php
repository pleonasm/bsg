<?php
namespace Pleo\BSG\Ctrl;

use Doctrine\ORM\EntityManagerInterface;
use Pleo\BSG\Entities\User;
use Pleo\BSG\Entities\UserRepository;
use Pleo\BSG\Redirector;
use Slim\Http\Request;
use Slim\Slim;

class RegistrationSubmit
{
    private $dispname;
    private $username;
    private $password;
    private $phone;
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var Redirector
     */
    private $redirector;

    /**
     * @param Request $request
     * @param UserRepository $userRepository
     * @param Redirector $redirector
     */
    public function __construct(Request $request, UserRepository $userRepository, Redirector $redirector)
    {
        $this->dispname = $request->post('dispname');
        $this->username = $request->post('username');
        $this->password = $request->post('password');
        $this->phone = $request->post('phone');
        $this->userRepository = $userRepository;
        $this->redirector = $redirector;
    }

    public function __invoke()
    {
        // validation goes here
        $this->userRepository->newUserUnsafe($this->dispname, $this->username, $this->password, $this->phone);
        $this->redirector->redirect(303, '/');
    }
}
