<?php
namespace Pleo\BSG\Entities;

use Pleo\BSG\ColorsTrait;

/**
 * Entity Describing a Crisis card
 */
class CrisisCard
{
    use ColorsTrait;

    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $title;

    /**
     * @var int
     */
    private $strength;

    /**
     * @var string
     */
    private $img;

    /**
     * @var int
     */
    private $passingColors;

    /**
     * @var int
     */
    private $gameBox;

    /**
     * @var boolean
     */
    private $isSuper;

    /**
     * @var boolean
     */
    private $isNewCaprica;

    public function __construct(
        $title,
        $strength,
        $img,
        $gameBox,
        array $passingColors,
        $isSuper,
        $isNewCaprica
    ) {
        $this->title = $title;
        $this->strength = $strength;
        $this->img = $img;
        $this->gameBox = $gameBox;
        $this->setColors($passingColors);
        $this->isSuper = $isSuper;
        $this->isNewCaprica = $isNewCaprica;
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
     * @return int
     */
    public function strength()
    {
        return $this->strength;
    }

    /**
     * @return string
     */
    public function img()
    {
        return $this->img;
    }

    /**
     * @return array
     */
    public function passingColors()
    {
        return $this->getColorsFromBitMap($this->passingColors);
    }

    /**
     * @return int
     */
    public function gameBox()
    {
        return $this->gameBox;
    }

    /**
     * @return bool
     */
    public function isSuperCrisis()
    {
        return $this->isSuper;
    }

    /**
     * @param array $colorsArray
     */
    private function setColors(array $colorsArray)
    {
        $this->passingColors = $this->createBitMapFromColorsArray($colorsArray);
    }
}