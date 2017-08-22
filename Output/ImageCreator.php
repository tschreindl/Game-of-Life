<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Yannick Lapp <yannick.lapp@cn-consult.eu>
 */

namespace Output;

use GameOfLife\Board;

/**
 * Class ImageCreator
 *
 * Create an image of a board and return it
 *
 * @package Output
 */
class ImageCreator
{
    private $baseImage;
    private $backgroundColor;
    private $gridColor;
    private $cellAliveColor;
    private $cellSize = 21;
    private $gameDirectory;

    /**
     * ImageCreator constructor.
     *
     * @param Board $_board                 The board which will be printed with create image
     * @param Integer $_cellSize            Width and Height of a single cell
     * @param ImageColor $_backgroundColor  Background Color of the images
     * @param ImageColor $_gridColor        Grid color of the images
     * @param ImageColor $_cellAliveColor   Cell color of the images
     */
    public function __construct($_board, $_cellSize = null, $_backgroundColor = null, $_gridColor = null, $_cellAliveColor = null)
    {
        if ($_cellSize != null) $this->cellSize = $_cellSize;
        $this->baseImage = imagecreate($_board->width * $this->cellSize, $_board->height * $this->cellSize);

        if ($_backgroundColor == null) $_backgroundColor = new ImageColor(255, 255, 255);
        if ($_gridColor == null) $_gridColor = new ImageColor(0,0,0);
        if ($_cellAliveColor == null) $_cellAliveColor = new ImageColor(255,0,0);

        $this->backgroundColor = $_backgroundColor->getColor($this->baseImage);
        $this->gridColor = $_gridColor->getColor($this->baseImage);
        $this->cellAliveColor = $_cellAliveColor->getColor($this->baseImage);

        // Create directories if they don't exist
        if (! file_exists(__DIR__ . "/PNG")) mkdir(__DIR__ . "/PNG");
        if (! file_exists(__DIR__ . "/Gif")) mkdir(__DIR__. "/Gif");

        $this->gameDirectory = round(microtime(true));
    }

    /**
     * Creates and returns an image of the current board
     *
     * @param \GameOfLife\Board $_board     Current board
     * @param String $_imageType            Type of Image that shall be returned
     * @return String                       Path to image
     */
    public function createImage ($_board, $_imageType)
    {
        $sizeX = $_board->width * $this->cellSize;
        $sizeY = $_board->height * $this->cellSize;

        $image = $this->baseImage;

        // draw grid
        imagesetthickness($image, 2);

        for ($x = 0; $x < $_board->width * $this->cellSize; $x += $this->cellSize)
        {
            imageline($image, $x, 0, $x, $sizeY, $this->gridColor);
        }

        for ($y = 0; $y < $_board->height * $this->cellSize; $y += $this->cellSize)
        {
            imageline($image, 0, $y, $sizeX, $y, $this->gridColor);
        }

        imagesetthickness($image, 1);


        $fontSize = 100;

        $charPosX = ceil(($this->cellSize - imagefontwidth($fontSize))/ 2) - 1;
        $charPosY =  ceil(($this->cellSize - imagefontheight($fontSize))/ 2) - 1;

        for ($y = 0; $y < $_board->height; $y++)
        {
            $charPosX = ceil(($this->cellSize - imagefontwidth($fontSize))/ 2) - 1;

            for ($x = 0; $x < $_board->width; $x++)
            {
                if ($_board->board[$x][$y] == true)
                {
                    imagechar($image, $fontSize, $charPosX, $charPosY, "+", $this->cellAliveColor);
                }
                $charPosX += $this->cellSize;
            }
            $charPosY += $this->cellSize;
        }


        $filePath = __DIR__;
        $fileName = $_board->curGameStep();

        switch ($_imageType)
        {
            case "png":
                $filePath .= "/PNG/" . $this->gameDirectory . "/" . $fileName . ".png";
                imagepng($image, $filePath);
                break;
            case "gif":
                if (!file_exists($filePath . "/Gif/Tmp")) mkdir($filePath . "/Gif/Tmp");
                $filePath .= "/Gif/Tmp/" . $fileName . ".png";
                imagegif($image, $filePath);
                break;
            default:
                echo "Error: Invalid image type specified!\n";
        }

        imagedestroy($image);

        return $filePath;
    }
}