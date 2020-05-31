<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/3
 * Time: 9:29 AM
 */

namespace data;
require_once 'query_mode.php';

class wrong_bill extends query_mode
{
    public function set_sql($index)
    {
        $this->fileds=["省份", "省份id", "错误文件数","错误话单数"];
        $dn_num = $this->get_dn_num($index);
        $end = $this->get_end();
        $begin = $this->get_begin();
        $table_name = "history_log_".$this->get_table_no();
        // TODO: Implement setsql() method.
        $this->sql = "/* !HINT({\"dn\":[\"dn${dn_num}\"]})*/
SELECT
  PROV_NAME                             AS '省份',
  PROV_ID,
  count(t.log_id)                       AS wrong_file_num,
  sum(ifnull(t.output_errcdr_count, 0)) AS wrong_bill_num
FROM $table_name t
  RIGHT JOIN (SELECT *
              FROM tp_province
              WHERE prov_id NOT IN (1, 199)) a
    ON substr(input_file, 16, 3) = a.prov_id
       AND t.module_id = 1
       AND t.log_type = 3
       AND t.output_file LIKE 'E%'
       AND t.log_time >= UNIX_TIMESTAMP('${begin}')
       AND t.log_time < UNIX_TIMESTAMP('${end}')
GROUP BY prov_id
ORDER BY prov_id
";
    }



    /**
     * @param $row
     */
    protected function to_array($row)
    {
        if (array_key_exists($this->get_id($row['prov_id']),$this->data))
        {
            if (array_key_exists('wrong_bill',$this->data[$this->get_id($row['prov_id'])]))
            {
                $this->data[$this->get_id($row['prov_id'])]['wrong_bill']+=$row['wrong_bill_num'];
            }
            else{
                $this->data[$this->get_id($row['prov_id'])]['wrong_bill']=$row['wrong_bill_num'];
            }

        }else
            $this->data[$this->get_id($row['prov_id'])] = ['wrong_bill' => $row["wrong_bill_num"]];
//        $this->data[$this->get_id($row['roam_out'])] = ['dispatchfile'=>$row['dispatch_file'], 'dispatchbill'=>$row['dispatch_bill']];

    }

}