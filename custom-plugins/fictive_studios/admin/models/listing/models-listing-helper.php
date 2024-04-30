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
        $models_table = $wpdb->prefix . 'models';
        $coordinates_table = $wpdb->prefix . 'print_area_model_coordinates';
        $query = "SELECT m.*, c.ID AS coordinate_id, c.x_coordinate, c.y_coordinate, c.camera_coordinates
                  FROM $models_table m
                  LEFT JOIN $coordinates_table c ON m.ID = c.models_id";
        $results = $wpdb->get_results($query, ARRAY_A);
        $models_with_coordinates = array();
        foreach ($results as $row) {
            $model_id = $row['ID'];
            if (!isset($models_with_coordinates[$model_id])) {
                $models_with_coordinates[$model_id] = array(
                    'ID' => $row['ID'],
                    'name' => $row['name'],
                    'user' => $row['user'],
                    'coordinates' => array(),
                );
            }
            if (!empty($row['coordinate_id'])) {
                $models_with_coordinates[$model_id]['coordinates'][] = array(
                    'ID' => $row['coordinate_id'],
                    'x_coordinate' => $row['x_coordinate'],
                    'y_coordinate' => $row['y_coordinate'],
                    'camera_coordinates' => $row['camera_coordinates'],
                );
            }
        }
        $models_list = array_values($models_with_coordinates);
        return $models_list;
    }


}