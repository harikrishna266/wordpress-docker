<?php
namespace FictiveCodes;

require_once (ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class ModelsListingHelper extends \WP_List_Table
{

    public function __construct()
    {
        parent::__construct(
            array(
                'singular' => 'model',
                'plural' => 'models',
                'ajax' => false
            )
        );
    }

    public function get_columns()
    {
        return array(
            'cb' => '<input type="checkbox"/>',
            'name' => __('Name', 'name'),
            'print_areas' => __('Print Areas', 'print_areas'),
        );
    }

    public function get_sortable_columns()
    {
        return array(
            'name' => array('name', false),
        );
    }

    protected function column_default($item, $column_name)
    {
        return isset($item[$column_name]) ? $item[$column_name] : '';
    }


    public function prepare_items()
    {
        $columns = $this->get_columns();
        $sortable = $this->get_sortable_columns();
        $hidden = array();
        $primary = 'name';
        $this->_column_headers = array($columns, $hidden, $sortable, $primary);
        $this->items = $this->get_models_data('');
    }

    private function get_models_data($search_term = '')
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'models';
        $print_area_table = $wpdb->prefix . 'print_areas';
        $query = "SELECT pa.*, fd.* 
        FROM $print_area_table AS pa
        LEFT JOIN $table_name AS fd 
        ON pa.ID = fd.print_area_id";
        if ($search_term) {
            $search_term_like = '%' . $wpdb->esc_like($search_term) . '%';
            $query = $wpdb->prepare("SELECT * FROM $table_name WHERE name LIKE %s", $search_term_like);
        }
        $results = $wpdb->get_results($query, ARRAY_A);
        do_action('qm/debug', $results);
        return $results;
    }


}