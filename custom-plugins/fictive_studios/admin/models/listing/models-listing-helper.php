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

    public function column_print_areas($item)
    {
        $view_page = esc_url(add_query_arg(array('model' => $item['ID']), admin_url('admin.php?page=view-print-areas')));
        $actions = '<a href="' . $view_page . '"class="dashicons dashicons-visibility"></a>';
        return $actions;
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
        $this->items = $this->get_models_data();
    }

    private function get_models_data()
    {
        global $wpdb;
        $models_table = $wpdb->prefix . 'models';
        $query = "SELECT * from $models_table";
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }


}