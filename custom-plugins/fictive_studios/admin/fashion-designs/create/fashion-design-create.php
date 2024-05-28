<?php

namespace FictiveCodes;

class FashionDesignCreate
{
    public function get_create_fashion_design_template()
    {
        $action = ($_GET['action']);
        $model_data = $this->get_models_data();
        $design_data = null;
        if ($action == 'edit') {
            $design_data = $this->get_design_data_for_edit();
        }
        require_once (plugin_dir_path(__FILE__) . 'fashion-design-create-view.php');
    }

    public function get_design_data_for_edit()
    {
        $design_id = ($_GET['design']);
        global $wpdb;
        $table_name = $wpdb->prefix . 'fashion_designs';
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE ID = %d", $design_id);
        return $wpdb->get_row($query);
    }


    public function get_models_data()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'models';
        $query = "SELECT * FROM $table_name";
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }
}