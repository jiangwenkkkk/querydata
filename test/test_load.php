<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/5
 * Time: 2:46 PM
 */


require_once('spl_autoload.php');


$name = new FF\hello_you();
$name->say_hello();

function inverse($x) {
    if (!$x) {
        throw new \Exception('Division by zero.');
    }
    return 1/$x;
}

try {
    echo inverse(5) . "\n";
    echo inverse(0) . "\n";
} catch (Exception $e) {
    echo 'Caught exception: ',  $e->getMessage(), "\n";
}
