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
 * Input Class to fill the board from an external tool.
 *
 * @package Input
 */
class FieldSelector extends BaseInput
{
    /**
     * Fills the board from an extern selector tool.
     *
     * @param Board $_board
     * @param GetOpt $_options
     */
    function fillBoard(Board $_board, GetOpt $_options)
    {
        echo "Das Selector Tool wird gestartet. Bitte warten...\n";
        if ($_board->width() > 90 || $_board->height() > 60) echo "Achtung! Zu große Felder können zu Problemen mit dem Selector Tool führen!\n";
        exec(__DIR__ . "/../utilities/FieldSelector.exe " . $_board->width() . " " . $_board->height(), $output, $return);
        if ($return != 0 || stristr($output[0], "exit")) die("Das Selector Tool wurde beendet.");
        if (!stristr($output[0], "1")) die("Keine Felder ausgewählt.");

        $explode = explode("|", $output[0]);

        foreach ($explode as $y => $line)
        {
            foreach (str_split($line) as $x => $field)
            {
                if ($field == 1)
                {
                    $_board->setField($x, $y, true);
                }
            }
        }
    }

}