<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/3
 * Time: 10:13 AM
 */

namespace data;
require_once("query_mode.php");

class reject_file extends query_mode
{
    public function set_sql($index)
    {
        // TODO: Implement setsql() method.
        $this->fileds=["省份id","拒收文件数"];
        $dn_num = $this->get_dn_num($index);
        $end = $this->get_end();
        $begin = $this->get_begin();
        $table_name = "history_log_".$this->get_table_no();

        $this->sql = "/* !HINT({\"dn\":[\"dn${dn_num}\"]})*/
SELECT
  substr(t.input_file, 16, 3) as prov_id,
  count(t.log_id) AS reject_num,
  sum(t.output_errcdr_count)
FROM $table_name t
WHERE t.module_id = 1
      AND t.log_type = 3
      AND t.output_file LIKE 'F%'
      AND t.log_time >= UNIX_TIMESTAMP('$begin')
      AND t.log_time < UNIX_TIMESTAMP('$end')
GROUP BY substr(t.input_file, 16, 3)
ORDER BY substr(t.input_file, 16, 3)";

    }

    public function echo_tofile($conn, $myfile)
    {
        // TODO: Implement echo_tofile() method.
        $this->set_sql();
        echo $this->sql;
        $result = $conn->query($this->sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {

                $txt = "省份: " . $row["prov_id"] . "\t 拒收文件数 \t" . $row["reject_num"] . "\n";
//

                fwrite($myfile, $txt);
            }
        } else {
            echo "0 results";
        }
    }


    /**
     * @param $row
     */
    protected function to_array($row)
    {
        if (array_key_exists($this->get_id($row['prov_id']),$this->data))
        {
            if (array_key_exists('reject_num',$this->data[$this->get_id($row['prov_id'])]))
            {
                $this->data[$this->get_id($row['prov_id'])]['reject_num']+=$row['reject_num'];
            }
            else{
                $this->data[$this->get_id($row['prov_id'])]['reject_num']=$row['reject_num'];
            }

        }else
            $this->data[$this->get_id($row['prov_id'])] = ['reject_num' => $row['reject_num']];


//        $this->data[$this->get_id($row['roam_out'])] = ['dispatchfile'=>$row['dispatch_file'], 'dispatchbill'=>$row['dispatch_bill']];
    }

}