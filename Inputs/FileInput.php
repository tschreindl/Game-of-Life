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
 * Class FileInput
 *
 * @package Input
 */
class FileInput extends BaseInput
{
    /** Path to Input File
     * @var string
     */
    private $path = __DIR__."\\Example\\GOL.txt";    //current size 10x10 fields

    /**Fills the board from the the txt file
     *
     * @param Board $_board
     * @param GetOpt $_options
     */
    function fillBoard($_board, $_options)
    {
        $lines = file($this->path, FILE_IGNORE_NEW_LINES|FILE_SKIP_EMPTY_LINES);
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
    }
}