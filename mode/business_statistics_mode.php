<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/3
 * Time: 10:02 AM
 */

namespace data;

class business_statistics_mode
{
    private $uploadfile_rightbill;
    private $wrong_bill;
    private $reject_file;
    private $dispatchfile_dispatchbill;
    private $own_wrong_bill;

    public function echo_tofile($conn, $myfile)
    {
        $this->init();
        $this->echo_all($conn, $myfile);
    }

    private function init()
    {
        $this->uploadfile_rightbill = new uploadfile_rightbill();
        $this->wrong_bill = new wrong_bill();
        $this->reject_file = new reject_file();
        $this->dispatchfile_dispatchbill = new dispatchfile_dispatchbill();
        $this->own_wrong_bill = new own_wrong_bill();


//        $this->own_dispatch = new own_dispatch();
    }

    private function init_data()
    {
        try {
            $this->init();
            $this->uploadfile_rightbill->set_data();
            $this->wrong_bill->set_data();
            $this->reject_file->set_data();
            $this->dispatchfile_dispatchbill->set_data();
            $this->own_wrong_bill->set_data();
        } catch (\Exception $exception) {
            echo $exception->getFile();
            echo $exception->getLine();
        }

    }

    public function get_data()
    {
        $this->init_data();
        $data = array_merge_recursive($this->dispatchfile_dispatchbill->get_data(),
            $this->wrong_bill->get_data(),
            $this->uploadfile_rightbill->get_data(),
            $this->reject_file->get_data(),

            $this->own_wrong_bill->get_data());
        $this->set_data_value($data);
        $this->set_all_bill($data);
        return $data;
    }

    private function set_data_value(&$data)
    {
        foreach ($data as &$pro_data) {
            $this->set_null_value($pro_data, 'dispatchbill');
            $this->set_null_value($pro_data, 'uploadfile');
            $this->set_null_value($pro_data, 'all_bill');
            $this->set_null_value($pro_data, 'wrong_bill');
            $this->set_null_value($pro_data, 'reject_num');
            $this->set_null_value($pro_data, 'rightbill');
            $this->set_null_value($pro_data, 'dispatchfile');

            $this->set_null_value($pro_data, 'own_wrong_bill');
        }

    }

    private function set_all_bill(&$data)
    {
        foreach ($data as &$pro_data) {
            $pro_data['all_bill'] = $pro_data['wrong_bill'] + $pro_data['rightbill'];
        }
    }

    private function set_null_value(&$arr, $key)
    {
        if (array_key_exists($key, $arr)) {
            return $arr[$key];
        } else {
            $arr[$key] = 0;
            return $arr[$key];
        }
    }
}