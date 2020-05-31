<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/6
 * Time: 10:50 AM
 */

namespace data;


class dispatchfile_dispatchbill extends query_mode
{
    public function set_sql($index)
    {
        // TODO: Implement set_sql() method.
        $this->fileds=["省份","下发文件数", "下发话单量"];
        $dn_num = $this->get_dn_num($index);
        $end = $this->get_end();
        $begin = $this->get_begin();
        $table_name = "history_log_".$this->get_table_no();

        $this->sql = "/* !HINT({\"dn\":[\"dn$dn_num\"]})*/
SELECT
  substr(t.output_file, 16, 3)     roam_out,
  B.prov_name,
  count(DISTINCT t.output_file) AS dispatch_file,
  sum(t.output_bill_count)      AS dispatch_bill
FROM $table_name t, tp_province A, tp_province B
WHERE t.module_id = 2
      AND t.log_type = 3
      AND substr(input_file, 16, 3) = A.prov_id
      AND substr(output_file, 16, 3) = B.prov_id
      AND t.log_time >= UNIX_TIMESTAMP('$begin')
      AND t.log_time < UNIX_TIMESTAMP('$end')
GROUP BY roam_out
ORDER BY roam_out;";
    }

    public function to_array($row)
    {
        // TODO: Implement to_array() method.
        if (array_key_exists($this->get_id($row['roam_out']),$this->data))
        {
            if (array_key_exists('dispatchfile',$this->data[$this->get_id($row['roam_out'])]))
            {
                $this->data[$this->get_id($row['roam_out'])]['dispatchfile']+=$row['dispatch_file'];
            }
            else{
                $this->data[$this->get_id($row['roam_out'])]['dispatchfile']=$row['dispatch_file'];
            }

            if (array_key_exists('dispatchbill',$this->data[$this->get_id($row['roam_out'])]))
            {
                $this->data[$this->get_id($row['roam_out'])]['dispatchbill']+=$row['dispatch_bill'];
            }
            else{
                $this->data[$this->get_id($row['roam_out'])]['dispatchbill']=$row['dispatch_bill'];
            }
        }else
            $this->data[$this->get_id($row['roam_out'])] = ['dispatchfile'=>$row['dispatch_file'], 'dispatchbill'=>$row['dispatch_bill']];
    }



}