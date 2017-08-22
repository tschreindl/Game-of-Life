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
class GifOutput extends BaseOutput
{
    private $frames = array();
    private $path;

    /**
     * Initializes the output path of the object
     */
    public function startOutput($_options)
    {
        echo "Gif Datei wird erzeugt. Bitte warten...\n";
        $this->path = __DIR__ . "/Gif/";
    }

    /**
     * Collects the gif frames in an array
     *
     * @param \GameOfLife\Board $_board     Current game board
     */
    public function outputBoard($_board, $_options)
    {
        $imageCreator = new ImageCreator( $_board, 100);
        $frame = $imageCreator->createImage($_board, "gif");
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

        file_put_contents($this->path . round(microtime(true)) . ".gif", $gif->getGif());

        $tmpDirectory = basename($this->frames[0]);

        foreach ($this->frames as $frame)
        {
            unlink($frame);
        }

        rmdir(__DIR__ . "/Gif/Tmp");
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