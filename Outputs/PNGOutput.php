<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Output;

use UlrichSG\GetOpt;

require_once __DIR__ . "/../ImageCreator.php";

/**
 * Class PNGOutput
 *
 * @package Output
 */
class PNGOutput extends BaseOutput
{
    private $generation = 0;
    private $imageCreator;
    protected $path;

    /**
     * @param GetOpt $_options
     */
    function startOutput($_options)
    {
        echo "PNG Dateien werden erzeugt. Bitte warten...\n";

        $cellSize = 40;
        $cellColor = array(0, 0, 0);
        $bkColor = array(255, 255, 255);

        $this->path = __DIR__ . "\\PNG\\" . round(microtime(true));

        if ($_options->getOption("cellSize") != null)
        {
            $cellSize = $_options->getOption("cellSize");
        }
        if ($_options->getOption("cellColor") != null)
        {
            $cellColor = explode(",", $_options->getOption("cellColor"));
            if (count($cellColor) != 3)
            {
                echo "Bitte alle Farben angeben. Zahlen müssen zwischen 0 und 255 liegen.";
                die();
            }
        }
        if ($_options->getOption("bkColor") != null)
        {
            $bkColor = explode(",", $_options->getOption("bkColor"));
            if (count($bkColor) != 3)
            {
                echo "Bitte alle Farben angeben. Zahlen müssen zwischen 0 und 255 liegen.";
                die();
            }
        }
        $this->imageCreator = new ImageCreator($cellSize, $cellColor, $bkColor);
    }

    /**
     * Creates and returns an image of the current board
     *
     * @param GameOfLife/Board $_board
     * @param GetOpt $_options
     */

    function outputBoard($_board, $_options)
    {
        echo "\r Aktuelle Generation" . $this->generation;
        $image = $this->imageCreator->createImage($_board);
        if (!file_exists($this->path)) mkdir($this->path, 0777, true);
        imagepng($image, $this->path . "\\" . $this->generation . ".png");
        imagedestroy($image);
        $this->generation++;
    }

    function finishOutput()
    {
        echo "PNG Dateien wurden erzeugt.\n";
    }

    /**
     * @param GetOpt $_options
     */
    function addOptions($_options)
    {
        $_options->addOptions(array(
            array(null, "cellSize", GetOpt::REQUIRED_ARGUMENT, "Die Größe der lebenden Zellen."),
            array(null, "cellColor", GetOpt::REQUIRED_ARGUMENT, "Die Farbe der lebenden Zellen. Muss als RGB angeben werden. R,G,B"),
            array(null, "bkColor", GetOpt::REQUIRED_ARGUMENT, "Die Hintergrundfarbe des Bildes. Muss als RGB angeben werden. R,G,B")
        ));
    }
}