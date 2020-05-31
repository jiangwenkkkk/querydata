<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/5
 * Time: 11:32 AM
 */

namespace data;

use PhpOffice\PhpSpreadsheet\Exception;

class performance_mode
{
    private $all_average_speed;
    private $all_average_time;
    private $all_time_percent;
    private $part_average_speed;
    private $part_average_time;
    private $part_time_percent;

    public function echo_tofile($conn, $myfile)
    {
        $this->init();
        $this->echo_all($conn, $myfile);
    }

    private function init()
    {
        $this->all_average_speed = new all_average_speed();
        $this->all_average_time = new all_average_time();
        $this->all_time_percent = new all_time_percent();
        $this->part_average_speed = new part_average_speed();
        $this->part_average_time = new part_average_time();
        $this->part_time_percent = new part_time_percent();
//        $this->own_dispatch = new own_dispatch();
    }

    private function echo_all($conn, $myfile)
    {

//        $this->own_dispatch->echo_tofile($conn, $myfile);
    }

    private function set_data()
    {
        $this->init();
        try {
            $this->all_average_speed->set_data();
            $this->all_average_time->set_data();
            $this->all_time_percent->set_data();
            $this->part_time_percent->set_data();
            $this->part_average_time->set_data();
            $this->part_average_speed->set_data();
        } catch (Exception $e) {
            echo $e->getFile();
        }

    }


    public function get_data()
    {
        $this->set_data();
        $f = $this->all_average_speed->get_data();
        $a = $this->all_average_time->get_data();
        $b = $this->all_time_percent->get_data();
        $c = $this->part_time_percent->get_data();
        $d = $this->part_average_time->get_data();
        $e = $this->part_average_speed->get_data();

        $data = array_merge_recursive($this->all_average_speed->get_data(),
            $this->all_average_time->get_data(),
            $this->all_time_percent->get_data(),
            $this->part_time_percent->get_data(),
            $this->part_average_time->get_data(),
            $this->part_average_speed->get_data());
        return $data;
    }


}