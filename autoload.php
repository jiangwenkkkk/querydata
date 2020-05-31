<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/5
 * Time: 2:38 PM
 */

namespace data;
require_once ("global.php");

function mya_autoload($class_name)
{
    $class_name = explode('\\', $class_name);
    //class directories
    $directorys = array(
        'controller/',
        'db/',
        'mode/',
        'view/',
        'test',
        '../mode/',
        '../view/',
        '../db/',
        '../controller/',
        '../lib/',
        'lib/'
    );

    //for each directory
    foreach($directorys as $directory)
    {
        //see if the file exsists

        if(file_exists($directory.end($class_name) . '.php'))
        {
            require_once($directory.end($class_name) . '.php');
            //only require the class once, so quit after to save effort (if you got more, then name them something else
            return;
        }
    }
}

spl_autoload_register(__NAMESPACE__ . '\mya_autoload');
