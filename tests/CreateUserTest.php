<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

use PHPUnit\Framework\TestCase;
require_once "CreateUser.php";

/**
 * Class CreateUserTest
 */
class CreateUserTest extends TestCase
{
    public function testCreateUser()
    {
    $name = "Tim";
    $language = "German";

    $newUser = new CreateUser($name, $language);
    $this->assertEquals($name, $newUser->createNewUser());
    $this->assertEquals($language, $newUser->getLanguage());
    }

    public function testArray()
    {
        $arr = [];
        for ($i = 0; $i < 10; $i++)
        {
            array_push($arr, false);
            $this->assertEquals(false, $arr[$i]);
        }
        $this->assertEquals(10, count($arr));
    }
}
