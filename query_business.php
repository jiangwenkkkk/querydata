
<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/2
 * Time: 5:52 PM
 */

require_once("autoload.php");
require_once ("global.php");


$time = date("H:i:s");
$date = date("Y-m-d");
$business_performance_mode = new \data\business_statistics_mode();
$business_view = new \data\business_statistics_view();
$business_controller = new business_statistics_controller($business_performance_mode, $business_view);

$date="2020-05-29";
if ($time<"11:00:00")
{
//    $d = strtotime("yesterday");
//    $date = date("Y-m-d", $d);
//    $business_controller->set_begin_end("00:00:00", "23:59:59",$date);
//    $business_controller->set_file("bussiness_ago.txt");
//    $business_controller->updateView();

//    $date = date("Y-m-d");
//    $date="2019-08-29";

    $business_controller->set_begin_end("9:00:00", "10:00:00", $date);//chose 0-24, 0-24
    $business_controller->set_file("bussiness_8.txt");
    $business_controller->updateView();

}
else{
//    $date = date("Y-m-d");
    $business_controller->set_begin_end("9:00:00", "10:00:00", $date);//chose 0-24, 0-24
    $business_controller->set_file("bussiness_18.txt");
    $business_controller->updateView();

}


