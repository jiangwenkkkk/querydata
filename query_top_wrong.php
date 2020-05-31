<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2019-01-14
 * Time: 15:15
 */


namespace data;
require_once("autoload.php");
require_once ("global.php");


$date = date("Y-m-d");
$date = date("2019-10-14");

$top_three_mode = new top_3_wrong_bill();
$top_three_view = new top_three_view();
$top_three_controller = new top_three_wrong_controller($top_three_mode, $top_three_view);

$top_three_view->set_file("top_three_ago.txt");
$top_three_controller->updateView();

$top_three_view->set_file("top_three_18today.txt");
$top_three_controller->set_begin_end("00:00:00", "18:00:00", $date);//chose 0-24, 0-24

$top_three_controller->updateView();

$top_three_view->set_file("top_three_8today.txt");
$top_three_controller->set_begin_end("00:00:00", "08:00:00", $date);//chose 0-24, 0-24

$top_three_controller->updateView();


