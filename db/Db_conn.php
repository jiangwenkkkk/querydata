<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2018/12/4
 * Time: 7:50 AM
 */

$servername = "10.142.234.129";
$username = "roam";
$password = "JTsmSQL@19";
$dbname = "ROAM_DATA";
$port = 9018;


class Db_conn
{
    private $_conn;
    private static $_instance;
    private function __construct()
    {
        $conn = new mysqli("10.142.234.129", "roam", "JTsmSQL@19", "ROAM_DATA", 9018);

// Check connection
        if ($conn->connect_error) {
            die("Connection failed: " . $conn->connect_error);
        }
        $this->_conn =  $conn;
    }

    static public function getinstance()
    {
        if (!(self::$_instance instanceof self)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    public function query($sql)
    {
        return $this->_conn->query($sql);
    }

    public function __destruct()
    {
        // TODO: Implement __destruct() method.
        $this->_conn->close();
    }
    private function __clone()
    {
        // TODO: Implement __clone() method.
    }
}
