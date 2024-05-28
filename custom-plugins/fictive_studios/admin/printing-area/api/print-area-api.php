<?php
class PrintAreaAPIAdmin
{
    public function get_print_area_data()
    {
        global $wpdb;
        $sql_query = "SELECT * FROM " . FICTIVE_TABLE . "print_areas";
        $results = $wpdb->get_results($sql_query);
        echo json_encode($results);
        wp_die();
    }

    public function save_print_area_data()
    {
        $height = isset($_POST['height']) ? sanitize_text_field($_POST['height']) : '';
        $width = isset($_POST['width']) ? sanitize_text_field($_POST['width']) : '';
        global $wpdb;
        $table_name = FICTIVE_TABLE . 'print_areas';
        $wpdb->insert(
            $table_name,
            array(
                'height' => $height,
                'width' => $width,
                'user' => get_current_user_id()
            ),
            array('%s', '%s', '%d')
        );
        $edit_params = array(
            'page' => 'printing_areas_builder',
        );
        $url = add_query_arg($edit_params, admin_url('admin.php'));
        wp_redirect($url);
        exit;
    }
    

    public function edit_print_area_data()
    {
        $height = isset($_POST['height']) ? sanitize_text_field($_POST['height']) : '';
        $width = isset($_POST['width']) ? sanitize_text_field($_POST['width']) : '';

        global $wpdb;
        $table_name = FICTIVE_TABLE . 'print_areas';

        $id = isset($_POST['id']) ? intval($_POST['id']) : 0;

        if ($id <= 0) {
            wp_redirect(admin_url('admin.php?page=printing_areas_builder&error=invalid_id'));
            exit;
        }
        $wpdb->update(
            $table_name,
            array(
                'height' => $height,
                'width' => $width,
                'user' => get_current_user_id()
            ),
            array('id' => $id),
            array('%s', '%s', '%d'),
            array('%d')
        );

        $redirect_params = array(
            'page' => 'printing_areas_builder',
        );

        $url = add_query_arg($redirect_params, admin_url('admin.php'));
        wp_redirect($url);
        exit;
    }


}