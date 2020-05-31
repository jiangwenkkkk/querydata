<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2019-01-15
 * Time: 18:03
 */

require_once ("../autoload.php");

$sql = "/* !HINT({\"dn\":[\"dn35\"]})*/
select FROM_UNIXTIME(history_log_1.CREATE_TIME) as CREATE_TIME, history_log_1.input_file
from history_log_1
where substr(input_file, 16, 3) = 851
  AND history_log_1.module_id = 1
  AND history_log_1.log_type = 1
  AND history_log_1.log_time >= UNIX_TIMESTAMP('2019-01-15 17:00:00')
  AND history_log_1.log_time < UNIX_TIMESTAMP('2019-01-15 17:20:00')
limit 10;";
$conn = \Db_conn::getinstance();
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        echo $row['CREATE_TIME']."\t".$row['input_file']."\n";
    }
} else {
    echo get_class($this) . "0 result";
    //      throw new \Exception('Division by zero.');
}