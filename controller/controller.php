<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/7
 * Time: 11:18 AM
 */

namespace data;


class controller
{
    protected $_view;
    protected $_mode;

    public function __construct($bussiness_statics_mode, $bussiness_statics_view)
    {
        $this->_mode = $bussiness_statics_mode;
        $this->_view = $bussiness_statics_view;
    }

    public function set_begin_end($begin = '00:00:00', $end = '01:00:00', $date = null)
    {
        \data\query_mode::begin_end($begin, $end, $date);
    }

    public function set_file($file)
    {
        $this->_view->set_file($file);
    }

    public function updateView()
    {
        $this->_view->print_data($this->_mode->get_data());
    }
}