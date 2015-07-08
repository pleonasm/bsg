<?php
namespace Pleo\BSG\Ctrl;

use Pleo\BSG\Entities\Game;
use Pleo\BSG\Entities\GameRepository;
use Slim\View;

class GamesPage
{
    /**
     * @var GameRepository
     */
    private $gameRepository;

    /**
     * @var View
     */
    private $view;

    /**
     * @param GameRepository $gameRepository
     * @param View $view
     */
    public function __construct(GameRepository $gameRepository, View $view)
    {
        $this->gameRepository = $gameRepository;
        $this->view = $view;
    }

    public function __invoke()
    {
        $games = $this->gameRepository->findAll();
        $viewGames = [];
        /** @var Game $game */
        foreach($games as $game) {
            $viewGames[$game->owner()->displayName()][] = $game->title();
        }

        $viewData['gamesList'] = $viewGames;

        $this->view->display('games.html', $viewData);
    }
}

