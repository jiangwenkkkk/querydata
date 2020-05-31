<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/3
 * Time: 5:53 PM
 */

namespace data;
require_once("autoload.php");


//$performance_controller->set_begin_end("00:00:00", "01:00:00", "2018-12-07");//chose 0-24, 0-24
$index_len = 2;

$business_performance_mode = new performance_mode();
$performance_view = new performance_view();
$performance_controller = new performance_controller($business_performance_mode, $performance_view);


$time = date("H:i:s");
$date = date("Y-m-d");
$date = "2019-12-12";

$mode = "performance";
$time = "8-16";
if ($time == true)
{
    $performance_controller->set_begin_end("08:00:00", "16:00:00", $date);//chose 0-24, 0-24

    $performance_controller->set_file("performance_ago.txt");
    $performance_controller->update_View();
//
//
//    $performance_controller->set_file("performance_ago.txt");
//    $performance_controller->update_View();
//
//    $business_performance_mode = new \data\business_statistics_mode();
//    $business_view = new \data\business_statistics_view();
//    $business_controller = new business_statistics_controller($business_performance_mode, $business_view);
//    $business_controller->set_file("bussiness_ago.txt");
//
//    $business_controller->updateView();
//
//
//
//    $business_controller->set_begin_end("00:00:00", "9:00:00", "2019-01-13");//chose 0-24, 0-24
//    $business_controller->set_file("bussiness_9.txt");
//    $business_controller->updateView();
//
//    $performance_controller->update_View();

}
else{

    $performance_controller->set_begin_end("10:00:00", "11:00:00", $date);//chose 0-24, 0-24
    $performance_controller->set_file("performance_now.txt");
    $performance_controller->update_View();

}

