<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Output;


/**
 * Class CreateImage
 *
 * @package Output
 */
class ImageCreator
{
    private $cellSize;
    private $cellColor = array();
    private $backgroundColor = array();

    function __construct($_cellSize, $_cellColor, $_backgroundColor)
    {
        $this->cellSize = $_cellSize;
        $this->cellColor = $_cellColor;
        $this->backgroundColor = $_backgroundColor;
    }

    public function createImage($_board)
    {
        $sizeX = $_board->width * ($this->cellSize + 2) + 2;
        $sizeY = $_board->height * ($this->cellSize + 2) + 2;

        $image = imagecreate($sizeX, $sizeY);
        imagecolorallocate($image, $this->backgroundColor[0], $this->backgroundColor[1], $this->backgroundColor[2]);
        $lineColor = imagecolorallocate($image, 100, 100, 100);
        $charColor = imagecolorallocate($image, $this->cellColor[0], $this->cellColor[1], $this->cellColor[2]);

        imageline($image, 0, 0, $sizeX, 0, $lineColor);
        imageline($image, 0, 1, $sizeX, 1, $lineColor);

        imageline($image, 0, $sizeY - 2, $sizeX, $sizeY - 2, $lineColor);
        imageline($image, 0, $sizeY - 1, $sizeX, $sizeY - 1, $lineColor);

        imageline($image, 0, 0, 0, $sizeY, $lineColor);
        imageline($image, 1, 0, 1, $sizeY, $lineColor);

        imageline($image, $sizeX - 2, 0, $sizeX - 2, $sizeY, $lineColor);
        imageline($image, $sizeX - 1, 0, $sizeX - 1, $sizeY, $lineColor);

        $posX = $this->cellSize + 2;
        $posY = $this->cellSize + 2;

        for ($x = 0; $x < $_board->width; $x++)
        {
            imageline($image, $posX, 0, $posX, $sizeY, $lineColor);
            imageline($image, $posX + 1, 0, $posX + 1, $sizeY, $lineColor);
            $posX = $posX + $this->cellSize + 2;
        }

        for ($y = 0; $y < $_board->height; $y++)
        {
            imageline($image, 0, $posY, $sizeX, $posY, $lineColor);
            imageline($image, 0, $posY + 1, $sizeX, $posY + 1, $lineColor);
            $posY = $posY + $this->cellSize + 2;
        }

        $charPosX = 2;
        $charPosY = 2;

        for ($y = 0; $y < $_board->height; $y++)
        {
            for ($x = 0; $x < $_board->width; $x++)
            {
                if ($_board->board[$x][$y] == true)
                {
                    imagefilledrectangle($image, $charPosX + 1, $charPosY + 1, $charPosX + $this->cellSize - 2, $charPosY + $this->cellSize - 2, $charColor);
                }
                $charPosX = $charPosX + $this->cellSize + 2;
            }
            $charPosX = 2;
            $charPosY = $charPosY + $this->cellSize + 2;
        }

        return $image;
    }

}