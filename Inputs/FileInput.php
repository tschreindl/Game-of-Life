<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Input;

require_once "BaseInput.php";

use GameOfLife\Board;
use UlrichSG\GetOpt;


/**
 * Class FileInput
 *
 * @package Input
 */
class FileInput extends BaseInput
{
    /** Path to Input File
     * @var string
     */
    private $path = __DIR__ . "/Example/";
    private $fileName = "Glider";            //current size 10x10 field

    /**Fills the board from the the txt file
     *
     * @param Board $_board
     * @param GetOpt $_options
     */
    function fillBoard($_board, $_options)
    {
        if ($_options->getOption("fileName") != null)
        {
            if (file_exists($this->path . $_options->getOption("fileName") . ".txt"))
            {
                $this->fileName = $_options->getOption("fileName");
            }
            else
            {
                echo "Datei " . $_options->getOption("fileName") . ".txt wurde nicht gefunden!\n";
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
     * @param GetOpt $_options
     */
    function addOptions($_options)
    {
        $_options->addOptions(array(
            array(null, "fileName", GetOpt::REQUIRED_ARGUMENT, "Der Dateiname für die Input Datei.")
        ));
    }
}