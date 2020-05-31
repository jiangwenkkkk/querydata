<?php
/**
 * Created by PhpStorm.
 * User: james
 * Date: 2019-05-15
 * Time: 12:25
 */

$a = "b_acct_item_group        
b_asn_attr_def            
b_attribute_format_step   
b_dup_ticket_type         
b_info_product            
b_info_product_offer      
b_mid_offer_pub           
b_offer_query_free_accu   
b_pn_seg_billing          
b_sector_tariff           
b_trans_peer_param        
cfg_function_list         
dest_event_type           
e_apporition_config       
e_partition_due           
event_attr                
formula_list              
offer                     
pricing_plan              
pricing_unit_convert
product
product_catalog_item
b_param_define
wf_application";
$a = "
event_pricing_strategy
";

$table = str_replace(' ', '', $a);
$tables = explode("\n",$table);


$path = "/Users/james/Documents/turn_sell/tmp/sr/";
$bad_log = fopen("/Users/james/Documents/turn_sell/tmp/sr/bad_log.log", "w");

/**
 * @param $file
 * @param $filename
 * @param $bad_log
 */
function print_err_line($file, $filename, $bad_log)
{
    $accout_cer = 0;
    $line_before = 0;
    $line_pos = 0;
    $line = "";
    while (!feof($file)) {
        $line_pos++;
        $line_before = $accout_cer;
        $accout_cer = 0;
        $line = fgets($file);
        $lines = str_split($line);
        $accout_cer = get_nums_cer($lines);
        if ($line_before != $accout_cer) {
//            $txt = $filename . ":" . $line_pos . ": " . $line;
            $txt =$line_pos."\n";
            fwrite($bad_log, $txt);
        }
    }
    fwrite($bad_log, "\n\n\n\n\n");
}


/**
 * @param $lines
 * @return mixed
 */
function get_nums_cer($lines)
{
    $accout_cer = 0;
    foreach ($lines as $item) {
        if ($item == "|")
            $accout_cer++;
    }
    return $accout_cer;
}

foreach ($tables as $table)
{
    $filename = $path.$table.".csv";

    $cer = "|";
    $file = fopen($filename, "r");
    if ($file == null) {
        continue;
    }

//    $tmp_file = $filename."dest";
//    $dest_file = fopen($tmp_file, "w");
//
//    $arr_line = [];
//
//    while (!feof($file)) {
//        $line = fgets($file);
//        $arr_line[] = $line;
//    }
//
//    $accout_cer = 0;
//    $line_before = get_nums_cer($arr_line[0]);
//    $line_pos = 0;
//    $right_line = $line_before;
//    $add_num = 0;
//    foreach ($arr_line as $key => $value) {
//        $new_line = "";
//        if ($key != 0)
//        {
//            $line_before = $accout_cer;
//        }
//
//        $accout_cer = 0;
//        $line = fgets($file);
//        $lines = str_split($line);
//        $accout_cer = get_nums_cer($lines);
//
//
//
//        if ($line_before != $accout_cer) {
//            $add_num += $accout_cer;
//            $tmp_line = str_replace("\n", "", $value);
//            $new_line .= $tmp_line;
//        }
//
//        if (preg_match("^[0-9].*\|", $value))
//        {
//            $tmp_line .= "\n";
//            fwrite($tmp_file, $tmp_line);
//        }
//
//        if ($add_num <= $right_line + 1 && $add_num >= $right_line-1)
//        {
//            $tmp_line .= "\n";
//            fwrite($tmp_file, $tmp_line);
//        }
//
//
//    }

//    $accout_cer = 0;
//    $line_before = 0;
//    $line_pos = 0;
//    $line = "";
//    while (!feof($file)) {
//        $line_pos++;
//        $line_before = $accout_cer;
//        $accout_cer = 0;
//        $line = fgets($file);
//        $lines = str_split($line);
//        foreach ($lines as $item) {
//            if ($item == "|")
//                $accout_cer++;
//        }
//    }


//    get_tmp_file($tmp_file, $dest_file);

    if ($file == null)
        continue;



    print_err_line($file, $filename, $bad_log);

    fclose($file);
}

fclose($bad_log);

