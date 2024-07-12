<?php

namespace FictiveCodes;

class TagsAPIAdmin
{
    public function get_tags_data()
    {
        global $wpdb;
        $sql_query = "SELECT * FROM " . FICTIVE_TABLE . "print_types";
        $results = $wpdb->get_results($sql_query);
        echo json_encode($results);
        wp_die();
    }

    public function save_tag_data()
    {
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';

        global $wpdb;
        $table_name = FICTIVE_TABLE . 'tags';
        $wpdb->insert(
            $table_name,
            array(
                'name' => $name,
                'user' => get_current_user_id()
            ),
            array('%s', '%d')
        );
        $edit_params = array(
            'page' => TAGS_SLUG,
        );
        $url = add_query_arg($edit_params, admin_url('admin.php'));
        wp_redirect($url);
        exit;
    }


    public function edit_tag_data()
    {
        $name = isset($_POST['name']) ? sanitize_text_field($_POST['name']) : '';

        global $wpdb;
        $table_name = FICTIVE_TABLE . 'tags';

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        if ($id <= 0) {
            wp_redirect(admin_url('admin.php?page=' . TAGS_SLUG . '&error=invalid_id'));
            exit;
        }

        $wpdb->update(
            $table_name,
            array(
                'name' => $name,
                'user' => get_current_user_id()
            ),
            array('id' => $id),
            array('%s', '%d'),
            array('%d')
        );

        $redirect_params = array(
            'page' => TAGS_SLUG,
        );

        $url = add_query_arg($redirect_params, admin_url('admin.php'));
        wp_redirect($url);
        exit;
    }


}