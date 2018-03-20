<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Input;

use GameOfLife\Board;
use Ulrichsg\Getopt;


/**
 * Input Class to fill the board from a .txt File which must be stored in /Inputs/Example/.
 *
 * @package Input
 */
class FileInput extends BaseInput
{
    /**
     * Path to Input File.
     *
     * @var string
     */
    private $path = __DIR__ . "/Example/";
    private $fileName = "Glider";            //current size 10x10 field

    /**
     * Fills the board from the the txt file.
     *
     * @param Board $_board
     * @param GetOpt $_options
     */
    function fillBoard(Board $_board, GetOpt $_options)
    {
        $fileName = $_options->getOption("fileName");
        if ($fileName != null)
        {
            if (stristr($fileName, ".txt"))
            {
                $fileName = str_replace(".txt", "", $fileName);
            }
            if (file_exists($this->path . $fileName . ".txt"))
            {
                $this->fileName = $fileName;
            }
            else
            {
                echo "Datei " . $fileName . ".txt wurde nicht gefunden!\n";
                die();
            }
        }

        $newPath = $this->path . $this->fileName . ".txt";
        $lines = file($newPath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
        $centerX = ($_board->height() - count($lines)) / 2;
        if ($centerX < 1) $centerX = 0;
        $reset = $centerX;
        $centerY = ($_board->width() - strlen($lines[0])) / 2;
        if ($centerY < 1) $centerY = 0;
        for ($y = 0; $y < count($lines); $y++)
        {
            for ($x = 0; $x < strlen($lines[$y]); $x++)
            {
                if (substr($lines[$y], $x, 1) == "x")
                {
                    $_board->setField($centerX, $centerY, true);
                }
                else
                {
                    $_board->setField($centerX, $centerY, false);
                }
                $centerX++;
            }
            $centerY++;
            $centerX = $reset;
        }
    }

    /**
     * Sets Parameter for FileInput.
     *
     * available Parameter:
     * -fileName
     *
     * @param GetOpt $_options
     */
    function addOptions(GetOpt $_options)
    {
        $_options->addOptions(array(
            array(null, "fileName", GetOpt::REQUIRED_ARGUMENT, "FileInput - Der Dateiname für die Input Datei. Muss in \\Inputs\\Example\\ als .txt gespeichert sein.\n")
        ));
    }
}