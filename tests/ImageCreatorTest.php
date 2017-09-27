<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use GameOfLife\Board;
use Output\ImageCreator;
use PHPUnit\Framework\TestCase;

require_once __DIR__ . "/../Board.php";
require_once __DIR__ . "/../utilities/ImageCreator.php";

/**
 * Class ImageCreatorTest
 */
class ImageCreatorTest extends TestCase
{
    function testCreateImage()
    {
        $board = new Board(20, 20);
        $imageCreator = new ImageCreator(null, null, null);
        $this->assertNotEmpty($imageCreator->createImage($board));
    }

    function testGetColor()
    {
        $imageCreator = new ImageCreator(null, null, null);
        $color = $imageCreator->getColor("#FF00FF");
        $this->arrayHasKey($color);
        $this->assertEquals(255, $color[0]);
        $this->assertEquals(0, $color[1]);
        $this->assertEquals(255, $color[2]);

        $color = $imageCreator->getColor("135,135,135");
        $this->arrayHasKey($color);
        $this->assertEquals(135, $color[0]);
        $this->assertEquals(135, $color[1]);
        $this->assertEquals(135, $color[2]);
    }
}
