<?php

function create_fashion_designs_tables()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'fashion_designs';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        ID mediumint(9) NOT NULL AUTO_INCREMENT,
        name text NOT NULL,
        model_id mediumint(9) NOT NULL,
        user int NOT NULL,
        design_file text NOT NULL,
        PRIMARY KEY  (ID),
        FOREIGN KEY (model_id) REFERENCES {$wpdb->prefix}models(ID)
    ) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}