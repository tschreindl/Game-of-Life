<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

include_once"Board.php";
include_once "GetOpt.php";

$options = new  GetOpt(array(
    array("r", "startRandom", GetOpt::NO_ARGUMENT),
    array("g", "startGlider", GetOpt::NO_ARGUMENT),
    array("w", "width", GetOpt::OPTIONAL_ARGUMENT),
    array("h", "height", GetOpt::OPTIONAL_ARGUMENT),
    array("s", "maxSteps", GetOpt::OPTIONAL_ARGUMENT),
    array("f", "maxFutureGenerations", GetOpt::OPTIONAL_ARGUMENT),
    array("v", "version", GetOpt::NO_ARGUMENT),
    array("i", "help", GetOpt::NO_ARGUMENT),
));

$options->parse();


$height = 5;
$width = 5;
$startType = 1;
$maxSteps = 0;
$futureGenerations = 1;
$generation = 0;


if ($options->getOption("startRandom"))
{
    $startType = 0;
} elseif ($options->getOption("startGlider"))
{
    $startType = 1;
}

if ($options->getOption("width"))
{
    $width = $options->getOption("width");
    if ($options->getOption("width") > 5)
    {
        echo "Breite ->".$options->getOption("height")."<- ist zu klein. Breite wurde auf 5 gesetzt!\n\n";
        $width = 5;
    }
}

if ($options->getOption("height"))
{
    $height = $options->getOption("height");
    if ($options->getOption("height") > 5)
    {
        echo "Höhe ->".$options->getOption("height")."<- ist zu klein. Höhe wurde auf 5 gesetzt!\n\n";
        $height = 5;
    }
}

if ($options->getOption("maxSteps"))
{
    $maxSteps = $options->getOption("maxSteps");
}

if ($options->getOption("maxFutureSteps"))
{
    $futureGenerations = $options->getOption("maxFutureSteps");
}

if ($options->getOption("version"))
{
    echo "Game of Life -- Version 1.0\n";
}

if ($options->getOption("help"))
{
    echo "Hilfe:\n\n";
    echo "Conways Game of Life ist ein Generationen Spiel\n";
    echo "Spielregeln:\n";
    echo "-Eine tote Zelle mit genau drei lebenden Nachbarn wird in der Folgegeneration neu geboren\n";
    echo "-Lebende Zellen mit weniger als zwei lebenden Nachbarn sterben in der Folgegeneration an Einsamkeit\n";
    echo "-Eine lebende Zelle mit zwei oder drei lebenden Nachbarn bleibt in der Folgegeneration am Leben\n";
    echo "-Lebende Zellen mit mehr als drei lebenden Nachbarn sterben in der Folgegeneration an Überbevölkerung\n";
    echo "\n";
    echo $option->showHelp();
}

$board = new Board($width, $height);

if ($startType == 1)
{
    $board->initRider();
}
else
{
    $board->initRandom();
}

if ($maxSteps > 0)
{
     for ($i = 0; $i <= $maxSteps; $i++)
     {
         echo "Aktuelle Generation: ";
         echo $generation;
         echo "\n";
         $generation++;


         $board->print();
         $board=$board->calculateNextStep();
     }
}
else
{
    do{
        $board->print();
        $board=$board->calculateNextStep();
    } while($board->_isFinish($futureGenerations) == false);
}