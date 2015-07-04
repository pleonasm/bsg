<?php
namespace Pleo\BSG\Ctrl;

use Doctrine\ORM\EntityManagerInterface;
use Pleo\BSG\Entities\User;
use Pleo\BSG\Redirector;
use Slim\Slim;

class RegisterPageSubmit
{
    private $dispname;
    private $username;
    private $password;
    private $phone;
    private $em;
    private $redir;

    /**
     * @param Slim $slim
     */
    public function __construct(Slim $slim)
    {
        $this->dispname = $slim->request()->post('dispname');
        $this->username = $slim->request()->post('username');
        $this->password = $slim->request()->post('password');
        $this->phone = $slim->request()->post('phone');

        /** @var EntityManagerInterface $em */
        $em = $slim->container->get('em');
        /** @var Redirector $redir */
        $redir = $slim->container->get('redirector');

        $this->em = $em;
        $this->redir = $redir;
    }

    public function __invoke()
    {
        // validation goes here

        $id = mt_rand(0, mt_getrandmax());
        $user = new User($id, $this->dispname, $this->username, $this->password, $this->phone);
        $this->em->persist($user);
        $this->em->flush();
        call_user_func($this->redir, 303, '/');
    }
}
