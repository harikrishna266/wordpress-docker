<?php

namespace FictiveCodes;

class FashionDesignAPIAdmin
{

    public function get_all_designs()
    {
        global $wpdb;
        $query = "SELECT * FROM " . FICTIVE_TABLE . "fashion_designs";
        $designs = $wpdb->get_results($query, OBJECT);

        foreach ($designs as $design) {
            $layers_table = FICTIVE_TABLE . 'design_layers';
            $layers_query = $wpdb->prepare("SELECT * FROM $layers_table WHERE `design_id` = %d", $design->ID);
            $layers = $wpdb->get_results($layers_query, OBJECT);
            $design->layers = $layers;
        }
        
        echo json_encode($designs);
        wp_die();
        
    }

    public function get_design_by_id()
    {
        global $wpdb;
        $table_name = FICTIVE_TABLE . 'fashion_designs';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id <= 0) {
            wp_redirect(admin_url('admin.php?page=fashion_designs_builder&error=invalid_id'));
            exit;
        }

        $query = "SELECT * from $table_name WHERE `ID` = $id";
        $design = $wpdb->get_row($query, OBJECT);

        if ($design) {
            $layers_table = FICTIVE_TABLE . 'design_layers';
            $layers_query = $wpdb->prepare("SELECT * FROM $layers_table WHERE `design_id` = %d", $id);
            $layers = $wpdb->get_results($layers_query, OBJECT);
            $design->layers = $layers;
        }

        echo json_encode($design);
        wp_die();
    }

    public function save_design()
    {
        $design_name = isset($_POST['fashion_design_name']) ? sanitize_text_field($_POST['fashion_design_name']) : '';
        $model_id = isset($_POST['fashion_design_model']) ? sanitize_text_field($_POST['fashion_design_model']) : '';
        global $wpdb;
        $model_table = FICTIVE_TABLE . 'fashion_designs';

        $insert_data = array(
            'name' => $design_name,
            'model_id' => $model_id,
            'user' => get_current_user_id()
        );

        $wpdb->insert($model_table, $insert_data);

        $redirect_page_params = array(
            'page' => FASHION_DESIGNS_BUILDER_SLUG,
        );
        $url = add_query_arg($redirect_page_params, admin_url('admin.php'));
        wp_redirect($url);
        exit;
    }

    public function edit_design()
    {
        $design_name = isset($_POST['fashion_design_name']) ? sanitize_text_field($_POST['fashion_design_name']) : '';
        $model_id = isset($_POST['fashion_design_model']) ? intval($_POST['fashion_design_model']) : 0;

        global $wpdb;
        $table_name = FICTIVE_TABLE . 'fashion_designs';
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        if ($id <= 0) {
            wp_redirect(admin_url('admin.php?page=' . FASHION_DESIGNS_BUILDER_SLUG . '&error=invalid_id'));
            exit;
        }

        if (empty($design_name)) {
            wp_redirect(admin_url('admin.php?page=' . FASHION_DESIGNS_BUILDER_SLUG . '&error=missing_design_name'));
            exit;
        }

        $insert_data = array(
            'name' => $design_name,
            'model_id' => $model_id,
        );

        $wpdb->update(
            $table_name,
            $insert_data,
            array('id' => $id),
            array(
                '%s',
                '%d',
            ),
            array('%d')
        );

        $redirect_params = array(
            'page' => FASHION_DESIGNS_BUILDER_SLUG,
        );
        $url = add_query_arg($redirect_params, admin_url('admin.php'));
        wp_redirect($url);
        exit;
    }
}
