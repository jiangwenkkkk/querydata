<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/5
 * Time: 11:26 AM
 */

namespace data;


class performance_view extends view
{

    public function printBussinessDetails($data)
    {
        $this->_file = fopen($this->file_name, "w");
        $re = $this->get_text($data);
        fwrite($this->_file, $re);
    }

    /**
     * @param $data
     */
    public function get_text($data)
    {
        $re = "\n";
        $keys=["id10",
            "id20",
            "id21",
            "id22",
            "id23",
            "id24",
            "id25",
            "id27",
            "id28",
            "id29",
            "id311",
            "id351",
            "id371",
            "id431",
            "id451",
            "id471",
            "id531",
            "id551",
            "id571",
            "id591",
            "id731",
            "id771",
            "id791",
            "id851",
            "id871",
            "id891",
            "id898",
            "id931",
            "id951",
            "id971",
            "id991"];

        foreach ($keys as $key ) {
            $re .= $key."\t";
            if(key_exists($key,$data))
            {
                $item=$data[$key];
                $re .= $item['speed'] . "\t";
                $re .= $item['time'] . "\t";
                $re .= $item['less60'] . "\t";
                $re .= $item['less120'] . "\t";
                $re .= $item['more120'] . "\t";
            }
            $re .= "\n";
        }

        echo $re;
        return $re;
    }

    public function print_data($data)
    {
        $this->printBussinessDetails($data);
    }
}