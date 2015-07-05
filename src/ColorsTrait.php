<?php
namespace Pleo\BSG;

use UnexpectedValueException;

trait ColorsTrait
{
    private $colors = [
        Colors::YELLOW,
        Colors::GREEN,
        Colors::PURPLE,
        Colors::RED,
        Colors::BLUE,
        Colors::BROWN
    ];

    public function getColorsFromBitMap($bitmap)
    {
        $colorsInBitmap = [];

        foreach ($this->colors as $color) {
            if ($color & $bitmap) {
                $colorsInBitmap[] = $color;
            }
        }
        return $colorsInBitmap;
    }

    /**
     * Function that enforces that a bitmap must have only 1 color in it
     */
    public function getSingleColor($bitmap)
    {
        $colors = $this->getColorsFromBitMap($bitmap);

        if (count($bitmap) > 1) {
           throw new UnexpectedValueException('Given bitmap has more than 1 color bitmap number: ' . $bitmap);
        }

        return array_pop($colors);
    }

    /**
     * @param array $colors
     * @return int
     */
    public function createBitMapFromColorsArray(array $colors)
    {
        $result = 0;
        foreach ($colors as $color) {
            $result += $color;
        }

        return $result;
    }
}