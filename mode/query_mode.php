<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/2
 * Time: 11:08 PM
 */

namespace data;
abstract class query_mode
{
    protected $sql;
    protected $data = [];
    protected $fileds;
    static protected $begin_time;
    static protected $end_time;
    static protected $date;
    static protected $type = 1; // 1 自动日检, 2 设置起始时间


    static public function begin_end($begin = '00:00:00', $end = '01:00:00', $date = null)
    {
        if ($date == null) {
            query_mode::$date = date("Y-m-d");
        } else {
            query_mode::$date = $date;
        }
        query_mode::$type = 2;
        query_mode::$begin_time = query_mode::$date . ' ' . $begin;
        query_mode::$end_time = query_mode::$date . ' ' . $end;
    }

    abstract public function set_sql($index);


    public function set_data()
    {
        $lines = 0;
        // TODO: Implement set_data() method.
        global $index_len;
        global $mode;
        global $time;
        if ($mode == "performance")
        {
            $i=0;
            if ($time=="0-8")
                $i = 3;
            else if($time=="8-16")
                $i=2;
            else if($time=='16-24')
                $i=1;

            $this->set_sql($i);

            echo color::red(get_class($this)) . ": sql is :  \n" .color::lightBlue($this->sql)."\n";

            \data\Log::record(  get_class($this) . ": sql is :  \n" .$this->sql, \data\Log::DEBUG);

            $conn = \Db_conn::getinstance();
            $result = $conn->query($this->sql);
            if ($result->num_rows > 0) {
                if(isset($this->fileds))
                    echo color::magenta(implode("\t",$this->fileds))."\n";
                else
                    echo color::red("don't have fileds\n");
                while ($row = $result->fetch_assoc()) {

                    echo color::GREEN(implode("\t", $row)."\n");
                    \data\Log::record(implode(" ", $row), \data\Log::DEBUG);
                    $this->to_array($row);
                }
            } else {
                echo color::yellow(get_class($this) . ": #####0 result#####\n");
                //      throw new \Exception('Division by zero.');
            }

        } else{
            for($i = 3; $i>$index_len; --$i)
            {
                $this->set_sql($i);

                echo color::red(get_class($this)) . ": sql is :  \n" .color::lightBlue($this->sql)."\n";

                \data\Log::record(  get_class($this) . ": sql is :  \n" .$this->sql, \data\Log::DEBUG);

                $conn = \Db_conn::getinstance();
                $result = $conn->query($this->sql);
                if ($result->num_rows > 0) {
                    if(isset($this->fileds))
                        echo color::magenta(implode("\t",$this->fileds))."\n";
                    else
                        echo color::red("don't have fileds\n");
                    while ($row = $result->fetch_assoc()) {

                        echo color::GREEN(implode("\t", $row)."\n");
                        \data\Log::record(implode(" ", $row), \data\Log::DEBUG);
                        $this->to_array($row);
                    }
                } else {
                    echo color::yellow(get_class($this) . ": #####0 result#####\n");
                    //      throw new \Exception('Division by zero.');
                }
            }

        }

    }

    protected function get_begin()
    {
        if (query_mode::$type == 1) {
            $d = strtotime("yesterday");
            return date("Y-m-d 00:00:00", $d);
        } else {
            return query_mode::$begin_time;
        }
    }

    protected function get_end()
    {
        if (query_mode::$type == 1) {
            return date("Y-m-d 00:00:00");
        } else {
            return query_mode::$end_time;
        }

    }

    protected function get_dn_num($index)
    {
        if(query_mode::$date < '2019-03-01')
        {
            $start_num = 80;
            $before = '2019-03-01';
            if (query_mode::$type == 2) {
                $now_gone = $this->have_gone(query_mode::$date, $before) + $start_num + 1;
                return $now_gone;
            }

            $today = date('Y-m-d');
            return $this->have_gone($today, $before) + $start_num;
        }
        else{
            $date=date_create(query_mode::$date);
            $days= date_format($date,"d");
            $days = intval($days);
//            if (query_mode::$type == 2)
//            {
//                --$days;
//            }
            return (3*$days -$index)+21;
        }

    }

    protected function file_name()
    {
        if (query_mode::$type == 2) {
            $d = strtotime(query_mode::$date);

            return date("Ymd", $d);
        } else {
            $d = strtotime("yesterday");
            return date("Ymd", $d);
        }

    }

    public function get_table_no()
    {
        if (query_mode::$type == 2) {
            $d = strtotime(query_mode::$date);
        } else {
            $d = strtotime("yesterday");
        }
        return strval((intval(date("m", $d))));

    }

    protected function get_percent($arr)
    {
        $sum = array_sum($arr);
        foreach ($arr as $key => $value) {
            if ($sum!=0)
                $result[$key] = floatval($value) / $sum;
            else
                $result[$key] = 0;
        }
        return $result;

    }

    public function get_data()
    {
        return $this->data;
    }

    protected function get_id($id)
    {
        return "id" . strval(intval($id));
    }

    abstract protected function to_array($row);

    /**
     * @param $time
     * @param $before
     * @return float|int
     */
    protected function have_gone($time, $before)
    {
        return (strtotime($time) - strtotime($before)) / 3600 / 24;
    }
}

