<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2020-05-31
 * Time: 14:33
 */


require_once("autoload.php");
require_once ("global.php");



class Test extends PHPUnit_Framework_TestCase
{
    Public function testFileNum()
    {
        $time = date("H:i:s");
        $date = date("Y-m-d");
        $business_performance_mode = new \data\business_statistics_mode();
        $business_view = new \data\business_statistics_view();
        $business_controller = new business_statistics_controller($business_performance_mode, $business_view);

        $date="2020-05-29";

        $business_controller->set_begin_end("9:00:00", "10:00:00", $date);//chose 0-24, 0-24
        $business_controller->set_file("bussiness_8.txt");
        $business_controller->updateView();



    }
}
