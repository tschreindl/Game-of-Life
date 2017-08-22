<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Output;


/**
 * Class PNGOutput
 *
 * @package Output
 */
class PNGOutput
{
    private $generation = 0;
    protected $path;

    function startOutput()
    {
        echo "PNG Dateien werden erzeugt. Bitte warten...\n";
        $this->path = __DIR__ . "\\PNG\\" . round(microtime(true));
    }

    /**
     * Creates and returns an image of the current board
     *
     * @param \GameOfLife\Board $_board     Current board
     * @return resource                     Image
     */
    function createImage($_board)
    {
        $sizeX = $_board->width * 21 + 2;
        $sizeY = $_board->height * 21 + 2;

        $image = imagecreate($sizeX, $sizeY);
        $background = imagecolorallocate($image, 255, 255, 255);
        $lineColor = imagecolorallocate($image, 0, 0, 0);
        $charColor = imagecolorallocate($image, 255, 0, 0);

        imageline($image, 0, 0, $sizeX, 0, $lineColor);
        imageline($image, 0, 1, $sizeX, 1, $lineColor);

        imageline($image, 0, $sizeY - 2, $sizeX, $sizeY - 2, $lineColor);
        imageline($image, 0, $sizeY - 1, $sizeX, $sizeY - 1, $lineColor);

        imageline($image, 0, 0, 0, $sizeY, $lineColor);
        imageline($image, 1, 0, 1, $sizeY, $lineColor);

        imageline($image, $sizeX - 2, 0, $sizeX - 2, $sizeY, $lineColor);
        imageline($image, $sizeX - 1, 0, $sizeX - 1, $sizeY, $lineColor);

        $posX = 21;
        $posY = 21;

        for ($x = 0; $x < $_board->width; $x++)
        {
            imageline($image, $posX, 0, $posX, $sizeY, $lineColor);
            imageline($image, $posX + 1, 0, $posX + 1, $sizeY, $lineColor);
            $posX = $posX + 21;
        }

        for ($y = 0; $y < $_board->height; $y++)
        {
            imageline($image, 0, $posY, $sizeX, $posY, $lineColor);
            imageline($image, 0, $posY + 1, $sizeX, $posY + 1, $lineColor);
            $posY = $posY + 21;
        }

        $charPosX = 9;
        $charPosY = 5;

        $this->generation++;

        for ($y = 0; $y < $_board->height; $y++)
        {
            for ($x = 0; $x < $_board->width; $x++)
            {

                if ($_board->board[$x][$y] == false)
                {
                    //echo "   ";
                }
                elseif ($_board->board[$x][$y] == true)
                {
                    imagechar($image, 2, $charPosX, $charPosY, "+", $charColor);
                }
                $charPosX = $charPosX + 21;
            }
            $charPosX = 9;
            $charPosY = $charPosY + 21;
        }

        return $image;
    }

    function outputBoard($_board)
    {
        $image = $this->createImage($_board);

        if (! file_exists($this->path)) mkdir($this->path);
        imagepng($image, $this->path . "\\" . $this->generation . ".png");
        imagedestroy($image);
    }

    function addOptions($_options)
    {

    }
}