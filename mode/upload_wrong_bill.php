<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/7
 * Time: 5:21 PM
 */

namespace data;


class upload_wrong_bill extends query_mode
{
    public function set_sql($index)
    {
        // TODO: Implement set_sql() method.
        $dispatch_filename = $this->file_name();
        $table_name = "rejecterror_bill_5g_history_" . $this->get_table_no();
        $end = $this->get_end();
        $begin = $this->get_begin();
        $this->sql = "SELECT
  T.err_code,
  COUNT(1) AS cnt,
  GROUP_CONCAT(DISTINCT a.PROV_NAME SEPARATOR \"/\") as pro
FROM $table_name t, tp_province a
WHERE SUBSTR(t.file_name, 17, 3) = a.prov_id
      AND t.item_type = 'LNIG'
      AND T.file_name LIKE '%$dispatch_filename%'
and t.log_time >=UNIX_TIMESTAMP('$begin')
and t.log_time <=UNIX_TIMESTAMP('$end')
GROUP BY T.err_code
ORDER BY cnt DESC";

    }

    public function to_array($row)
    {
        // TODO: Implement to_array() method.
        $this->data[] = $row;
    }


}