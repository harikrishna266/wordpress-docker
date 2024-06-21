<?php

function create_layers_tables()
{
    global $wpdb;
    $table_name = FICTIVE_TABLE . 'design_layers';
    $design_table_name = FICTIVE_TABLE . 'fashion_designs';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        ID mediumint(9) NOT NULL AUTO_INCREMENT,
        name text NOT NULL,
        color text NOT NULL,
        file_url text NOT NULL,
        allow_pattern boolean NOT NULL,
        design_id mediumint(9) NOT NULL,
        created_by int NOT NULL,
        PRIMARY KEY (ID),
        FOREIGN KEY (design_id) REFERENCES $design_table_name(ID) ON DELETE CASCADE
    ) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}