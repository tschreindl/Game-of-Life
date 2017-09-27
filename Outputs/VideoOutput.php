<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Output;


use GameOfLife\Board;
use phpDocumentor\Reflection\Types\Object_;
use UlrichSG\GetOpt;

/**
 * Class VideoOutput
 *
 * @package Output
 */
class VideoOutput extends BaseOutput
{
    private $imageCreator;
    private $generation = 1;
    public $path;
    private $keepFrames = false;

    /**
     * Code that runs before the Board Output starts
     * Checks if options given and creates the directory for the PNG Frames files
     *
     * @param GetOpt $_options
     */
    function startOutput(GetOpt $_options)
    {
        echo "Frames werden erzeugt. Bitte warten...\n";

        $cellSize = null;
        $cellColor = null;
        $bkColor = null;

        $this->path = __DIR__ . "\\Video\\" . round(microtime(true)) . "\\Frames\\";

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
        $this->imageCreator = new ImageCreator($cellSize, $cellColor, $bkColor);
        if (!file_exists($this->path)) mkdir($this->path, 0777, true);
    }

    /**
     * Creates and returns an image of the current board
     * Saves the single files into a directory to create
     * a movie in the function finishOutput
     *
     * @param Board $_board
     * @param GetOpt $_options
     */
    function outputBoard(Board $_board, GetOpt $_options)
    {
        $image = null;
        echo "\rAktuelle Generation: " . $this->generation;
        if ($this->imageCreator instanceof ImageCreator) $image = $this->imageCreator->createImage($_board);
        imagepng($image, $this->path . str_pad($this->generation, 4, "0", STR_PAD_LEFT) . ".png");
        imagedestroy($image);
        $this->generation++;
    }

    /**
     * Code that runs after the Board Output
     * Creates from the single files in the directory
     * a movie with optional sound using ffmpeg.exe
     *
     * @param GetOpt $_options
     */
    function finishOutput(GetOpt $_options)
    {
        echo "\nVideo Datei wird erzeugt. Bitte warten...\n";
        echo $this->generation - 1 . " Frames werden verarbeitet...\n\n";
        exec(__DIR__ . "/../utilities/ffmpeg.exe -stats -loglevel fatal -i " . $this->path . "%04d.png -c:v libxvid -q:v 1 " . $this->path . "/../GOL_NS.avi", $options, $return);

        if ($_options->getOption("noSound") == null && $return == 0)
        {
            echo "Erfolgreich\n";
            echo "Musik wird eingefügt...\n";
            exec(__DIR__ . "/../utilities/ffmpeg.exe -y -stats -loglevel fatal -i " . $this->path . "/../GOL_NS.avi -i " . __DIR__ . "/../utilities/loop.mp3 -codec copy -shortest " . $this->path . "/../GOL.avi", $options, $return);
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
     * Set available options
     *
     * available options:
     * -noSound
     * -cellSize
     * -cellColor
     * -bkColor
     *
     * @param GetOpt $_options
     */
    function addOptions(GetOpt $_options)
    {
        $_options->addOptions(array(
            array(null, "noSound", GetOpt::NO_ARGUMENT, "VideoOutput - Das Video wird ohne Ton erzeugt."),
            array(null, "cellSize", GetOpt::REQUIRED_ARGUMENT, "VideoOutput - Die Größe der lebenden Zellen. Standard: 40"),
            array(null, "cellColor", GetOpt::REQUIRED_ARGUMENT, "VideoOutput - Die Farbe der lebenden Zellen. Muss als R,G,B oder #HEX oder Standard-Farbe angeben werden. Standard: 255,255,0 (Gelb)"),
            array(null, "bkColor", GetOpt::REQUIRED_ARGUMENT, "VideoOutput - Die Hintergrundfarbe des Bildes. Muss als R,G,B oder #HEX angeben werden. Standard: 135,135,135 (Grau)\n"),
        ));
    }
}