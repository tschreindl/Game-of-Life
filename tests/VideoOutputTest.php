<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use Output\VideoOutput;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../Outputs/VideoOutput.php";
require_once __DIR__ . "/../Board.php";
require_once "GetOptMock.php";

/**
 * Class VideoOutputTest
 */
class VideoOutputTest extends TestCase
{
    function testStartOutput()
    {
        $options = new GetOptMock();
        $videoOutput = new VideoOutput();
        $videoOutput->startOutput($options->createOpt());
        $this->expectOutputString("Frames werden erzeugt. Bitte warten...\n");
        $this->assertClassHasAttribute("path", VideoOutput::class);
        $this->assertClassHasAttribute("imageCreator", VideoOutput::class);
        $this->assertClassHasAttribute("keepFrames", VideoOutput::class);
        $this->assertClassHasAttribute("generation", VideoOutput::class);
        $this->assertFileExists($videoOutput->path);
    }

    function testOutputBoard()
    {
        $board = new \GameOfLife\Board(20, 20);
        $options = new GetOptMock();
        $videoOutput = new VideoOutput();
        $videoOutput->startOutput($options->createOpt());
        $videoOutput->outputBoard($board, $options->createOpt());
        $this->expectOutputString("Frames werden erzeugt. Bitte warten...\n\rAktuelle Generation: 1");
        $this->assertFileExists($videoOutput->path . "0001.png");
    }

    function testFinishOutput()
    {
        $board = new \GameOfLife\Board(20,20);
        $options = new GetOptMock();
        $videoOutput = new VideoOutput();
        $videoOutput->startOutput($options->createOpt());
        $videoOutput->outputBoard($board, $options->createOpt());
        $videoOutput->finishOutput($options->createOpt());
        $this->assertFileExists($videoOutput->path."/../GOL.avi");
    }

    function testAddOptions()
    {
        $options = new GetOptMock();
        $videoOutput = new VideoOutput();
        $videoOutput->addOptions($options->createOpt());
        $this->assertNotEmpty($videoOutput);
    }
}
