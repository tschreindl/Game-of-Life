<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Yannick Lapp <yannick.lapp@cn-consult.eu>
 */

namespace Output;

use GameOfLife\Board;
use GifCreator\GifCreator;
use UlrichSG\GetOpt;

/**
 * Class GifOutput
 *
 * Creates an animated gif from game of life boards
 * Use startoutput() to initialize the output
 * Use outputBoard($_board) to save a single board to the list of frames
 * use finishOutput() to generate the gif file
 *
 * @package Output
 */
class GifOutput extends BaseOutput
{
    private $imageCreator;
    public $frames = array();
    public $path;
    private $frameTime = 10;

    /**
     * Initializes the output path of the object
     *
     * @param GetOpt $_options
     */
    public function startOutput(GetOpt $_options)
    {
        echo "Gif Datei wird erzeugt. Bitte warten...\n";

        $cellSize = null;
        $cellColor = null;
        $bkColor = null;

        $this->path = __DIR__ . "\\GIF\\" . round(microtime(true));

        if ($_options->getOption("cellSize") != null)
        {
            $cellSize = $_options->getOption("cellSize");
        }
        if ($_options->getOption("cellColor") != null)
        {
            $cellColor = $_options->getOption("cellColor");
        }
        if ($_options->getOption("bkColor") != null)
        {
            $bkColor = $_options->getOption("bkColor");
        }
        if ($_options->getOption("frameTime") != null)
        {
            $this->frameTime = $_options->getOption("frameTime");
        }
        $this->imageCreator = new ImageCreator($cellSize, $cellColor, $bkColor);
    }

    /**
     * Collects the gif frames in an array
     *
     * @param \GameOfLife\Board $_board Current game board
     * @param GetOpt $_options
     */
    public function outputBoard(Board $_board, GetOpt $_options)
    {
        $frame = $this->imageCreator->createImage($_board);
        $this->frames[] = $frame;

        echo "\r" . count($this->frames) . " Generationen berechnet";
    }

    /**
     * Creates and saves the gif file
     *
     * @param $_options
     */
    public function finishOutput(GetOpt $_options)
    {
        if (!file_exists($this->path)) mkdir($this->path, 0777, true);

        $durations = array();
        for ($i = 0; $i < count($this->frames) - 1; $i++)
        {
            $durations[$i] = $this->frameTime;
        }
        // wait 2 seconds before restarting the gif
        $durations[] = 200;

        $gif = new GifCreator();
        $gif->create($this->frames, $durations, 0);

        file_put_contents($this->path . "/Gif_1.gif", $gif->getGif());

        echo "\nGIF Datei wurde erzeugt.\n";
    }

    /**
     * Adds GifOutput's class specific options to the option list
     *
     * available options:
     * -cellSize
     * -cellColor
     * -bkColor
     * -frameTime
     *
     * @param \UlrichSG\GetOpt $_options Option List
     */
    function addOptions(GetOpt $_options)
    {
        $_options->addOptions(array(
            array(null, "cellSize", GetOpt::REQUIRED_ARGUMENT, "GifOutput - Die Größe der lebenden Zellen. Standard: 40"),
            array(null, "cellColor", GetOpt::REQUIRED_ARGUMENT, "GifOutput - Die Farbe der lebenden Zellen. Muss als R,G,B oder #HEX angeben werden. Standard: 255,255,0 (Gelb)"),
            array(null, "bkColor", GetOpt::REQUIRED_ARGUMENT, "GifOutput - Die Hintergrundfarbe des Bildes. Muss als R,G,B oder #HEX angeben werden. Standard: 135,135,135 (Grau)"),
            array(null, "frameTime", GetOpt::REQUIRED_ARGUMENT, "GifOutput - Die Dauer der einzelnen Frames. Standard: 10\n")
        ));
    }
}