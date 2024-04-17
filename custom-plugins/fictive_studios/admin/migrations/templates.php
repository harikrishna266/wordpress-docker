<?php

function create_templates_tables()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'builder_templates';
    $charset_collate = $wpdb->get_charset_collate();
    $sql = "CREATE TABLE $table_name (
        ID mediumint(9) NOT NULL AUTO_INCREMENT,
        templateData text NOT NULL,
        name text NOT NULL,
        isPublished BOOLEAN DEFAULT 0,
        user int NOT NULL,
        PRIMARY KEY  (ID)
    ) $charset_collate;";
    require_once (ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}