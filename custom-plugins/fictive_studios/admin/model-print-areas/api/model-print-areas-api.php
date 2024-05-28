<?php
namespace FictiveCodes;

class ModelPrintAreasAPIAdmin
{
    public function save_model_print_area_data()
    {
        $model_print_area_name = isset($_POST['model_name']) ? sanitize_text_field($_POST['model_name']) : '';
        $model_id = isset($_POST['model_id']) ? sanitize_text_field($_POST['model_id']) : '';
        $print_area_id = isset($_POST['print_area_id']) ? sanitize_text_field($_POST['print_area_id']) : '';
        $x_coordinate = isset($_POST['x_coordinate']) ? sanitize_text_field($_POST['x_coordinate']) : '';
        $y_coordinate = isset($_POST['y_coordinate']) ? sanitize_text_field($_POST['y_coordinate']) : '';
        $camera_x_coordinate = isset($_POST['camera_x_coordinate']) ? sanitize_text_field($_POST['camera_x_coordinate']) : '';
        $camera_y_coordinate = isset($_POST['camera_y_coordinate']) ? sanitize_text_field($_POST['camera_y_coordinate']) : '';

        global $wpdb;
        $model_table = FICTIVE_TABLE . 'print_area_model_coordinates';
        $wpdb->insert(
            $model_table,
            array(
                'name' => $model_print_area_name,
                'models_id' => $model_id,
                'print_area_id' => $print_area_id,
                'x_coordinate' => $x_coordinate,
                'y_coordinate' => $y_coordinate,
                'camera_x_coordinates' => $camera_x_coordinate,
                'camera_y_coordinates' => $camera_y_coordinate,
                'user' => get_current_user_id()
            )
        );

        $redirect_page_params = array(
            'page' => 'model_print_areas',
            'model' => $model_id
        );
        $url = add_query_arg($redirect_page_params, admin_url('admin.php'));
        wp_redirect($url);
        exit;
    }
}