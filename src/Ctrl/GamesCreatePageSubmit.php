<?php
namespace Pleo\BSG\Ctrl;

use Pleo\BSG\Entities\GameRepository;
use Pleo\BSG\Entities\User;
use Pleo\BSG\Redirector;
use Slim\Http\Request;

class GamesCreatePageSubmit
{
    /**
     * @var GameRepository
     */
    private $gameRepository;

    /**
     * @var Redirector
     */
    private $redirector;

    /**
     * @var Request
     */
    private $request;

    /**
     * @var User
     */
    private $currentUser;

    /**
     * @param GameRepository $gameRepository
     * @param Redirector $redirector
     * @param User $currentUser
     * @param Request $request
     */
    public function __construct(GameRepository $gameRepository, Redirector $redirector, User $currentUser, Request $request)
    {
        $this->gameRepository = $gameRepository;
        $this->redirector = $redirector;
        $this->request = $request;
        $this->currentUser = $currentUser;
    }

    public function __invoke()
    {
        $title = $this->request->post('gamename');
        $this->gameRepository->createGameUnsafe($title, $this->currentUser);
        $this->redirector->redirect(303, '/games');
    }
}
