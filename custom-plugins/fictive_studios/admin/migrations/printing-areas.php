<?php

function create_printing_areas_tables()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'builder_printing_areas';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        ID mediumint(9) NOT NULL AUTO_INCREMENT,
        width mediumint(9) NOT NULL,
        height mediumint(9) NOT NULL,
        user int NOT NULL,
        PRIMARY KEY  (ID)
    ) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}