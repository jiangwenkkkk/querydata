<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/3
 * Time: 11:07 AM
 */

namespace data;


class own_wrong_bill extends query_mode
{
    public function set_sql($index)
    {
        // TODO: Implement setsql() method.
        $this->fileds=["省份", "省份id", "归属省错单"];
        $file_name = $this->file_name($index);
        $end = $this->get_end();
        $begin = $this->get_begin();
        $table_name = "rejecterror_bill_5g_history_".$this->get_table_no();
        $this->sql = "SELECT
  a.PROV_NAME AS prov_name,
         SUBSTR(t.file_name, 17, 3) as prov_id,
  COUNT(1)    AS own_wrong_bill
FROM $table_name t, tp_province a
WHERE SUBSTR(t.file_name, 17, 3) = a.prov_id
      AND t.item_type = 'LNDG'
      AND t.file_name LIKE '%${file_name}%'
        AND t.log_time >= UNIX_TIMESTAMP('${begin}')
       AND t.log_time < UNIX_TIMESTAMP('${end}')
GROUP BY a.PROV_NAME";
    }



    /**
     * @param $row
     */
    protected function to_array($row)
    {
        if (array_key_exists($this->get_id($row['prov_id']),$this->data))
        {
            if (array_key_exists('own_wrong_bill',$this->data[$this->get_id($row['prov_id'])]))
            {
//                $this->data[$this->get_id($row['prov_id'])]['own_wrong_bill']+=$row['own_wrong_bill'];
            }
            else{
                $this->data[$this->get_id($row['prov_id'])]['own_wrong_bill']=$row['own_wrong_bill'];
            }

        }
        else
            $this->data[$this->get_id($row['prov_id'])] = ['own_wrong_bill' => $row["own_wrong_bill"]];
            //        $this->data[$this->get_id($row['roam_out'])] = ['dispatchfile'=>$row['dispatch_file'], 'dispatchbill'=>$row['dispatch_bill']];

    }

}