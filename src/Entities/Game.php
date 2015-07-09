<?php
namespace Pleo\BSG\Entities;

class Game
{
    const EXP_PEGASUS = 0x1;
    const EXP_EXODUS = 0x2;
    const EXP_DAYBREAK = 0x4;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var User
     */
    private $owner;

    /**
     * @var int
     */
    private $expansions;

    /**
     * @var GamePlayer[]
     */
    private $players;

    /**
     * @param int $id
     * @param string $title
     * @param User $owner
     * @param int $expansions
     * @param GamePlayer[] $players
     */
    public function __construct($id, $title, User $owner, $expansions, array $players)
    {
        $this->id = $id;
        $this->title = $title;
        $this->owner = $owner;
        $this->expansions = $expansions;
        $this->players = $players;
    }

    /**
     * @return int
     */
    public function id()
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @return User
     */
    public function owner()
    {
        return $this->owner;
    }
}
