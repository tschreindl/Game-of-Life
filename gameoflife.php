<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

ini_set("memory_limit", "1024M");

require_once "PSR4AutoLoader.php";
require_once "ImageCreator.php";

$loader = new Psr4Autoloader();
$loader->addNamespace("Input", __DIR__ . "/Inputs/");
$loader->addNamespace("Output", __DIR__ . "/Outputs/");
$loader->addNamespace("UlrichSG", __DIR__ . "/");
$loader->addNamespace("GameOfLife", __DIR__ . "/");
$loader->addNamespace("GifCreator", __DIR__ . "/");
$loader->register();

use GameOfLife\Board;
use UlrichSG\GetOpt;

$options = new  GetOpt(array(
    array("i", "input", GetOpt::REQUIRED_ARGUMENT, "Auszuführendes Input auswählen. Standard: Random."),
    array("o", "output", GetOpt::REQUIRED_ARGUMENT, "Output des Feldes wählen. Standard: Console."),
    array("w", "width", GetOpt::REQUIRED_ARGUMENT, "Breite des Feldes auswählen. Standard: 10."),
    array("h", "height", GetOpt::REQUIRED_ARGUMENT, "Höhe des Feldes auswählen. Standard: 10"),
    array("s", "maxSteps", GetOpt::REQUIRED_ARGUMENT, "Maximale Anzahl der Generationen. Standard: 0"),
    array("t", "sleepTime", GetOpt::REQUIRED_ARGUMENT, "Pause zwischen jeder neuen Generation. Angabe in Sekunden. Standard: 0.0"),
    array("v", "version", GetOpt::NO_ARGUMENT, "Zeigt die aktuelle Version an."),
    array("r", "help", GetOpt::NO_ARGUMENT, "Zeigt die Hilfe an."),
));

foreach (glob(__DIR__ . "/Inputs/*.php") as $input)
{
    $inputClassName = "Input\\" . basename($input, ".php");
    $inputClass = new $inputClassName();
    $inputClass->addOptions($options);
}

foreach (glob(__DIR__ . "/Outputs/*.php") as $output)
{
    $outputClassName = "Output\\" . basename($output, ".php");
    $outputClass = new $outputClassName();
    $outputClass->addOptions($options);
}

$options->parse();

$height = 20;
$width = 20;
$maxSteps = 0;
$generation = 0;
$sleep = 0.0;
$inputClassName = null;
$outputClassName = null;

if ($options->getOption("width"))
{
    $width = $options->getOption("width");
    if ($width < 5)
    {
        echo "Breite ->" . $width . "<- ist zu klein.\n\n";
        die();
    }
}

if ($options->getOption("height"))
{
    $height = $options->getOption("height");
    if ($height < 5)
    {
        echo "Höhe ->" . $height . "<- ist zu klein.\n\n";
        die();
    }
}

if ($width > 80 || $height > 80)
{
    echo "Achtung! Ein großes Feld verbraucht viel RAM!";
    sleep(2);
}

if ($options->getOption("maxSteps"))
{
    $maxSteps = $options->getOption("maxSteps");
    if ($maxSteps >= 10000)
    {
        echo "Maximale Anzahl von Schritten ist 9999!";
        die();
    }
}

if ($options->getOption("sleepTime"))
{
    $sleep = $options->getOption("sleepTime");
    if ($sleep > 5)
    {
        echo "Sleeptime sollte nicht mehr als 5 Sekunden betragen!";
        die();
    }
}

if ($options->getOption("input"))
{

    if (class_exists("Input\\" . $options->getOption("input")))
    {
        $inputClassName = "Input\\" . $options->getOption("input");
    }
    else
    {
        echo "Input ->" . $options->getOption("input") . ".php<- wurde nicht gefunden!";
        die();
    }
    if ($options->getOption("input") == "GliderGun")
    {
        if ($width < 37 || $height < 11)
        {
            echo "-->Für die Glider Gun sollte mindestens eine Breite von 37 und eine Höhe von 11 angegeben werden!<--\n";
            sleep(3);
        }
    }
}

if ($options->getOption("output"))
{
    if (class_exists("Output\\" . $options->getOption("output")))
    {
        $outputClassName = "Output\\" . $options->getOption("output");
    }
    else
    {
        echo "Output ->" . $options->getOption("output") . ".php<- wurde nicht gefunden!";
        die();
    }
}

if ($options->getOption("version"))
{
    echo "Game of Life -- Version 1.1\n";
    return;
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
    $options->showHelp();
    return;
}

if ($inputClassName != null)
{
    $input = new $inputClassName();
}
else
{
    $input = new Input\Random();
}

if ($outputClassName != null)
{
    $output = new $outputClassName();
}
else
{
    $output = new Output\ConsoleOutput();
}

$board = new Board($width, $height);
$input->fillBoard($board, $options);

if ($maxSteps > 0)
{
    $output->startOutput($options);
    for ($i = 0; $i < $maxSteps; $i++)
    {
        $output->outputBoard($board, $options);
        $board->calculateNextStep();
        usleep($sleep * 1000000);
    }
    echo "\nAnzahl von $maxSteps Generationen erreicht.";
    $output->finishOutput($options);
}
else
{
    $output->startOutput($options);

    do
    {
        $output->outputBoard($board, $options);
        $board->calculateNextStep();
        usleep($sleep * 1000000);
    } while ($board->isFinished() == false);

    $output->finishOutput($options);
}