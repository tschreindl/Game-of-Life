<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Output;

use GameOfLife\Board;
use UlrichSG\GetOpt;

/**
 * Output Class to Output the Board to a JPEG Image.
 *
 * @package Output
 */
class JPEGOutput extends BaseOutput
{
    /** @var ImageCreator */
    private $imageCreator;
    private $generation = 1;
    public $path;

    /**
     * Code that runs before the Board Output starts.
     * Checks if options given and creates the directory for the JPEG files.
     *
     * @param GetOpt $_options
     */
    function startOutput(GetOpt $_options)
    {
        echo "JPEG Dateien werden erzeugt. Bitte warten...\n";

        $cellSize = null;
        $cellColor = null;
        $bkColor = null;
        $lineColor = null;

        $this->path = __DIR__ . "\\JPEG\\" . round(microtime(true));

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
        if ($_options->getOption("lineColor") != null)
        {
            $lineColor = $_options->getOption("lineColor");
        }
        $this->imageCreator = new ImageCreator($cellSize, $cellColor, $bkColor, $lineColor);
        if (!file_exists($this->path)) mkdir($this->path, 0777, true);
    }

    /**
     * Creates and returns an image of the current board.
     *
     * @param Board $_board
     * @param GetOpt $_options
     */
    function outputBoard(Board $_board, GetOpt $_options)
    {
        echo "\rAktuelle Generation: " . $this->generation;
        $image = $this->imageCreator->createImage($_board);
        imagejpeg($image, $this->path . "\\" . $this->generation . ".jpeg");
        imagedestroy($image);
        $this->generation++;
    }

    /**
     * Code that runs after the Board Output.
     * Says that the JPEG creation was successful.
     *
     * @param GetOpt $_options
     */
    function finishOutput(GetOpt $_options)
    {
        echo "\nJPEG Dateien wurden erzeugt.\n";
    }

    /**
     * Set available options.
     *
     * available options:
     * -cellSize
     * -cellColor
     * -bkColor
     *
     * @param GetOpt $_options
     */
    function addOptions(GetOpt $_options)
    {
        $_options->addOptions(array(
            array(null, "cellSize", GetOpt::REQUIRED_ARGUMENT, "JPEGOutput - Die Größe der lebenden Zellen. Standard: 40"),
            array(null, "cellColor", GetOpt::REQUIRED_ARGUMENT, "JPEGOutput - Die Farbe der lebenden Zellen. Muss als R,G,B oder #HEX oder Standard-Farbe angeben werden. Standard: 255,255,0 (Gelb)"),
            array(null, "bkColor", GetOpt::REQUIRED_ARGUMENT, "JPEGOutput - Die Hintergrundfarbe des Bildes. Muss als R,G,B oder #HEX oder Standard-Farbe angeben werden. Standard: 128,128,128 (Grau)"),
            array(null, "lineColor", GetOpt::REQUIRED_ARGUMENT, "JPEGOutput - Die Farbe des Gitternetz. Muss als R,G,B oder #HEX oder Standard-Farbe angeben werden. Standard: 255,255,255 (Weiß)\n")
        ));
    }
}