<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2019-06-06
 * Time: 10:07
 */


//$mysqli = new mysqli("10.130.236.65", "mvno_comm", "Comm%123", "mvno_comm2", "8100");
$mysqli = new mysqli("10.19.11.15", "mvno_comm", "Comm%123", "mvno_comm2", "8100");
if ($mysqli->connect_error) {
    die("连接失败" . $mysqli->connect_error);
}

$myfile = fopen("result_query.txt", "w");
//$file = fopen("tmp.txt", "r");
$file = file_get_contents("sql.txt");

$line = 0;

if ($mysqli->multi_query($file))
{
    do{
        if ($result = $mysqli->store_result()) {
            while ($row = $result->fetch_row()) {
                printf("%s\n", $row[0]);
            }
            $result->free();
        }
        if ($mysqli->more_results())
            printf("-------------------\n");
    }while($mysqli->more_results());
}
//while (!feof($file)) {
//    $sql = fgets($file);
//    echo $sql;
//    echo $line--;
//    $result = $mysqli->query($sql);
//
//    if ($result->num_rows > 0) {
//        // output data of each row
//        $n = 0;
//        while ($row = $result->fetch_assoc()) {
//
//            $text = "";
////            if ($n == 0)
////            {
////                foreach ($row as $key => $value) {
////                    $text .= $key . "\t";
////                }
////                $text .= "\n";
////                $n = 1;
////            }
//
//            foreach ($row as $key => $value) {
//
//                $text .= $value . "\t";
//            }
//            $text .= "\n";
//
//            fwrite($myfile, $text);
//        }
//    } else {
//        echo "0 results";
//    }
//}


$mysqli->close();
fclose($myfile);

