<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2019-01-15
 * Time: 14:40
 */
$test=2;

if ($test>1)
{
    error_log("这是个匿名的邮件",
        1,"wupu@asiainfo.com","");
}