<?php

namespace FictiveCodes;

class FashionDesignAPIAdmin
{

    public function get_all_designs()
    {
        global $wpdb;
        $query = "SELECT * FROM " . $wpdb->prefix . "fashion_designs";
        $results = $wpdb->get_results($query);
        echo json_encode($results);
        wp_die();
    }

    public function get_design_by_id()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'fashion_designs';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id <= 0) {
            wp_redirect(admin_url('admin.php?page=fashion_designs_builder&error=invalid_id'));
            exit;
        }

        $query = "SELECT * from $table_name WHERE `ID` = $id";
        $design = $wpdb->get_row($query, OBJECT);

        echo json_encode($design);
        wp_die();
    }

    public function save_design()
    {
        $design_name = isset($_POST['fashion_design_name']) ? sanitize_text_field($_POST['fashion_design_name']) : '';
        $model_id = isset($_POST['fashion_design_model']) ? sanitize_text_field($_POST['fashion_design_model']) : '';
        global $wpdb;
        $model_table = $wpdb->prefix . 'fashion_designs';

        $insert_data = array(
            'name' => $design_name,
            'model_id' => $model_id,
            'user' => get_current_user_id()
        );

        for ($i = 1; $i <= 5; $i++) {
                $insert_data['design_layer_' . $i] = isset($_POST['fashion_design_layer_' . $i]) ? sanitize_text_field($_POST['fashion_design_layer_' . $i]) : '';
        }

        $wpdb->insert($model_table, $insert_data);

        $redirect_page_params = array(
            'page' => FASHION_DESIGNS_BUILDER_SLUG,
        );
        $url = add_query_arg($redirect_page_params, admin_url('admin.php'));
        wp_redirect($url);
    }

}