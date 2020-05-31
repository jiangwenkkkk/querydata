<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2019-01-14
 * Time: 15:43
 */

namespace data;


class top_three_wrong_controller extends controller
{
    public function updateView()
    {
        $this->_view->printTopThree($this->_mode->get_data());
    }
}