<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/2
 * Time: 10:47 PM
 */

namespace data;


class Cloum
{
    private $prin_id;
    private $upload;
    private $all = 0;
    private $wrong;
    private $reject;
    private $right;
    private $dispatch_file;
    private $dispatch_bill;
    private $own_wrong;

    public function get_all()
    {
        $this->all = $this->wrong + $this->right;
    }
}