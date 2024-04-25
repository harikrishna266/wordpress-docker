<?php
namespace FictiveCodes;

class PrintAreaCreate
{
    public function get_create_print_area_template()
    {
        $action = ($_GET['action']);    
        $print_area_id;
        $print_area_data;
        if ($action == 'edit') {
            $print_area_id = ($_GET['print-area']);
            global $wpdb;
            $table_name = $wpdb->prefix . 'print_areas';
            $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $print_area_id);
            $print_area_data = $wpdb->get_row($query);
        }
        require_once (plugin_dir_path(__FILE__) . '../create/print-area-create-view.php');
    }
}