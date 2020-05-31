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
b_asn_attr_def
assign_statement
b_asn1_tag_seq
b_asn_attr_def
b_asn_file_type_inst_set
b_attribute_format
b_attribute_format_rule
b_attribute_format_step
b_dup_ticket_type
b_gather_task
b_head_region
b_host_info
b_info_product
b_info_product_offer
b_lte_mapping
b_map_parser_group
b_mid_offer_pub
b_object_define
b_object_type
b_offer_query_free_accu
b_pn_seg_billing
b_prod_inst_state_convert
b_sector_tariff
b_sep_field
b_sepblockinfo
b_sepfile
b_switch_type
b_tap3blockinfo
b_tap3file
b_template_map_switch
b_trans_peer_param
b_value_map
bill_condition
bill_operation
cfg_function_list
check_argument
check_relation
check_rule
check_subrule
common_region
dest_event_type
e_apporition_config
e_partition_due
event_attr
formula_list
ismp_bill_mode
ismp_prod_info
logic_statement
offer
offer_accumulator_relation
pricing_plan
product
product_catalog_item
trans_file_type
wf_process
b_file_name_rule
b_switch_info
check_function
b_ipc_cfg
b_ipc_used_stat
b_param_define
b_attribute_format_cmb
b_inst_table_list_cfg
wf_module
check_combine
b_checkfile_accu
b_checkfile_accu_desc
b_event_file_list
wf_application
system_roles
system_user
system_user_role
priv_grant
func_menu
func_comp
priv_func_rel
privilege
staff_old
staff
b_writefile_breakpoint
b_filedb_config
operate_log
c_sys_opt_log
";

$a = "
b_asn_file_type_inst_set
b_attribute_format
b_attribute_format_cmb
b_attribute_format_rule
b_attribute_format_step
b_filedb_config
b_gather_task
b_head_region
b_host_info
b_info_product_offer
b_inst_table_list_cfg
b_ipc_cfg
b_ipc_used_stat
b_lte_mapping
b_mid_offer_pub
b_offer_query_free_accu
b_param_define
b_prod_inst_state_convert
b_trans_peer_param
b_value_map
b_writefile_breakpoint
bill_condition
bill_operation
c_sys_opt_log
cfg_function_list
common_region
dest_event_type
event_attr
formula_list
func_comp
func_menu
ismp_bill_mode
ismp_prod_info
logic_statement
offer_accumulator_relation
operate_log
pricing_plan
priv_func_rel
priv_grant
privilege
staff
staff_old
system_roles
system_user
system_user_role
wf_process
";

$a = "
bill_condition
";

$cer_nums = 6;


$table = str_replace(' ', '', $a);
$tables = explode("\n",$table);


$path = "/Users/james/Documents/turn_sell/tmp/sr/";
$bad_log = fopen("/Users/james/Documents/turn_sell/tmp/sr/bad_log.log", "w");
$bad_file = fopen("/Users/james/Documents/turn_sell/tmp/sr/bad_file.csv", "w");

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
        $accout_cer = get_nums_cer($line);
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
function get_nums_cer($line)
{
    $lines = str_split($line);
    $accout_cer = 0;
    foreach ($lines as $item) {
        if ($item == "|")
            $accout_cer++;
    }
    return $accout_cer;
}


foreach ($tables as $table)
{
    $index = 0;


    $filename = $path.$table.".csv";

    $cer = "|";
    $file = fopen($filename, "r");
    if ($file == null) {
        continue;
    }


    $tmp_file = $path."/dest/".$table.".csv";
    $dest_file = fopen($tmp_file, "w");

    $arr_line = [];

    while (!feof($file)) {

        $line = fgets($file);
        $arr_line[] = $line;
    }


    $cer_num = 0;
//    $largest_num = get_nums_cer($arr_line[0]);
    $largest_num = $cer_nums;
    foreach ($arr_line as $key => $value) {
        $new_line = "";

        $index++;
        while ($index == 108) {
            $index++;

        }

        $tmp_line = str_replace("\n", "", $value);
        $tmp_line = str_replace("\r", "", $tmp_line);
        $new_line .= $tmp_line;


//        if (preg_match("/^[0-9].*\|/", $value)||preg_match("/^\|\|\|/", $value))
        $value = preg_replace("/\|\|/", "huohuo", $value);
        if (preg_match("/^[0-9].*\|/", $value))
        {
            $cer_num = get_nums_cer($new_line);

            if ($cer_num > $largest_num) {
                fwrite($bad_file, $new_line."\n");
          //      continue;
              //  echo "wrong" . $value;
            }
            else{
                for ($i = 0; $i < $largest_num - $cer_num; $i++) {
                    $new_line .= "|";
                }
            }
            $new_line .= "\n";
            fwrite($dest_file, $new_line);
        }

    }

//    print_err_line($dest_file, $filename, $bad_log);
    fclose($file);
    fclose($dest_file);
}

fclose($bad_log);

