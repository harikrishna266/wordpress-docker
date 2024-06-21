<?php

namespace FictiveCodes;

class LayersAPIAdmin
{
    public function save_design_layers_data()
    {
        $design_id = isset($_POST['design_id']) ? sanitize_text_field($_POST['design_id']) : '';
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $file_url = isset($_POST['file_url']) ? sanitize_text_field($_POST['file_url']) : '';
        $color = isset($_POST['color']) ? sanitize_text_field($_POST['color']) : '';
        $allow_pattern = isset($_POST['allow_pattern']) ? true : false;
        global $wpdb;
        $layers_table = FICTIVE_TABLE . 'design_layers';
        $wpdb->insert(
            $layers_table,
            array(
                'name' => $name,
                'file_url' => $file_url,
                'color' => $color,
                'allow_pattern' => $allow_pattern,
                'design_id' => $design_id,
                'created_by' => get_current_user_id()
            )
        );

        $redirect_page_params = array(
            'page' => DESIGN_LAYERS_SLUG,
            'design' => $design_id
        );
        $url = add_query_arg($redirect_page_params, admin_url('admin.php'));
        wp_redirect($url);
        exit;
    }

    public function edit_design_layers_data()
    {
        $design_id = isset($_POST['layer_id']) ? sanitize_text_field($_POST['design_id']) : '';
        $layer_id = isset($_POST['layer_id']) ? sanitize_text_field($_POST['layer_id']) : '';
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $file_url = isset($_POST['file_url']) ? sanitize_text_field($_POST['file_url']) : '';
        $color = isset($_POST['color']) ? sanitize_text_field($_POST['color']) : '';
        $allow_pattern = isset($_POST['allow_pattern']) ? true : false;

        global $wpdb;
        $layers_table = FICTIVE_TABLE . 'design_layers';

        $insert_data =  array(
            'name' => $name,
            'file_url' => $file_url,
            'color' => $color,
            'allow_pattern' => $allow_pattern,
        );

        $wpdb->update(
            $layers_table,
            $insert_data,
            array('id' => $layer_id),
        );

        $redirect_page_params = array(
            'page' => DESIGN_LAYERS_SLUG,
            'design' => $design_id
        );
        $url = add_query_arg($redirect_page_params, admin_url('admin.php'));
        wp_redirect($url);
        exit;
    }
}
