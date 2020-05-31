<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/7
 * Time: 11:15 AM
 */

namespace data;


class view
{
    protected $_file;
    protected $file_name;

    public function set_file($file)
    {
        $this->file_name = $file;
    }
    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        if ($this->_file != null)
            fclose($this->_file);
    }

    public function print_data($data){

    }
}