<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use Output\GifOutput;
use PHPUnit\Framework\TestCase;

require_once "GetOptMock.php";

/**
 * Tests that the class GifOutput works as expected.
 */
class GifOutputTest extends TestCase
{
    function testStartOutput()
    {
        $options = new GetOptMock();
        $gifOutput = new GifOutput();
        $gifOutput->startOutput($options->createOpt());
        $this->expectOutputString("Gif Datei wird erzeugt. Bitte warten...\n");
        $this->assertClassHasAttribute("path", GifOutput::class);
        $this->assertClassHasAttribute("imageCreator", GifOutput::class);
        $this->assertClassHasAttribute("frames", GifOutput::class);
        $this->assertClassHasAttribute("frameTime", GifOutput::class);
        //$this->assertFileExists($gifOutput->path);
        $this->assertDirectoryNotExists($gifOutput->path);
    }

    function testOutputBoard()
    {
        $board = new Board(20, 20);
        $gifOutput = new GifOutput();
        $options = new GetOptMock();
        $gifOutput->startOutput($options->createOpt());
        $gifOutput->outputBoard($board, $options->createOpt());
        $this->assertNotEmpty($gifOutput->frames);
        $this->expectOutputString("Gif Datei wird erzeugt. Bitte warten...\n\r1 Generationen berechnet");
    }

    function testFinishOutput()
    {
        $board = new Board(20, 20);
        $options = new GetOptMock();
        $gifOutput = new GifOutput();
        $gifOutput->startOutput($options->createOpt());
        $gifOutput->outputBoard($board, $options->createOpt());
        $gifOutput->finishOutput($options->createOpt());
        $this->assertDirectoryExists($gifOutput->path);
        $this->assertFileExists($gifOutput->path . "/Gif_1.gif");
        $this->expectOutputString("Gif Datei wird erzeugt. Bitte warten...\n\r1 Generationen berechnet\nGIF Datei wurde erzeugt.\n");

    }

    function testAddOptions()
    {
        $gifOutput = new GifOutput();
        $options = new GetOptMock();
        $gifOutput->addOptions($options->createOpt());
        $this->assertNotEmpty($gifOutput);
    }
}
