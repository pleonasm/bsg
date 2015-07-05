<?php
namespace Pleo\BSG\Entities;

class SkillCard
{
    private $title;
    private $strength;
    private $img;
    private $color;
    private $gameBox;

    public function __construct(
        $title,
        $strength,
        $img,
        $color,
        $gameBox
    ) {
        $this->title = $title;
        $this->strength = $strength;
        $this->img = $img;
        $this->color = $color;
        $this->gameBox = $gameBox;
    }

    /**
     * @return mixed
     */
    public function title()
    {
        return $this->title;
    }

    /**
     * @return mixed
     */
    public function strength()
    {
        return $this->strength;
    }

    /**
     * @return mixed
     */
    public function img()
    {
        return $this->img;
    }

    /**
     * @return mixed
     */
    public function color()
    {
        return $this->color;
    }

    /**
     * @return mixed
     */
    public function gameBox()
    {
        return $this->gameBox;
    }
}
