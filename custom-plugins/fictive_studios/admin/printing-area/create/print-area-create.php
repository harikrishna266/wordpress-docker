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
            $table_name = FICTIVE_TABLE . 'print_areas';
            $query = $wpdb->prepare("SELECT * FROM $table_name WHERE id = %d", $print_area_id);
            $print_area_data = $wpdb->get_row($query);
        }
        $heightValue = isset($print_area_data) && isset($print_area_data->height) ? $print_area_data->height : null;
        $widthValue = isset($print_area_data) && isset($print_area_data->width) ? $print_area_data->width : null;
        require_once (plugin_dir_path(__FILE__) . '../create/print-area-create-view.php');
    }
}