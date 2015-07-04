<?php
namespace Pleo\BSG\Entities;

class Game
{
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
     * @param int $id
     * @param string $title
     * @param User $owner
     */
    public function __construct($id, $title, User $owner)
    {
        $this->id = $id;
        $this->title = $title;
        $this->owner = $owner;
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
