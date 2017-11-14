<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Input;

use GameOfLife\Board;
use UlrichSG\GetOpt;


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
        for ($y = 0; $y < count($lines); $y++)
        {
            for ($x = 0; $x < strlen($lines[$y]); $x++)
            {
                if (substr($lines[$y], $x, 1) == "x")
                {
                    $_board->setField($x, $y, true);
                }
                else
                {
                    $_board->setField($x, $y, false);
                }
            }
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