<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2019-01-27
 * Time: 16:45
 */


define('BASE_ROOT_PATH',str_replace('\\','/',dirname(__FILE__)));

/**
 * 安装判断
 */
if (!is_file(BASE_ROOT_PATH."/install/lock") && is_file(BASE_ROOT_PATH."/install/index.php")){
    if (ProjectName != 'shop'){
        @header("location: ../install/index.php");
    }else{
        @header("location: install/index.php");
    }
    exit;
}

define('BASE_CORE_PATH',BASE_ROOT_PATH.'/core');
define('BASE_DATA_PATH',BASE_ROOT_PATH.'/data');