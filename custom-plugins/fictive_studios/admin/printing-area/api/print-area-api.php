<?php
class PrintAreaAPIAdmin
{
    public function get_print_area_data()
    {
        global $wpdb;
        $sql_query = "SELECT * FROM " . $wpdb->prefix . "print_areas";
        $results = $wpdb->get_results($sql_query);
        echo json_encode($results);
        wp_die();
    }

}