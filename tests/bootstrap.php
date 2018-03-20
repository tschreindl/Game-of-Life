<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

$loader = require __DIR__ . "/../vendor/autoload.php";
$loader->addPsr4("Input\\", __DIR__ . "/../Inputs/");
$loader->addPsr4("Output\\", __DIR__ . "/../Outputs/");
$loader->addPsr4("Output\\", __DIR__ . "/../utilities/");
$loader->addPsr4("GameOfLife\\", __DIR__ . "/../src/");
$loader->addPsr4("Rule\\", __DIR__ . "/../Rules/");