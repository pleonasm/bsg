<?php
namespace Pleo\BSG\Entities;

use DateTimeInterface;

class GamePlayer
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var
     */
    private $createDate;

    /**
     * @var
     */
    private $user;

    /**
     * @var
     */
    private $game;

    /**
     * @param DateTimeInterface $createDate
     * @param User $user
     * @param Game $game
     */
    public function __construct(DateTimeInterface $createDate, User $user, Game $game)
    {
        $this->createDate = $createDate;
        $this->user = $user;
        $this->game = $game;
    }
}
