<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/3
 * Time: 10:41 AM
 */

namespace data;
require_once("query_mode.php");


class own_dispatch extends query_mode
{
    private $data = [];
    public function set_sql($index)
    {
        // TODO: Implement setsql() method.
        $dn_num = $this->get_dn_num($index);
        $end = $this->get_end();
        $begin = $this->get_begin();
        $table_name = "history_log_".$this->get_table_no();


        $this->sql = "/* !HINT({\"dn\":[\"dn".$dn_num."\"]})*/
SELECT
  substr(t.output_file, 16, 3)  as roam_out_id,
  B.prov_name,
  count(DISTINCT t.output_file) AS dispatch_file_num,
  sum(t.output_bill_count)      AS dispatch_bill_num
FROM $table_name t, tp_province A, tp_province B
WHERE t.module_id = 2
      AND t.log_type = 3
      AND substr(input_file, 16, 3) = A.prov_id
      AND substr(output_file, 16, 3) = B.prov_id
      AND t.log_time >= UNIX_TIMESTAMP('${begin}')
      AND t.log_time < UNIX_TIMESTAMP('${end}')
GROUP BY roam_out_id
ORDER BY roam_out_id";
    }

    public function echo_tofile($conn, $myfile)
    {
        // TODO: Implement echo_tofile() method.
        $this->set_sql();
        echo $this->sql;
        echo "\n";
        $result = $conn->query($this->sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {

                $txt = "prov_id: " . $row["roam_out_id"] . "\t dispatch_file_num \t" . $row["dispatch_file_num"] . "\t dispatch_bill_num \t " . $row["dispatch_bill_num"] . "\n";
//

                fwrite($myfile, $txt);
            }
        } else {
            echo "0 results";
        }
    }

    public function set_data()
    {
        // TODO: Implement set_data() method.
        $this->set_sql();
        echo $this->sql;
        echo "\n";
        $result = $conn->query($this->sql);
        if ($result->num_rows > 0) {
            // output data of each row
            while ($row = $result->fetch_assoc()) {
                $this->data[$row['roam_out_id']] = array($row["dispatch_file_num"], $row["dispatch_bill_num"]);
            }
        } else {
            echo "0 results";
        }
    }

}