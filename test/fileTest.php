<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2019-01-27
 * Time: 17:12
 */


class fileTest extends PHPUnit_Framework_TestCase
{
    public function testFileputcontent()
    {
        file_put_contents("hello", "afa", FILE_APPEND);
    }
}
