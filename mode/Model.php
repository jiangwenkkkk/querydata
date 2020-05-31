<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2020-05-31
 * Time: 14:43
 */

namespace data;


interface Model
{

    public function echo_tofile($conn, $myfile);

    public function init();

    public function init_data();

    public function get_data();

    public function set_data_value(&$data);

    public function set_all_bill(&$data);

    public function set_null_value(&$arr, $key);
}