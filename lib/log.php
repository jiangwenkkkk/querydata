<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2019-01-27
 * Time: 16:23
 */

namespace data;

class Log
{
    const open_sql = true;
    const SQL = 1;
    const INFO = 2;
    const DEBUG = 3;
    const WARING = 4;
    const ERR = 5;
    const RUN = 6;
    const WAIT_HANDLE = 10;

    static $moduls = array("default","session");

    const cur_level = self::DEBUG;

    private static $log = array();
    private static $stsql_log = array();
    public static function start_sql_log()
    {
        self::$stsql_log = array();
    }
    public static function sql_log()
    {
        return self::$stsql_log;
    }

    private static function add_sql_log($log)
    {
        if(is_array(self::$stsql_log)) {
            array_push(self::$stsql_log,$log);
        }
    }

    public static function record($message, $lev = self::ERR)
    {
        $now = @date('Y-m-d H:i:s', time());
        $pid = posix_getpid();

        if($lev == self::WAIT_HANDLE) {
            $level = 'WAIT_HANDLE';
            $log_file = BASE_DATA_PATH.'/log/'.date('Ymd',time()).'-wait.log';

            $content = "[{$pid} {$now}] {$level}: {$message}\r\n";
            file_put_contents($log_file,$content, FILE_APPEND);
            return;
        }

        if($lev == self::SQL) {
            $level = 'SQL';
            $content = "[{$pid} {$now}] {$level}: {$message}\r\n";
            if(self::open_sql) {
                $log_file = BASE_DATA_PATH.'/log/'.date('Ymd',time()).'.log';
                file_put_contents($log_file,$content, FILE_APPEND);
            }
            self::add_sql_log($message);
            return;
        }

        if($lev >= self::cur_level && $lev <= self::RUN) {
            $level = self::get_level($lev);
            $log_file = BASE_DATA_PATH . '/log/' . date('Ymd', time()) . '.log';
            $content = "[{$pid} {$now}] {$level}: {$message}\r\n";
            file_put_contents($log_file, $content, FILE_APPEND);
        }

        if($lev == self::ERR) {
            self::msg();
        }
    }

    public static function endl($lev = self::ERR)
    {
        $content = "\r\n";

        if($lev == self::SQL && self::open_sql) {
            $log_file = BASE_DATA_PATH.'/log/'.date('Ymd',time()).'.log';
            file_put_contents($log_file,$content, FILE_APPEND);
            return;
        }

        if($lev >= self::cur_level) {
            $log_file = BASE_DATA_PATH . '/log/' . date('Ymd', time()) . '.log';
            file_put_contents($log_file, $content, FILE_APPEND);
        }
    }

    public static function msg()
    {
        $debugInfo = debug_backtrace();
        $stack = "[";
        foreach($debugInfo as $key => $val){
            if(array_key_exists("file", $val)){
                $stack .= ",file:" . $val["file"];
            }
            if(array_key_exists("line", $val)){
                $stack .= ",line:" . $val["line"];
            }
            if(array_key_exists("function", $val)){
                $stack .= ",function:" . $val["function"];
            }
        }
        $stack .= "]";

        return $stack;
    }

    private static function get_level($lev)
    {
        if($lev == self::INFO) return 'INFO';
        if($lev == self::DEBUG) return 'DEBUG';
        if($lev == self::WARING) return 'WARING';
        if($lev == self::ERR) return 'ERR';
        if($lev == self::RUN) return 'RUN';
        return 'Unknown';
    }

    public static function read()
    {
        return self::$log;
    }
}