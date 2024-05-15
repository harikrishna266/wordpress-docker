<?php

namespace FictiveCodes;

class PatternsAPIAdmin
{

    public function __construct()
    {
        add_filter('upload_mimes', array($this, 'custom_upload_svg'));
    }

    public function get_all_patterns()
    {
        global $wpdb;
        $query = "SELECT * FROM " . $wpdb->prefix . "patterns";
        $results = $wpdb->get_results($query);
        echo json_encode($results);
        wp_die();
    }

    public function get_pattern_by_id()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'patterns';
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

    public function custom_upload_svg($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }

    public function save_pattern_data()
    {
        $pattern_name = isset($_POST['pattern_name']) ? sanitize_text_field($_POST['pattern_name']) : '';

        $pattern_file_url = $this->handle_file_submission('pattern_file');
        $pattern_image_url = $this->handle_file_submission('pattern_image');

        if ($pattern_file_url !== false && $pattern_image_url !== false) {
            global $wpdb;
            $patterns_table = $wpdb->prefix . 'patterns';

            $insert_data = array(
                'name' => $pattern_name,
                'user' => get_current_user_id(),
                'pattern_url' => $pattern_file_url,
                'pattern_image' => $pattern_image_url
            );

            $wpdb->insert($patterns_table, $insert_data);

            $redirect_page_params = array(
                'page' => PATTERNS_BUILDER_SLUG,
            );
            $url = add_query_arg($redirect_page_params, admin_url('admin.php'));
            wp_redirect($url);
        } else {
            wp_die('Error uploading file');
        }
    }

    public function handle_file_submission($file_name)
    {
        $files_url = '';
        $file_upload_location = $file_name === 'pattern_file' ? 'custom_pattern_file_upload_dir' : 'custom_pattern_image_upload_dir';

        if (!empty($_FILES[$file_name]['tmp_name'])) {
            add_filter('upload_dir', array($this, $file_upload_location));
            $uploaded_file = wp_handle_upload($_FILES[$file_name], array('test_form' => false));
            remove_filter('upload_dir', array($this, $file_upload_location));
            if (!isset($uploaded_file['error'])) {
                $files_url = $uploaded_file['url'];
            } else {
                return false;
            }
        } else {
            $files_url = '';
        }

        return $files_url;
    }


    public function custom_pattern_file_upload_dir($upload)
    {
        $upload['path'] = WP_CONTENT_DIR . '/uploads/patterns/files';
        $upload['url'] = WP_CONTENT_URL . '/uploads/patterns/files';
        return $upload;
    }

    public function custom_pattern_image_upload_dir($upload)
    {
        $upload['path'] = WP_CONTENT_DIR . '/uploads/patterns/images';
        $upload['url'] = WP_CONTENT_URL . '/uploads/patterns/images';
        return $upload;
    }

}