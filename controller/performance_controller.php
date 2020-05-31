<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/4
 * Time: 8:03 AM
 */

namespace data;


class performance_controller extends controller
{
    public function update_view()
    {
        $this->_view->printBussinessDetails($this->_mode->get_data());
//        $this->performance_view->printBussinessDetails($this->performance_mode->get_data());
    }
}