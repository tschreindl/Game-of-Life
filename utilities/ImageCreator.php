<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Output;

/**
 * Class to build an Image for various Outputs
 *
 * @package Output
 */
class ImageCreator
{
    private $cellSize = 40;
    private $cellColor = array(255, 255, 0); //yellow
    private $backgroundColor = array(135, 135, 135);  //grey

    function __construct($_cellSize, $_cellColor, $_backgroundColor)
    {
        if ($_cellSize != null) $this->cellSize = $_cellSize;
        if ($_cellColor != null) $this->cellColor = $this->getColor($_cellColor);
        if ($_backgroundColor != null) $this->backgroundColor = $this->getColor($_backgroundColor);
    }

    /**
     * Creates the image based on the given Board Size and Cell Size
     * Draws a grid and the living cells
     * Returns the image to the used Output
     *
     * @param $_board
     * @return resource
     */
    public function createImage($_board)
    {
        $sizeX = $_board->width * ($this->cellSize + 2) + 2;
        $sizeY = $_board->height * ($this->cellSize + 2) + 2;

        $image = imagecreate($sizeX, $sizeY);
        imagecolorallocate($image, $this->backgroundColor[0], $this->backgroundColor[1], $this->backgroundColor[2]);
        $lineColor = imagecolorallocate($image, 255, 255, 255);
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

        //draw horizontal lines
        for ($x = 0; $x < $_board->width; $x++)
        {
            imageline($image, $posX, 0, $posX, $sizeY, $lineColor);
            imageline($image, $posX + 1, 0, $posX + 1, $sizeY, $lineColor);
            $posX = $posX + $this->cellSize + 2;
        }

        //draw vertical lines
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

    /**
     * Function that handles the colors for
     * cells, background, etc
     * Returns array with R,G,B Color
     *
     * @param $_color
     * @return array
     */
    function getColor($_color)
    {
        $color = array();
        if (stristr($_color, "#"))
        {
            if (strlen($_color) == 7)
            {
                $color[0] = hexdec(substr($_color, 1, 2));
                $color[1] = hexdec(substr($_color, 3, 2));
                $color[2] = hexdec(substr($_color, 5, 2));
            }
            else
            {
                die("Bitte die Farbe folgendermaßen angeben: #00FF00");
            }
        }
        elseif (stristr($_color, ","))
        {
            $color = explode(",", $_color);
            if (count($color) != 3) die("Bitte alle 3 Farben angeben. Zahlen müssen zwischen 0 und 255 liegen!");
            foreach ($color as $cl)
            {
                if ($cl < 0 || $cl > 255) die("Die Zahlen müssen zwischen 0 und 255 liegen!");
            }
        }
        else
        {
            switch (strtolower($_color)):

                case "black":
                    $color[0] = 0;
                    $color[1] = 0;
                    $color[2] = 0;
                    break;

                case "white":
                    $color[0] = 255;
                    $color[1] = 255;
                    $color[2] = 255;
                    break;

                case "red":
                    $color[0] = 255;
                    $color[1] = 0;
                    $color[2] = 0;
                    break;

                case "lime":
                    $color[0] = 0;
                    $color[1] = 255;
                    $color[2] = 0;
                    break;

                case "blue":
                    $color[0] = 0;
                    $color[1] = 0;
                    $color[2] = 255;
                    break;

                case "yellow":
                    $color[0] = 255;
                    $color[1] = 255;
                    $color[2] = 0;
                    break;

                case "aqua":
                    $color[0] = 0;
                    $color[1] = 255;
                    $color[2] = 255;
                    break;

                case "fuchsia":
                    $color[0] = 255;
                    $color[1] = 0;
                    $color[2] = 255;
                    break;

                case "gray":
                    $color[0] = 128;
                    $color[1] = 128;
                    $color[2] = 128;
                    break;

                case "green":
                    $color[0] = 0;
                    $color[1] = 128;
                    $color[2] = 0;
                    break;

                case "maroon":
                    $color[0] = 128;
                    $color[1] = 0;
                    $color[2] = 0;
                    break;

                case "navy":
                    $color[0] = 0;
                    $color[1] = 0;
                    $color[2] = 128;
                    break;

                case "olive":
                    $color[0] = 128;
                    $color[1] = 128;
                    $color[2] = 0;
                    break;

                case "purple":
                    $color[0] = 128;
                    $color[1] = 0;
                    $color[2] = 128;
                    break;

                case "silver":
                    $color[0] = 192;
                    $color[1] = 192;
                    $color[2] = 192;
                    break;

                case "teal":
                    $color[0] = 0;
                    $color[1] = 128;
                    $color[2] = 128;
                    break;

                default:
                    die("Keine Farbe mit diesem Namen gefunden! Bitte über R,G,B oder als HEX eingeben!");

            endswitch;
        }
        return $color;
    }
}