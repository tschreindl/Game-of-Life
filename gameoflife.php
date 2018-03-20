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
$loader->addPsr4("GameOfLife\\", __DIR__ . "/src/");
$loader->addPsr4("Rule\\", __DIR__ . "/Rules/");

use GameOfLife\Board;
use GameOfLife\GameLogic;
use Input\BaseInput;
use Input\RandomInput;
use Output\BaseOutput;
use Output\ConsoleOutput;
use Rule\BaseRule;
use Rule\StandardRule;
use Ulrichsg\Getopt;

$options = new  GetOpt(array(
    array("i", "input", GetOpt::REQUIRED_ARGUMENT, "Auszuführendes Input auswählen. Standard: Random."),
    array("o", "output", GetOpt::REQUIRED_ARGUMENT, "Output des Feldes wählen. Standard: Console."),
    array("r", "rule", GetOpt::REQUIRED_ARGUMENT, "Wendet verschiedene Regeln für die nächste Generation an. Standard: Conway"),
    array(null, "set-rule", GetOpt::REQUIRED_ARGUMENT, "Legt eine eigene Regel fest. Standard: Conway (23/3) "),
    array("w", "width", GetOpt::REQUIRED_ARGUMENT, "Breite des Feldes auswählen. Standard: 20."),
    array("h", "height", GetOpt::REQUIRED_ARGUMENT, "Höhe des Feldes auswählen. Standard: 20"),
    array("s", "steps", GetOpt::REQUIRED_ARGUMENT, "Anzahl die wievielte Generation immer ausgegeben werden soll. Standard: 1 (Jede)"),
    array("m", "maxSteps", GetOpt::REQUIRED_ARGUMENT, "Maximale Anzahl der Generationen. Standard: 0"),
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
$steps = 1;
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

if ($options->getOption("steps"))
{
    $steps = $options->getOption("steps");
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
    $getOptInput = $options->getOption("input");

    foreach (glob(__DIR__ . "/Inputs/*.php") as $input)
    {
        if (stristr(basename($input, ".php"), $getOptInput))
        {
            $getOptInput = basename($input, ".php");
            break;
        }
    }

    if (class_exists("Input\\" . $getOptInput))
    {
        $inputClassName = "Input\\" . $getOptInput;
    }
    else
    {
        echo "Input ->" . $getOptInput . ".php<- wurde nicht gefunden!";
        die();
    }
    if ($getOptInput == "GliderGun")
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
    $getOptOutput = $options->getOption("output");

    foreach (glob(__DIR__ . "/Outputs/*.php") as $output)
    {
        if (stristr(basename($output, ".php"), $getOptOutput))
        {
            $getOptOutput = basename($output, ".php");
            break;
        }
    }

    if (class_exists("Output\\" . $getOptOutput))
    {
        $outputClassName = "Output\\" . $getOptOutput;
    }
    else
    {
        echo "Output ->" . $getOptOutput . ".php<- wurde nicht gefunden!";
        die();
    }
}

if ($options->getOption("rule"))
{
    $getOptRule = $options->getOption("rule");

    foreach (glob(__DIR__ . "/Rules/*.php") as $rule)
    {
        if (stristr(basename($rule, ".php"), $getOptRule))
        {
            $getOptRule = basename($rule, ".php");
            break;
        }
    }

    if (class_exists("Rule\\" . $getOptRule))
    {
        $ruleClassName = "Rule\\" . $getOptRule;
    }
    else
    {
        echo "Rule ->" . $getOptRule . ".php<- wurde nicht gefunden!";
        die();
    }
}

if ($options->getOption("version"))
{
    echo "Game of Life -- Version 6.4\n";
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
    echo "-Lebende Zellen mit mehr als drei lebenden Nachbarn sterben in der nächsten Generation an Überbevölkerung\n\n";
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
    if ($options->getOption("set-rule"))
    {
        $rule->setRule($options->getOption("set-rule"));
    }
}

$board = new Board($width, $height);
$gameLogic = new GameLogic($rule);

echo "  ____                                __    _     _  __      
 / ___| __ _ _ __ ___   ___     ___  / _|  | |   (_)/ _| ___ 
| |  _ / _` | '_ ` _ \ / _ \   / _ \| |_   | |   | | |_ / _ \
| |_| | (_| | | | | | |  __/  | (_) |  _|  | |___| |  _|  __/
 \____|\__,_|_| |_| |_|\___|   \___/|_|    |_____|_|_|  \___|\n\n";

$input->fillBoard($board, $options);
if ($maxSteps > 0)
{
    $output->startOutput($options);
    for ($i = 0; $i <= $maxSteps; $i++)
    {
        $output->outputBoard($board, $options);
        if ($gameLogic->isEmpty($board)) break;
        for ($j = 0; $j < $steps; $j++)
        {
            $gameLogic->calculateNextBoard($board);
        }
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
        for ($j = 0; $j < $steps; $j++)
        {
            $gameLogic->calculateNextBoard($board);
        }
        usleep($sleep * 1000000);
    } while ($gameLogic->isLoopDetected($board) == false);

    $output->finishOutput($options);
}