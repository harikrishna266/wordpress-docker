<?php

namespace FictiveCodes;

class PatternsAPIAdmin
{

    public function get_all_patterns()
    {
        global $wpdb;
        $query = "SELECT * FROM " . FICTIVE_TABLE . "patterns";
        $results = $wpdb->get_results($query);
        echo json_encode($results);
        wp_die();
    }

    public function get_pattern_by_id()
    {
        global $wpdb;
        $table_name = FICTIVE_TABLE . 'patterns';
        $id = isset($_GET['id']) ? intval($_GET['id']) : 0;

        if ($id <= 0) {
            wp_redirect(admin_url('admin.php?page=' . PATTERNS_BUILDER_SLUG . '&error=invalid_id'));
            exit;
        }

        $query = "SELECT * from $table_name WHERE `ID` = $id";
        $design = $wpdb->get_row($query, OBJECT);

        echo json_encode($design);
        wp_die();
    }

    public function save_pattern_data()
    {
        $pattern_name = isset($_POST['pattern_name']) ? sanitize_text_field($_POST['pattern_name']) : '';
        $pattern_image_url = isset($_POST['pattern_image']) ? sanitize_text_field($_POST['pattern_image']) : '';
        $pattern_file_url = isset($_POST['pattern_file']) ? sanitize_text_field($_POST['pattern_file']) : '';

        global $wpdb;
        $patterns_table = FICTIVE_TABLE . 'patterns';

        $insert_data = array(
            'name' => $pattern_name,
            'user' => get_current_user_id(),
            'pattern_url' => $pattern_file_url,
            'pattern_image' => $pattern_image_url
        );

        $wpdb->insert($patterns_table, $insert_data, array('%s', '%d', '%s', '%s'));

        $redirect_page_params = array(
            'page' => PATTERNS_BUILDER_SLUG,
        );
        $url = add_query_arg($redirect_page_params, admin_url('admin.php'));
        wp_redirect($url);
    }

    public function edit_pattern_data()
    {
        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;
        $pattern_name = isset($_POST['pattern_name']) ? sanitize_text_field($_POST['pattern_name']) : '';
        $pattern_image_url = isset($_POST['pattern_image']) ? sanitize_text_field($_POST['pattern_image']) : '';
        $pattern_file_url = isset($_POST['pattern_file']) ? sanitize_text_field($_POST['pattern_file']) : '';

        global $wpdb;
        $table_name = FICTIVE_TABLE . 'patterns';

        if ($id <= 0) {
            wp_redirect(admin_url('admin.php?page=' . PATTERNS_BUILDER_SLUG . '&error=invalid_id'));
            exit;
        }
        $wpdb->update(
            $table_name,
            array(
                'name' => $pattern_name,
                'user' => get_current_user_id(),
                'pattern_url' => $pattern_file_url,
                'pattern_image' => $pattern_image_url
            ),
            array('id' => $id),
            array('%s', '%d', '%s', '%s'),
            array('%d')
        );

        $redirect_params = array(
            'page' => PATTERNS_BUILDER_SLUG,
        );

        $url = add_query_arg($redirect_params, admin_url('admin.php'));
        wp_redirect($url);
        exit;
    }

}