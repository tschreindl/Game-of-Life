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
 * Class Random
 *
 * @package GameOfLife\Inputs
 */

class Random extends BaseInput
{
    /**Fills the board random and set available options
     *
     * @param Board $_board
     * @param GetOpt $_options
     */
    function fillBoard($_board, $_options)

    {
        $percent = rand(20, 80);
        $fillingLVL = $_options->getOption("fillingLVL");
        if ($fillingLVL != null)
        {
            if ($_options->getOption("fillingLVL") < 1 || $_options->getOption("fillingLVL") > 100)
            {
                echo "Der Wert darf nur zwischen 1 und 100 liegen\n";
                echo "Zufälligen Füllungsgrad von ".$percent." % ausgewählt\n";
            }
            else
                $percent = $fillingLVL;
                echo "Füllgrad von ~".$percent."%\n";
        }
        for ($x=0; $x < $_board->width; $x++)
        {
            for ($y=0; $y < $_board->height; $y++)
            {
                $rand=rand( 1, 100);
                if ($rand <= $percent) $_board->setField($x,$y,true);
                if ($rand > $percent) $_board->setField($x,$y,false);
            }
        }
    }

    /**
     * Add available options
     * @param GetOpt $_options
     */
    function addOptions($_options)
    {
        $_options->addOptions(array(
            array(null, "fillingLVL", GetOpt::REQUIRED_ARGUMENT)
        ));
    }
}