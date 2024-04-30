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
        $print_areas_table = $wpdb->prefix . 'print_areas';

        $query = "SELECT m.*, c.ID AS print_area_model_coordinate_id, c.x_coordinate, c.y_coordinate, c.camera_x_coordinates,c.camera_y_coordinates, pa.ID AS print_area_id, pa.height, pa.width
                FROM $models_table m
                LEFT JOIN $coordinates_table c ON m.ID = c.models_id
                LEFT JOIN $print_areas_table pa ON c.print_area_id = pa.ID";

        $results = $wpdb->get_results($query, ARRAY_A);

        $models_with_coordinates = array();
        foreach ($results as $row) {
            $model_id = $row['ID'];
            if (!isset($models_with_coordinates[$model_id])) {
                $models_with_coordinates[$model_id] = array(
                    'ID' => $row['ID'],
                    'name' => $row['name'],
                    'user' => $row['user'],
                    'print_areas' => array(),
                );
            }
            if (!empty($row['print_area_model_coordinate_id'])) {
                $models_with_coordinates[$model_id]['print_areas'][] = array(
                    'ID' => $row['print_area_model_coordinate_id'],
                    'print_area_height' => $row['height'],
                    'print_area_width' => $row['width'],
                    'x_coordinate' => $row['x_coordinate'],
                    'y_coordinate' => $row['y_coordinate'],
                    'camera_x_coordinates' => $row['camera_x_coordinates'],
                    'camera_y_coordinates' => $row['camera_y_coordinates'],
                );
            }
        }
        $models_list = array_values($models_with_coordinates);
        do_action('qm/debug', $models_list);
        return $models_list;
    }


}