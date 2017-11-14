<?php
/**
 * @file
 * @version 0.1
 * @copyright 2017 CN-Consult GmbH
 * @author Tim Schreindl <tim.schreindl@cn-consult.eu>
 */

/**
 * Test Class CreateUser for a simple Unit test.
 */
class CreateUser
{
    private $user = "";
    private $language = "German";

    public function __construct($_user, $_language)
    {
        $this->user = $_user;
        $this->language = $_language;
    }

    public function createNewUser()
    {
        return $this->user;
    }

    public function getLanguage()
    {
        return $this->language;
    }
}