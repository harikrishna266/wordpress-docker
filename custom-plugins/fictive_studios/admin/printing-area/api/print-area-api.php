<?php
class PrintAreaAPIAdmin
{
    public function get_print_area_data()
    {
        global $wpdb;
        $sql_query = "SELECT * FROM " . $wpdb->prefix . "print_areas";
        $results = $wpdb->get_results($sql_query);
        echo json_encode($results);
        wp_die();
    }

    public function save_print_area_data()
    {
        $height = isset($_POST['height']) ? $_POST['height'] : '';
        $width = isset($_POST['width']) ? $_POST['width'] : '';
        global $wpdb;
        $table_name = $wpdb->prefix . 'print_areas';
        $wpdb->insert(
            $table_name,
            array(
                'height' => $height,
                'width' => $width,
                'user' => get_current_user_id()
            )
        );
        wp_die();
    }

    public function edit_print_area_data()
    {
        $height = isset($_POST['height']) ? $_POST['height'] : '';
        $width = isset($_POST['width']) ? $_POST['width'] : '';
        global $wpdb;
        $table_name = $wpdb->prefix . 'print_areas';
        $wpdb->update(
            $table_name,
            array(
                'height' => $height,
                'width' => $width,
                'user' => get_current_user_id()
            ),
            array('id' => $_POST['id']),
            array('%s', '%s'),
            array('%d')
        );
        wp_die();
    }

}