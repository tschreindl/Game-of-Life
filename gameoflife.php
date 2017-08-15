<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

require_once "PSR4AutoLoader.php";

$loader = new Psr4Autoloader();
$loader->addNamespace("Input", __DIR__ . "/Inputs/");
$loader->addNamespace("UlrichSG", __DIR__ . "/");
$loader->addNamespace("GameOfLife", __DIR__ . "/");
$loader->register();

use GameOfLife\Board;
use UlrichSG\GetOpt;

$options = new  GetOpt(array(
    array("i", "input", GetOpt::OPTIONAL_ARGUMENT),
    array("w", "width", GetOpt::OPTIONAL_ARGUMENT),
    array("h", "height", GetOpt::OPTIONAL_ARGUMENT),
    array("s", "maxSteps", GetOpt::OPTIONAL_ARGUMENT),
    array("v", "version", GetOpt::NO_ARGUMENT),
    array("r", "help", GetOpt::NO_ARGUMENT),
));

foreach (glob(__DIR__ . "/Inputs/*.php") as $input)
{
    $className = "Input\\".basename($input, ".php");
    $inputClass = new $className();
    $inputClass->addOptions($options);

}

$options->parse();

$height = 10;
$width = 10;
$maxSteps = 0;
$generation = 0;

if ($options->getOption("width"))
{
    $width = $options->getOption("width");
    if ($options->getOption("width") < 5)
    {
        echo "Breite ->".$options->getOption("height")."<- ist zu klein. Breite wurde auf 5 gesetzt!\n\n";
        $width = 5;
    }
}

if ($options->getOption("height"))
{
    $height = $options->getOption("height");
    if ($options->getOption("height") < 5)
    {
        echo "Höhe ->".$options->getOption("height")."<- ist zu klein. Höhe wurde auf 5 gesetzt!\n\n";
        $height = 5;
    }
}

$board = new Board($width, $height);

if ($options->getOption("maxSteps"))
{
    $maxSteps = $options->getOption("maxSteps");
}

$className = "Input\\Random";

if ($options->getOption("input"))
{

    if (class_exists("Input\\".$options->getOption("input")))
    {
        $className = "Input\\".$options->getOption("input");
    }
}

$input = new $className($width, $height);
$input->fillBoard($board, $options);

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
    echo $options->showHelp();
}

if ($maxSteps > 0)
{
     for ($i = 0; $i <= $maxSteps; $i++)
     {
         echo "Aktuelle Generation: ";
         echo $generation;
         echo "\n";
         $generation++;

         for ($strokes = 1; $strokes <= $width; $strokes++)
         {
             echo "---";
         }
         echo "\n";
         
         $board->print();
         $board->calculateNextStep();
     }
}
else
{
    do{
        echo "Aktuelle Generation: ";
        echo $generation;
        echo "\n";
        $generation++;

        for ($strokes = 1; $strokes <= $width; $strokes++)
        {
            echo "---";
        }
        echo "\n";

        $board->print();
        $board->calculateNextStep();
    } while($board->isFinished() == false);
}