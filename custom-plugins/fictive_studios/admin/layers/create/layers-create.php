<?php

namespace FictiveCodes;

class DesignLayerCreate
{
    public function get_create_design_layer_template()
    {
        $action = ($_GET['action']);
        $layer_data = null;
        if ($action == 'edit') {
            $layer_data = $this->get_layer_data_for_edit();
        }
        require_once(plugin_dir_path(__FILE__) . 'layers-create-view.php');
    }

    public function get_layer_data_for_edit()
    {
        $design_id = ($_GET['layer']);
        global $wpdb;
        $table_name = FICTIVE_TABLE . 'design_layers';
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE ID = %d", $design_id);
        return $wpdb->get_row($query);
    }
}
