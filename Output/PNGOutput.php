<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

namespace Output;


/**
 * Class PNGOutput
 *
 * @package Output
 */
class PNGOutput extends BaseOutput
{
    private $imageCreator;

    function startOutput($_options)
    {
        echo "PNG Dateien werden erzeugt. Bitte warten...\n";
    }

    function outputBoard($_board, $_options)
    {
        // initialize Image Creator
        $imageCreator = new Imagecreator($_board);
        $imageCreator->createImage($_board, "png");
    }

    function addOptions($_options)
    {
    }
}