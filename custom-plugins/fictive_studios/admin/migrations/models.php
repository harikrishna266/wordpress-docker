<?php

function create_models_tables()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'models';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        ID mediumint(9) NOT NULL AUTO_INCREMENT,
        name text NOT NULL,
        model_url text NOT NULL,
        user int NOT NULL,
        PRIMARY KEY  (ID)
    ) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}