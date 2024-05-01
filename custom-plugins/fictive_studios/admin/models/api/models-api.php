<?php
namespace FictiveCodes;

class ModelsAPIAdmin
{
    public function get_models_data()
    {
        global $wpdb;
        $sql_query = "SELECT * FROM " . $wpdb->prefix . "models";
        $results = $wpdb->get_results($sql_query);
        echo json_encode($results);
        wp_die();
    }

    public function get_model_data_by_id()
    {
        global $wpdb;
        $models_table = $wpdb->prefix . 'models';
        $coordinates_table = $wpdb->prefix . 'print_area_model_coordinates';
        $print_areas_table = $wpdb->prefix . 'print_areas';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id <= 0) {
            wp_redirect(admin_url('admin.php?page=models_builder&error=invalid_id'));
            exit;
        }

        $query = $wpdb->prepare(
            "SELECT m.*, c.ID AS print_area_model_coordinate_id, c.x_coordinate, c.y_coordinate, c.camera_x_coordinates,c.camera_y_coordinates, pa.ID AS print_area_id, pa.height, pa.width
                FROM $models_table m 
                LEFT JOIN $coordinates_table c ON m.ID = c.models_id
                LEFT JOIN $print_areas_table pa ON c.print_area_id = pa.ID
                WHERE m.ID = %d",
            $id
        );

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
        echo json_encode($models_list);
        wp_die();
    }
}