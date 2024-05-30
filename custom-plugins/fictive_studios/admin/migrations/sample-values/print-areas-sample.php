<?php

function create_printing_areas_sample()
{
    global $wpdb;
    $table_name = FICTIVE_TABLE . 'print_areas';

    $row_count = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");

    if ($row_count == 0) {
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
}