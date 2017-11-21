<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

ini_set("memory_limit", "2048M");

$loader = require __DIR__ . "/vendor/autoload.php";
$loader->addPsr4("Input\\", __DIR__ . "/Inputs/");
$loader->addPsr4("Output\\", __DIR__ . "/Outputs/");
$loader->addPsr4("Output\\", __DIR__ . "/utilities/");
$loader->addPsr4("UlrichSG\\", __DIR__ . "/utilities/");
$loader->addPsr4("GameOfLife\\", __DIR__ . "/src/");
$loader->addPsr4("GifCreator\\", __DIR__ . "/utilities/");
$loader->addPsr4("Rule\\", __DIR__ . "/Rules/");

use GameOfLife\Board;
use GameOfLife\GameLogic;
use Input\BaseInput;
use Input\RandomInput;
use Output\BaseOutput;
use Output\ConsoleOutput;
use Rule\BaseRule;
use Rule\StandardRule;
use UlrichSG\GetOpt;

$options = new  GetOpt(array(
    array("i", "input", GetOpt::REQUIRED_ARGUMENT, "Auszuführendes Input auswählen. Standard: Random."),
    array("o", "output", GetOpt::REQUIRED_ARGUMENT, "Output des Feldes wählen. Standard: Console."),
    array("r", "rule", GetOpt::REQUIRED_ARGUMENT, "Wendet verschiedene Regeln für die nächste Generation an."),
    array("w", "width", GetOpt::REQUIRED_ARGUMENT, "Breite des Feldes auswählen. Standard: 20."),
    array("h", "height", GetOpt::REQUIRED_ARGUMENT, "Höhe des Feldes auswählen. Standard: 20"),
    array("s", "maxSteps", GetOpt::REQUIRED_ARGUMENT, "Maximale Anzahl der Generationen. Standard: 0"),
    array("t", "sleepTime", GetOpt::REQUIRED_ARGUMENT, "Pause zwischen jeder neuen Generation. Angabe in Sekunden. Standard: 0.0"),
    array("v", "version", GetOpt::NO_ARGUMENT, "Zeigt die aktuelle Version an."),
    array(null, "help", GetOpt::NO_ARGUMENT, "Zeigt die Hilfe an.\n"),
));

foreach (glob(__DIR__ . "/Inputs/*.php") as $input)
{
    $inputClassName = "Input\\" . basename($input, ".php");
    $inputClass = new $inputClassName();
    if ($inputClass instanceof BaseInput) $inputClass->addOptions($options);
}

foreach (glob(__DIR__ . "/Outputs/*.php") as $output)
{
    $outputClassName = "Output\\" . basename($output, ".php");
    $outputClass = new $outputClassName();
    if ($outputClass instanceof BaseOutput) $outputClass->addOptions($options);
}

foreach (glob(__DIR__ . "/Rules/*.php") as $rule)
{
    $ruleClassName = "Rule\\" . basename($rule, ".php");
    $ruleClass = new $ruleClassName();
    if ($ruleClass instanceof BaseRule) $ruleClass->addOptions($options);
}

$options->parse();

$height = 20;
$width = 20;
$maxSteps = 0;
$generation = 0;
$sleep = 0.0;
$inputClassName = null;
$outputClassName = null;
$ruleClassName = null;

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
    echo "Achtung! Ein großes Feld verbraucht viel RAM!\n";
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
        echo "Die Pause sollte nicht mehr als 5 Sekunden betragen!";
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

if ($options->getOption("rule"))
{
    if (class_exists("Rule\\" . $options->getOption("rule")))
    {
        $ruleClassName = "Rule\\" . $options->getOption("rule");
    }
    else
    {
        echo "Rule ->" . $options->getOption("rule") . ".php<- wurde nicht gefunden!";
        die();
    }
}

if ($options->getOption("version"))
{
    echo "Game of Life -- Version 1.8\n";
    return;
}

if ($options->getOption("help"))
{
    echo "Hilfe:\n\n";
    echo "Game of Life ist ein Generationen Spiel\n";
    echo "Spielregeln: (Achtung! Gilt nur für die Regeln nach Conway!)\n";
    echo "-Eine tote Zelle mit genau drei lebenden Nachbarn wird in der nächsten Generation neu geboren\n";
    echo "-Lebende Zellen mit weniger als zwei lebenden Nachbarn sterben in der nächsten Generation an Einsamkeit\n";
    echo "-Eine lebende Zelle mit zwei oder drei lebenden Nachbarn bleibt in der nächsten Generation am Leben\n";
    echo "-Lebende Zellen mit mehr als drei lebenden Nachbarn sterben in der nächsten Generation an Überbevölkerung\n";
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
    $input = new RandomInput();
}

if ($outputClassName != null)
{
    $output = new $outputClassName();
}
else
{
    $output = new ConsoleOutput();
}

if ($ruleClassName != null)
{
    $rule = new $ruleClassName();
}
else
{
    $rule = new StandardRule();
}

$board = new Board($width, $height);
$gameLogic = new GameLogic($rule);
$input->fillBoard($board, $options);

if ($maxSteps > 0)
{
    $output->startOutput($options);
    for ($i = 0; $i < $maxSteps; $i++)
    {
        $output->outputBoard($board, $options);
        $gameLogic->calculateNextBoard($board);
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
        $gameLogic->calculateNextBoard($board);
        usleep($sleep * 1000000);
    } while ($gameLogic->isLoopDetected($board) == false);

    $output->finishOutput($options);
}