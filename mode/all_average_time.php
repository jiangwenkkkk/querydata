<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/3
 * Time: 6:24 PM
 */

namespace data;


class all_average_time extends query_mode
{
    public function set_sql($index)
    {
        $this->fileds=["最大耗时","最短耗时","平均耗时"];
        $dn_num = $this->get_dn_num($index);
        $end = $this->get_end();
        $begin = $this->get_begin();
        $table_name = "history_log_".$this->get_table_no();
        // TODO: Implement setsql() method.
        $this->sql = "/* !HINT({\"dn\":[\"dn$dn_num\"]})*/
SELECT
  max(E.all_flow_t),
  min(E.all_flow_t),
  avg(E.all_flow_t) AS average_time
FROM
  (SELECT
     D.input_file,
     D.output_bill_count,
     D.output_errcdr_count,
     D.prov,
     FROM_UNIXTIME(D.create_time)      create_time,
     FROM_UNIXTIME(D.input_time)       input_time,
     FROM_UNIXTIME(D.output_time)      output_time,
     FROM_UNIXTIME(C.dis_min_time)     dis_min_time,
     FROM_UNIXTIME(C.dis_max_time)     dis_max_time,
     (C.dis_max_time - D.create_time)  all_flow_t,
     (C.dis_max_time - C.dis_min_time) dispat_t,
     (D.output_time - D.create_time)   distri_t,
     (D.input_time - D.create_time)    find_t
   FROM
     (SELECT
        MAX(Handleendtime)  dis_max_time,
        MIN(Handlestattime) dis_min_time,
        input_file
      FROM $table_name
      WHERE module_id = 2
            AND log_time >= UNIX_TIMESTAMP('$begin')
            AND log_time < UNIX_TIMESTAMP('$end')
      GROUP BY input_file) C INNER JOIN
     (SELECT
        A.input_file     input_file,
        A.create_time    create_time,
        B.Handlestattime input_time,
        B.Handleendtime  output_time,
        B.output_bill_count,
        B.output_errcdr_count,
        B.prov
      FROM
        (SELECT
           input_file,
           create_time,
           Handlestattime
         FROM $table_name
         WHERE log_type = 1
               AND module_id = 1
               AND log_time >= UNIX_TIMESTAMP('$begin')
               AND log_time < UNIX_TIMESTAMP('$end')) A INNER JOIN
        (SELECT
           input_file,
           Handlestattime,
           Handleendtime,
           output_bill_count,
           output_errcdr_count,
           SUBSTRING(input_file, 16, 3) prov
         FROM $table_name
         WHERE log_type = 3
               AND module_id = 1
               AND log_time >= UNIX_TIMESTAMP('$begin')
               AND log_time < UNIX_TIMESTAMP('$end')) B ON
                                                                         A.input_file = B.input_file) D
       ON C.input_file = D.input_file) E;
";
        // TODO: Implement setsql() method.
    }

    /**
     * @param $row
     */
    protected function to_array($row)
    {
        $this->data['all'] = ['time' => $row["average_time"]];
    }

}