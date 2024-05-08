<?php

namespace FictiveCodes;

class FashionDesignAPIAdmin
{

    public function __construct()
    {
        add_filter('upload_mimes', array($this, 'custom_upload_svg'));
    }

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

    public function custom_upload_svg($mimes)
    {
        $mimes['svg'] = 'image/svg+xml';
        return $mimes;
    }

    public function save_design()
    {
        $design_name = isset($_POST['fashion_design_name']) ? sanitize_text_field($_POST['fashion_design_name']) : '';
        $model_id = isset($_POST['fashion_design_model']) ? sanitize_text_field($_POST['fashion_design_model']) : '';
        $design_file_url = $this->handle_file_submission();
        if ($design_file_url !== false) {
            global $wpdb;
            $model_table = $wpdb->prefix . 'fashion_designs';

            $insert_data = array(
                'name' => $design_name,
                'model_id' => $model_id,
                'user' => get_current_user_id()
            );

            for ($i = 1; $i <= 5; $i++) {
                if (isset($design_file_url[$i - 1])) {
                    $insert_data['design_layer_' . $i] = $design_file_url[$i - 1];
                }
            }

            $wpdb->insert($model_table, $insert_data);

            $redirect_page_params = array(
                'page' => FASHION_DESIGNS_BUILDER_SLUG,
            );
            $url = add_query_arg($redirect_page_params, admin_url('admin.php'));
            wp_redirect($url);
        } else {
            wp_die('Error uploading file');
        }
    }

    public function handle_file_submission()
    {
        $design_files_urls = array();
        for ($i = 1; $i <= 5; $i++) {
            if (!empty($_FILES['fashion_design_layer_' . $i]['tmp_name'])) {
                add_filter('upload_dir', array($this, 'custom_upload_dir'));
                $uploaded_file = wp_handle_upload($_FILES['fashion_design_layer_' . $i], array('test_form' => false));
                remove_filter('upload_dir', array($this, 'custom_upload_dir'));

                if (!isset($uploaded_file['error'])) {
                    $design_files_urls[] = $uploaded_file['url'];
                } else {
                    return false;
                }
            } else {
                $design_files_urls[] = '';
            }
        }

        return $design_files_urls;
    }



    public function custom_upload_dir($upload)
    {
        $upload['path'] = WP_CONTENT_DIR . '/uploads/fashion-designs';
        $upload['url'] = WP_CONTENT_URL . '/uploads/fashion-designs';
        return $upload;
    }

}