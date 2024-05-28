<?php
namespace FictiveCodes;

class ModelPrintAreasCreate
{
    public function get_model_print_area_create_template()
    {
        $action = ($_GET['action']);
        $print_areas = $this->get_print_area_data();
        require_once (plugin_dir_path(__FILE__) . 'model-print-areas-create-view.php');
    }

    public function get_print_area_data()
    {
        global $wpdb;
        $table_name = FICTIVE_TABLE . 'print_areas';
        $query = "SELECT * FROM $table_name";
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }
}