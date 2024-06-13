<?php

namespace FictiveCodes;

class PrintTypesAPIAdmin
{
    public function get_print_types_data()
    {
        global $wpdb;
        $sql_query = "SELECT * FROM " . FICTIVE_TABLE . "print_types";
        $results = $wpdb->get_results($sql_query);
        echo json_encode($results);
        wp_die();
    }

    public function save_print_types_data()
    {
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $link = isset($_POST['link']) ? sanitize_text_field($_POST['link']) : '';

        global $wpdb;
        $table_name = FICTIVE_TABLE . 'print_types';
        $wpdb->insert(
            $table_name,
            array(
                'name' => $name,
                'link' => $link,
                'user' => get_current_user_id()
            ),
            array('%s', '%s', '%d')
        );
        $edit_params = array(
            'page' => PRINT_TYPES_BUILDER_SLUG,
        );
        $url = add_query_arg($edit_params, admin_url('admin.php'));
        wp_redirect($url);
        exit;
    }


    public function edit_print_types_data()
    {
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';
        $link = isset($_POST['link']) ? sanitize_text_field($_POST['link']) : '';

        global $wpdb;
        $table_name = FICTIVE_TABLE . 'print_types';

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        if ($id <= 0) {
            wp_redirect(admin_url('admin.php?page=' . PRINT_TYPES_BUILDER_SLUG . '&error=invalid_id'));
            exit;
        }

        $wpdb->update(
            $table_name,
            array(
                'name' => $name,
                'link' => $link,
                'user' => get_current_user_id()
            ),
            array('id' => $id),
            array('%s', '%s', '%d'),
            array('%d')
        );

        $redirect_params = array(
            'page' => PRINT_TYPES_BUILDER_SLUG,
        );

        $url = add_query_arg($redirect_params, admin_url('admin.php'));
        wp_redirect($url);
        exit;
    }


}