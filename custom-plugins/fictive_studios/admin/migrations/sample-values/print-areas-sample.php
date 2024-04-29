<?php

function create_printing_areas_table()
{
    global $wpdb;
    $table_name = $wpdb->prefix . 'print_areas';

    $print_areas_sample_data = array(
        array(
            'width' => 100,
            'height' => 200,
            'user' => 1
        ),
        array(
            'width' => 150,
            'height' => 250,
            'user' => 1
        ),
    );

    foreach ($print_areas_sample_data as $data) {
        $wpdb->insert(
            $table_name,
            $data
        );
    }
}