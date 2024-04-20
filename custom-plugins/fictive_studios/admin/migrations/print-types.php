<?php

function create_print_types_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'print_types';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        ID mediumint(9) NOT NULL AUTO_INCREMENT,
        name text NOT NULL,
        link text NOT NULL,
        user int NOT NULL,
        PRIMARY KEY  (ID)
    ) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}