<?php

function create_fashion_designs_tables()
{
    global $wpdb;
    $table_name = FICTIVE_TABLE . 'fashion_designs';
    $models_table = FICTIVE_TABLE. 'models';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        ID mediumint(9) NOT NULL AUTO_INCREMENT,
        name text NOT NULL,
        model_id mediumint(9) NOT NULL,
        user int NOT NULL,
        PRIMARY KEY  (ID),
        FOREIGN KEY (model_id) REFERENCES $models_table(ID)
    ) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}