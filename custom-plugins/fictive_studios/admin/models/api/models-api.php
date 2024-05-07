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

        $models_query = $wpdb->prepare(
            "SELECT * FROM $models_table WHERE id = %d",
            $id
        );
        $model = $wpdb->get_row($models_query, OBJECT);

        $print_area_coordinate_query = $wpdb->prepare(
            "SELECT cot.*, pat.*
             FROM $coordinates_table cot
             LEFT JOIN $print_areas_table pat ON cot.print_area_id = pat.ID
             WHERE cot.models_id = %d",
            $model->ID
        );
        $print_area_coordinates = $wpdb->get_results($print_area_coordinate_query, ARRAY_A);

        $model->print_areas = $print_area_coordinates;

        echo json_encode($model);
        wp_die();
    }

    public function save_model_data()
    {
        $model_name = isset($_POST['model_name']) ? sanitize_text_field($_POST['model_name']) : '';
        global $wpdb;
        $model_table = $wpdb->prefix . 'models';
        $wpdb->insert(
            $model_table,
            array(
                'name' => $model_name,
                'model_url' => 'model-url',
                'user' => get_current_user_id()
            )
        );

        $redirect_page_params = array(
            'page' => 'models_builder',
        );
        $url = add_query_arg($redirect_page_params, admin_url('admin.php'));
        wp_redirect($url);
        exit;
    }
}