<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/2
 * Time: 11:16 PM
 */


//$time = date('Y-m-d');
//echo $time;
//$before = '2018-12-01';
//echo (strtotime($time)-strtotime($before))/3600/24 + 56;
//
//echo date('"Y-m-d 00:00:00');
//
//$d=strtotime("yesterday");
//echo date("Y-m-d h:i:sa", $d);

//
//$a = ['a'=>["ab"=>1, "ac"=>2], 'b'=>['bb'=>1, 'bc' => 2]];
//$b = ['a'=>["1b"=>1, "1c"=>2], 'b'=>['2b'=>1, '2c' => 2]];

$a = ['1'=>["ab"=>1, "ac"=>2], '2'=>['bb'=>1, 'bc' => 2]];
$b = ['1'=>["1b"=>1, "1c"=>2], '2'=>['2b'=>1, '2c' => 2]];

$d = $a + $b;
$c = array_merge_recursive($a, $b);

$d = $c;

$str = "a";
$str .= "b";
echo $str;
//$c = intval("010");
//var_dump($c);

throw new Exception("a");
function inverse($x) {
    if (!$x) {
        throw new Exception('Division by zero.');
    }
    return 1/$x;
}

try {
    echo inverse(5) . "\n";
    echo inverse(0) . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}

// Continue execution
echo "Hello World\n";

