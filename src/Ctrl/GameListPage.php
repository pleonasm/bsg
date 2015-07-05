<?php
namespace Pleo\BSG\Ctrl;

use Doctrine\ORM\EntityManager;
use Pleo\BSG\Entities\Game;
use Pleo\BSG\Entities\GameRepository;
use Pleo\BSG\LoginGuard;
use Slim\Slim;
use Slim\View;

class GameListPage
{
    /**
     * @var LoginGuard
     */
    private $loginGuard;
    /**
     * @var GameRepository
     */
    private $gameRepo;

    /**
     * @param Slim $slim
     */
    public function __construct(Slim $slim)
    {
        /** @var LoginGuard loginGuard */
        $this->loginGuard = $slim->container->get('login-guard');
        /** @var EntityManager em */
        $em = $slim->container->get('em');
        /** @var GameRepository gameRepo */
        $this->gameRepo = $em->getRepository('\\Pleo\\BSG\\Entities\\Game');
        /** @var View view */
        $this->view = $slim->view();
    }

    public function __invoke()
    {
        if (!call_user_func($this->loginGuard)) {
            return;
        }
        $games = $this->gameRepo->findAll();
        $viewGames = [];
        /** @var Game $game */
        foreach($games as $game) {

            $viewGames[$game->owner()->displayName()][] = $game->title();
        }

        $viewData['gamesList'] = $viewGames;

        $this->view->display('games.html', $viewData);
    }
}

