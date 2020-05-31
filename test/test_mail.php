<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2019-01-15
 * Time: 15:22
 */

//$txt = "First line of textnSecond line of text";
//
//// Use wordwrap() if lines are longer than 70 characters
//$txt = wordwrap($txt,70);
//
//// Send email
//mail("2580791235@qq.com","My subject",$txt);
//

$to = "haining_presence@qq.com";
$subject = "My subject";
$txt = "Hello world!";
$headers = "From: jiang.com" . "rn" .
    "CC: somebodyelse@example.com";

mail($to,$subject,$txt,$headers);

SELECT
  T.err_code,
  COUNT(1) AS cnt,
  GROUP_CONCAT(DISTINCT a.PROV_NAME SEPARATOR "/") as pro
FROM rejecterror_bill_history_1 t, tp_province a
WHERE SUBSTR(t.file_name, 17, 3) = a.prov_id
AND t.item_type = 'LNIG'
AND T.file_name LIKE '%20190117%'
AND t.log_time >= UNIX_TIMESTAMP('2019-01-17 00:00:00')
AND t.log_time < UNIX_TIMESTAMP('2019-01-17 19:00:00')
GROUP BY T.err_code
ORDER BY cnt DESC