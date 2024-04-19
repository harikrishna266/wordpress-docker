<?php

function create_models_tables()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'models';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        ID mediumint(9) NOT NULL AUTO_INCREMENT,
        name text NOT NULL,
        print_area_id mediumint(9) NOT NULL,
        cordinates text NOT NULL,
        camera_cordinates text NOT NULL,
        user int NOT NULL,
        PRIMARY KEY  (ID),
        FOREIGN KEY (print_area_id) REFERENCES {$wpdb->prefix}print_areas(ID)
    ) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}