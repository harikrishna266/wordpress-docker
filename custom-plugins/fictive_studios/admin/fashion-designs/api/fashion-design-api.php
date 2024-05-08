<?php

namespace FictiveCodes;

class FashionDesignAPIAdmin
{
    public function save_design()
    {
        $design_name = isset($_POST['fashion_design_name']) ? sanitize_text_field($_POST['fashion_design_name']) : '';
        $model_id = isset($_POST['fashion_design_model']) ? sanitize_text_field($_POST['fashion_design_model']) : '';
        $design_file_url = $this->handle_file_submission();

        if ($design_file_url !== false) {
            global $wpdb;
            $model_table = $wpdb->prefix . 'fashion_designs';
            $wpdb->insert(
                $model_table,
                array(
                    'name' => $design_name,
                    'model_id' => $model_id,
                    'design_file' => $design_file_url,
                    'user' => get_current_user_id()
                )
            );
            $redirect_page_params = array(
                'page' => 'fashion_designs_builder',
            );
            $url = add_query_arg($redirect_page_params, admin_url('admin.php'));
            wp_redirect($url);
        } else {
            wp_die('Error uploading file');
        }
    }

    public function handle_file_submission()
    {
        if (!empty($_FILES['fashion_design_file'])) {
            add_filter('upload_dir', array($this, 'custom_upload_dir'));
            $uploaded_file = wp_handle_upload($_FILES['fashion_design_file'], array('test_form' => false));
            remove_filter('upload_dir', array($this, 'custom_upload_dir'));
            if (!isset($uploaded_file['error'])) {
                return $uploaded_file['url'];
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

    public function custom_upload_dir($upload)
    {
        $upload['path'] = WP_CONTENT_DIR . '/uploads/fashion-designs';
        $upload['url'] = WP_CONTENT_URL . '/uploads/fashion-designs';
        return $upload;
    }

}