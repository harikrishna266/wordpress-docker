<?php
namespace FictiveCodes;

class PatternsCreate
{
    public function get_create_patterns_template()
    {
        $action = ($_GET['action']);
        $pattern_data = null;
        if ($action == 'edit') {
            $pattern_data = $this->get_pattern_data_for_edit();
        }
        require_once (plugin_dir_path(__FILE__) . '../create/patterns-create-view.php');
    }

    public function get_pattern_data_for_edit()
    {
        $pattern_id = ($_GET['pattern']);
        global $wpdb;
        $table_name = FICTIVE_TABLE . 'patterns';
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE ID = %d", $pattern_id);
        return $wpdb->get_row($query);
    }
}