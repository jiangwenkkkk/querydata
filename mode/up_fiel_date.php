<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2020-05-31
 * Time: 12:54
 */


namespace data;

class UpFileDate extends \data\query_mode
{
    public function set_sql($index)
    {
        $dn_num = $this->get_dn_num($index);
        $end = $this->get_end();
        $begin = $this->get_begin();
        $table_name = "history_log_".$this->get_table_no();
        $this->fileds=["省份", "文件数", "正确话单量"];
        $date_time = $this->get_date($begin, $end);

        $this->sql = "/* !HINT({\"dn\":[\"dn" . $dn_num . "\"]})*/
select substr(t.input_file,16,3) as id, count(t.log_id) as file_num, sum(IFNULL(t.output_bill_count,0)) as right_bill_num from  $table_name t 
where  t.module_id =1
and t.log_type =3
and substr(t.input_file, 6, 10) in ($date_time)

group by substr(t.input_file,16,3)
order by substr(t.input_file,16,3)";
    }


    /**
     * @param $row
     */
    protected function to_array($row)
    {

        if (array_key_exists($this->get_id($row['id']),$this->data))
        {
            if (array_key_exists('uploadfile',$this->data[$this->get_id($row['id'])]))
            {
                $this->data[$this->get_id($row['id'])]['uploadfile']+=$row['file_num'];
            }
            else{
                $this->data[$this->get_id($row['id'])]['uploadfile']=$row['file_num'];
            }

            if (array_key_exists('rightbill',$this->data[$this->get_id($row['id'])]))
            {
                $this->data[$this->get_id($row['id'])]['rightbill']+=$row['right_bill_num'];
            }
            else{
                $this->data[$this->get_id($row['id'])]['rightbill']=$row['right_bill_num'];
            }
        }
        else
            $this->data[$this->get_id($row['id'])] = ["uploadfile" => $row['file_num'], "rightbill" => $row['right_bill_num']];

        //        $this->data[$this->get_id($row['roam_out'])] = ['dispatchfile'=>$row['dispatch_file'], 'dispatchbill'=>$row['dispatch_bill']];



    }

    private function get_date($begin, $end)
    {
        return "'".date_format($begin,'YmdH' )."''";

    }
}