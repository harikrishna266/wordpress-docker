<?php
namespace FictiveCodes;

class PrintTypesCreate
{
    public function get_create_print_types_template()
    {
        $action = ($_GET['action']);
        $print_types_data = null;
        $print_type_id = ($_GET['print_type']);
        if ($action == 'edit') {
            $print_types_data = $this->get_print_types_data_for_edit($print_type_id);
        }
        require_once (plugin_dir_path(__FILE__) . '../create/print-types-create-view.php');
    }

    public function get_print_types_data_for_edit($print_type_id)
    {
        global $wpdb;
        $table_name = FICTIVE_TABLE . 'print_types';
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE ID = %d", $print_type_id);
        return $wpdb->get_row($query);
    }
}