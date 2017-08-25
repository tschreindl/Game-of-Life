<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Output;

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
    protected $path;
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
        echo "\nVideo Datei wird erzeugt. Geschätze Dauer: ~" . $this->calculateDuration() . "Sek. Bitte warten...";
        exec(__DIR__ . "/../ffmpeg.exe -loglevel fatal -i " . $this->path . "%04d.png " . $this->path . "/../GOL_NS.avi", $options, $return);

        if ($_options->getOption("noSound") == null)
        {
            exec(__DIR__ . "/../ffmpeg.exe -y -loglevel fatal -i " . $this->path . "/../GOL_NS.avi -i loop.mp3 -shortest " . $this->path . "/../GOL.avi", $options, $return);
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

    function calculateDuration()
    {
        $multiplier = 0.02;
        $imageSize = getimagesize($this->path . "0001.png");
        /**
        if ($imageSize[0] < 422 && $imageSize < 422) //10x10
        {
            $multiplier = 0;
        }
        elseif ($imageSize[0] < 842 && $imageSize < 842) //20x20
        {
            $multiplier = 0;
        }
        elseif ($imageSize[0] < 1262 && $imageSize < 1262) //30x30
        {
            $multiplier = 0;
        }
        elseif ($imageSize[0] < 1682 && $imageSize < 1682) //40x40
        {
            $multiplier = 0;
        }
        elseif ($imageSize[0] < 2102 && $imageSize < 2102) //50x50
        {
            $multiplier = 0;
        }
        elseif ($imageSize[0] < 2522 && $imageSize < 2522)  //60x60
        {
        $multiplier = 0;
        }
        elseif ($imageSize[0] < 2942 && $imageSize < 2942)  //70x70
        {
        $multiplier = 0;
        }
        elseif ($imageSize[0] < 3362 && $imageSize < 3362) //80x80
        {
        $multiplier = 0;
        }
        elseif ($imageSize[0] < 3782 && $imageSize < 3782) //90x90
        {
        $multiplier = 0;
        }
        elseif ($imageSize[0] < 4202 && $imageSize < 4202) //100x100
        {
        $multiplier = 0;
        }
        **/
        //print_r($imageSize);
        $duration = round($this->generation * $multiplier);

        return $duration;
    }
}