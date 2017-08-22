<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Yannick Lapp <yannick.lapp@cn-consult.eu>
 */

namespace Output;

use GifCreator\GifCreator;

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
class GifOutput extends PNGOutput
{
    private $frames = array();

    /**
     * Initializes the output path of the object
     */
    public function startOutput()
    {
        echo "Gif Datei wird erzeugt. Bitte warten...\n";
        $this->path = __DIR__ . "\\Gif\\" . round(microtime(true));
    }

    /**
     * Collects the gif frames in an array
     *
     * @param \GameOfLife\Board $_board     Current game board
     */
    public function outputBoard($_board)
    {
        $frame = $this->createImage($_board);
        $this->frames[] = $frame;

        echo "\r" . count($this->frames) . " Generationen berechnet";
    }

    /**
     * Creates and saves the gif file
     */
    public function finishOutput()
    {
        if (! file_exists($this->path)) mkdir($this->path);

        $durations = array();
        for ($i = 0; $i < count($this->frames) - 1; $i++)
        {
            $durations[$i] = 0;
        }
        // wait 2 seconds before restarting the gif
        $durations[] = 200;

        $gif = new GifCreator();
        $gif->create($this->frames, $durations, 0);

        file_put_contents($this->path . "/test.gif", $gif->getGif());
    }

    /**
     * Adds GifOutput's class specific options to the option list
     *
     * @param \UlrichSG\GetOpt $_options    Option List
     */
    function addOptions($_options)
    {
    }
}