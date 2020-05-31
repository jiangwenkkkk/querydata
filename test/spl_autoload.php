<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/5
 * Time: 2:44 PM
 */
namespace Fuck_time;
function my_autoloader($class) {
    $parts = explode('\\', $class);
    require_once  end($parts) . '.php';
}

spl_autoload_register(__NAMESPACE__ . '\my_autoloader');

// 或者，自 PHP 5.3.0 起可以使用一个匿名函数
//spl_autoload_register(function ($class) {
//    include  $class . 'php';
//});