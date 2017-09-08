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
 * Class VideoOutput
 *
 * @package Output
 */
class VideoOutput extends BaseOutput
{
    /**
     * @var ImageCreator
     */
    private $imageCreator;
    private $generation = 1;
    public $path;
    private $keepFrames = false;

    /**
     * @param GetOpt $_options
     */
    function startOutput($_options)
    {
        echo "Frames werden erzeugt. Bitte warten...\n";

        $cellSize = 40;
        $cellColor = array(255, 255, 0);
        $bkColor = array(135, 135, 135);

        $this->path = __DIR__ . "\\Video\\" . round(microtime(true)) . "\\Frames\\";

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
        imagepng($image, $this->path . str_pad($this->generation, 4, "0", STR_PAD_LEFT) . ".png");
        imagedestroy($image);
        $this->generation++;
    }

    /**
     * @param GetOpt $_options
     */
    function finishOutput($_options)
    {
        echo "\nVideo Datei wird erzeugt. Bitte warten...\n";
        echo $this->generation - 1 . " Frames werden verarbeitet...\n\n";
        exec(__DIR__ . "/../ffmpeg.exe -stats -loglevel fatal -i " . $this->path . "%04d.png -c:v libxvid -q:v 1 " . $this->path . "/../GOL_NS.avi", $options, $return);

        if ($_options->getOption("noSound") == null && $return == 0)
        {
            echo "Erfolgreich\n";
            echo "Musik wird eingefügt...\n";
            exec(__DIR__ . "/../ffmpeg.exe -y -stats -loglevel fatal -i " . $this->path . "/../GOL_NS.avi -i loop.mp3 -codec copy -shortest " . $this->path . "/../GOL.avi", $options, $return);
            unlink($this->path . "/../GOL_NS.avi");
        }

        if ($this->keepFrames == false)
        {
            if ($framesDir = opendir($this->path))
            {
                while (false !== ($entries = readdir($framesDir)))
                {
                    if ($entries != "." && $entries != "..")
                    {
                        unlink($this->path . $entries);
                    }
                }
                rmdir($this->path);
                closedir($framesDir);
            }
        }

        if ($return != 0)
        {
            echo "\nFehler bei der Video Erstellung. Abbruch...\n";
        }
        else
        {
            echo "\nVideo Datei wurde erfolgreich erzeugt.\n";
        }
    }

    /**
     * @param GetOpt $_options
     */
    function addOptions($_options)
    {
        $_options->addOptions(array(
            array(null, "noSound", GetOpt::NO_ARGUMENT, "VideoOutput - Das Video wird ohne Ton erzeugt."),
            array(null, "cellSize", GetOpt::REQUIRED_ARGUMENT, "VideoOutput - Die Größe der lebenden Zellen. Standard: 40"),
            array(null, "cellColor", GetOpt::REQUIRED_ARGUMENT, "VideoOutput - Die Farbe der lebenden Zellen. Muss als RGB angeben werden. R,G,B. Standard: 255,255,0 (Gelb)"),
            array(null, "bkColor", GetOpt::REQUIRED_ARGUMENT, "VideoOutput - Die Hintergrundfarbe des Bildes. Muss als RGB angeben werden. R,G,B. Standard: 135,135,135 (Grau)")
        ));
    }
}