<?php

function add_print_area_model_coordinates_sample()
{
    global $wpdb;

    $models_ids = $wpdb->get_col("SELECT ID FROM {$wpdb->prefix}models");

    if (empty($models_ids)) {
        return;
    }

    $print_area_model_coordinates_table = $wpdb->prefix . 'print_area_model_coordinates';

    $sample_data = array(
        array(
            'x_coordinate' => '10',
            'y_coordinate' => '20',
            'camera_coordinates' => '30',
            'user' => 1,
        ),
        array(
            'x_coordinate' => '15',
            'y_coordinate' => '25',
            'camera_coordinates' => '35',
            'user' => 1,
        ),
        array(
            'x_coordinate' => '20',
            'y_coordinate' => '30',
            'camera_coordinates' => '22',
            'user' => 1,
        ),
        array(
            'x_coordinate' => '13',
            'y_coordinate' => '22',
            'camera_coordinates' => '3',
            'user' => 1,
        ),
    );

    foreach ($sample_data as $data) {
        $random_models_id = $models_ids[array_rand($models_ids)];

        $data['models_id'] = $random_models_id;

        $wpdb->insert(
            $print_area_model_coordinates_table,
            $data
        );
    }
}
