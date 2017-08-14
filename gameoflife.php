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
        echo "Breite zu Klein. Breite auf 5 gesetzt";
        $width = 5;
    }
}

if ($options->getOption("height"))
{
    $height = $options->getOption("height");
    if ($options->getOption("height") > 5)
    {
        echo "Höhe zu Klein. Höhe auf 5 gesetzt";
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
    echo "Version 1.0";
}

if ($options->getOption("help"))
{
    echo "Hilfe zu Game of Life";
    echo "\n";
    echo $options->showHelp();
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