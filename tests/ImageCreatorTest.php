<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use Output\ImageCreator;
use PHPUnit\Framework\TestCase;

require_once __DIR__."/../Board.php";
require_once __DIR__."/../ImageCreator.php";

/**
 * Class ImageCreatorTest
 */
class ImageCreatorTest extends TestCase
{
 function testCreateImage()
 {
     $board = new \GameOfLife\Board(20,20);
     $imageCreator = new ImageCreator(10,array(255,255,255), array(0,0,0));
     //$imageCreator->createImage($board);
     $this->assertNotEmpty($imageCreator->createImage($board));
 }
}
