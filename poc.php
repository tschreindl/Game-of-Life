<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

include_once("Board.php");


$testBoard= new Board(20,20);
$testBoard->initRandom();

for ($i=0; $i<15; $i++)
{
    $testBoard->print();
    $testBoard=$testBoard->calculateNextStep();
}

