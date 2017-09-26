<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Output;

require_once "BaseOutput.php";
require_once __DIR__."/../ImageCreator.php";

use UlrichSG\GetOpt;

/**
 * Class JPGOutput
 *
 * @package Output
 */
class JPEGOutput extends BaseOutput
{
    /**
     * @var ImageCreator
     */
    private $imageCreator;
    private $generation = 1;
    public $path;
    /**
     * @param GetOpt $_options
     */
    function startOutput($_options)
    {
        echo "JPEG Dateien werden erzeugt. Bitte warten...\n";

        $cellSize = 40;
        $cellColor = array(255, 255, 0);
        $bkColor = array(135, 135, 135);

        $this->path = __DIR__ . "\\JPEG\\" . round(microtime(true));

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
        if (!file_exists($this->path)) mkdir($this->path, 0777, true);
    }

    /**
     * Creates and returns an image of the current board
     *
     * @param GameOfLife /Board $_board
     * @param GetOpt $_options
     */
    function outputBoard($_board, $_options)
    {
        echo "\rAktuelle Generation: " . $this->generation;
        $image = $this->imageCreator->createImage($_board);
        imagejpeg($image, $this->path . "\\" . $this->generation . ".jpeg");
        imagedestroy($image);
        $this->generation++;
    }

    function finishOutput($_options)
    {
        echo "\nJPEG Dateien wurden erzeugt.\n";
    }

    /**
     * @param GetOpt $_options
     */
    function addOptions($_options)
    {
        $_options->addOptions(array(
            array(null, "cellSize", GetOpt::REQUIRED_ARGUMENT, "JPEGOutput - Die Größe der lebenden Zellen. Standard: 40"),
            array(null, "cellColor", GetOpt::REQUIRED_ARGUMENT, "JPEGOutput - Die Farbe der lebenden Zellen. Muss als RGB angeben werden. R,G,B. Standard: 255,255,0 (Gelb)"),
            array(null, "bkColor", GetOpt::REQUIRED_ARGUMENT, "JPEGOutput - Die Hintergrundfarbe des Bildes. Muss als RGB angeben werden. R,G,B. Standard: 135,135,135 (Grau)")
        ));
    }
}