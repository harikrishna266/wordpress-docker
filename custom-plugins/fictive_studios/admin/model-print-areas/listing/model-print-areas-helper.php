<?php
namespace FictiveCodes;

require_once (ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class ModelPrintAreasListingHelper extends \WP_List_Table
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
            'x_coordinate' => __('x coordinate', 'x_coordinate'),
            'y_coordinate' => __('y coordinate', 'y_coordinate'),
            'camera_x_coordinates' => __('Camera x coordinate', 'camera_x_coordinate'),
            'camera_y_coordinates' => __('Camera y coordinate', 'camera_y_coordinate'),
        );
    }


    protected function column_default($item, $column_name)
    {
        return isset($item[$column_name]) ? $item[$column_name] : '';
    }


    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $primary = 'name';
        $this->_column_headers = array($columns, $hidden, $primary);
        $this->items = $this->get_models_data();
    }

    private function get_models_data()
    {
        global $wpdb;
        $models_table = FICTIVE_TABLE . 'print_area_model_coordinates';
        $model_id = $_GET['model'];
        $query = "SELECT * from $models_table WHERE `models_id` = $model_id";
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }


}