<?php

namespace FictiveCodes;

class FashionDesignCreate
{
    public function get_create_fashion_design_template()
    {
        $action = ($_GET['action']);
        $model_id;
        $model_data = $this->get_models_data();
        require_once (plugin_dir_path(__FILE__) . 'fashion-design-create-view.php');
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