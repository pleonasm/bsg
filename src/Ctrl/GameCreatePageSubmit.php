<?php
namespace Pleo\BSG\Ctrl;

use Doctrine\ORM\EntityManagerInterface;
use Pleo\BSG\Entities\GameRepository;
use Pleo\BSG\LoginContext;
use Pleo\BSG\Redirector;
use Slim\Slim;

class GameCreatePageSubmit
{
    /**
     * @var GameRepository
     */
    private $gameRepo;

    /**
     * @var LoginContext
     */
    private $owner;
    private $title;
    private $redir;

    /**
     * @param Slim $slim
     */
    public function __construct(Slim $slim)
    {
        $this->title = $slim->request()->post('gamename');

        /** @var LoginContext owner */
        $this->owner = $slim->container->get('login-context');

        /** @var EntityManagerInterface $em */
        $em = $slim->container->get('em');

        /** @var GameRepository gameRepo */
        $this->gameRepo = $em->getRepository('\\Pleo\\BSG\\Entities\\Game');

        /** @var Redirector redir */
        $this->redir = $slim->container->get('redirector');
    }

    public function __invoke()
    {
        $this->gameRepo->createGameUnsafe($this->title, call_user_func($this->owner));
        call_user_func($this->redir, 303, '/games');
    }
}
