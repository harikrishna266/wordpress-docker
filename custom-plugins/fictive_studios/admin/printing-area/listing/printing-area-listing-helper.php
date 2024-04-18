<?php
namespace FictiveCodes;

require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class PrintAreasListingHelper extends \WP_List_Table
{

    public function __construct()
    {
        parent::__construct(array(
            'singular' => 'print_area',
            'plural' => 'print_areas',
            'ajax' => false
        ));
    }

    public function get_columns()
    {
        return array(
            'cb' => '<input type="checkbox"/>',
            'height' => __('Height', 'height'),
            'width' => __('Width', 'width'),
        );
    }

    public function get_sortable_columns()
    {
        return array(
            'height' => array('height', false),
            'width' => array('width', false),
        );
    }

    protected function column_default( $item, $column_name ) {
        return isset( $item[ $column_name ] ) ? $item[ $column_name ] : '';
    }


    public function prepare_items()
    {
        $columns = $this->get_columns();
        $sortable = $this->get_sortable_columns();
        $hidden = array();
        $primary = 'height';
        $this->_column_headers = array($columns, $hidden, $sortable, $primary);
        $this->items = $this->get_print_areas_data();
    }

    private function get_print_areas_data()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'print_areas';
        $query = "SELECT * FROM $table_name";
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }


}