
<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/2
 * Time: 5:52 PM
 */


$servername = "10.142.234.129";
$username = "roam";
$password = "roam@123";
$dbname = "ROAM_DATA";
$port = 9018;

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname, $port);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "/* !HINT({\"dn\":[\"dn56\"]})*/
select substr(t.input_file,16,3) as id, count(t.log_id) as file_num, sum(IFNULL(t.output_bill_count,0)) as right_bill_num from  history_log_12 t 
where  t.module_id =1
and t.log_type =3
and t.log_time >=UNIX_TIMESTAMP('2018-12-01 00:00:00')
and t.log_time <UNIX_TIMESTAMP('2018-12-02 00:00:00')
group by substr(t.input_file,16,3)
order by substr(t.input_file,16,3)";
echo $sql;

$result = $conn->query($sql);

$myfile = fopen("testfile.txt", "w");
if ($result->num_rows > 0) {
    // output data of each row
    while($row = $result->fetch_assoc()) {

        $txt =  "文件数: " . $row["file_num"]. "\t right_bill_num \t" . $row["right_bill_num"]. "\t prince_id \t " . $row["id"] ."\n";
//

        fwrite($myfile,$txt);
    }
} else {
    echo "0 results";
}


$conn->close();
fclose($myfile);
echo "Connected successfully";

