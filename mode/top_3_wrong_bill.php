<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/7
 * Time: 5:38 PM
 */

namespace data;


use function my\functionaa\simple\echoException;

class top_3_wrong_bill
{
    private $upload_wrong_bill;
    private $dispatch_wrong_bill;

    private function init()
    {
        $this->upload_wrong_bill = new upload_wrong_bill();
        $this->dispatch_wrong_bill = new dispatch_wrong_bill();
    }
    private function init_data()
    {
        try {
            $this->init();
            $this->upload_wrong_bill->set_data();
            $this->dispatch_wrong_bill->set_data();
        } catch (\Exception $exception) {
            echo $exception->getFile();
            echo $exception->getLine();
        }
    }

    public function get_data()
    {
        $this->init_data();
        $data = [];
        $tmp = $this->upload_wrong_bill->get_data();
        $data[] = $this->get_three_data($tmp);
        $tmp = $this->dispatch_wrong_bill->get_data();
        $data[] = $this->get_three_data($tmp);




        return $data;
    }

    private function get_three_data($data)
    {
        $result = [];
        for ($i = 0; $i < 3; $i++)
        {
            if (array_key_exists($i,$data))
                $result[$i] = $data[$i];
            else
                $result[$i] ="";
        }
        return $result;
    }

    public function get_top_3($data)
    {
        $result = [];
        for ($i = 0; $i++; $i < 4)
        {
            $result[$i]=$data[$i];
        }
        return $result;
    }

}