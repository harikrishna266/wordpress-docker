<?php

function create_print_area_model_cordinates_tables()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'print_area_model_coordinates';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        ID mediumint(9) NOT NULL AUTO_INCREMENT,
        models_id mediumint(9) NOT NULL,
        print_area_id mediumint(9) NOT NULL,
        x_coordinate DECIMAL(10, 3) NOT NULL,
        y_coordinate DECIMAL(10, 3) NOT NULL,
        camera_x_coordinates DECIMAL(10, 3) NOT NULL,
        camera_y_coordinates DECIMAL(10, 3) NOT NULL,
        user int NOT NULL,
        PRIMARY KEY  (ID),
        FOREIGN KEY (models_id) REFERENCES {$wpdb->prefix}models(ID) ON DELETE CASCADE,
        FOREIGN KEY (print_area_id) REFERENCES {$wpdb->prefix}print_areas(ID) ON DELETE CASCADE
    ) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}