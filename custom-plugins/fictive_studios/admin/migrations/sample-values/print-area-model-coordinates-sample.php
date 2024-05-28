<?php

function add_print_area_model_coordinates_sample()
{
    global $wpdb;
    $models_table = FICTIVE_TABLE . 'models';
    $print_areas_table = FICTIVE_TABLE . 'print_areas';
    $models_ids = $wpdb->get_col("SELECT ID FROM $models_table");
    $print_area_ids = $wpdb->get_col("SELECT ID FROM $print_areas_table");

    if (empty($models_ids)) {
        return;
    }

    $print_area_model_coordinates_table = FICTIVE_TABLE . 'print_area_model_coordinates';

    $sample_data = array(
        array(
            'name' => 'chest_logos',
            'x_coordinate' => 10,
            'y_coordinate' => 20,
            'camera_x_coordinates' => 30,
            'camera_y_coordinates' => 30,
            'user' => 1,
        ),
        array(
            'name' => 'arm_logos',
            'x_coordinate' => 15,
            'y_coordinate' => 25,
            'camera_x_coordinates' => 35,
            'camera_y_coordinates' => 35,
            'user' => 1,
        ),
        array(
            'name' => 'back_logos',
            'x_coordinate' => 20,
            'y_coordinate' => 30,
            'camera_x_coordinates' => 22,
            'camera_y_coordinates' => 35,
            'user' => 1,
        ),
        array(
            'name' => 'front_logos',
            'x_coordinate' => 13,
            'y_coordinate' => 22,
            'camera_x_coordinates' => 3,
            'camera_y_coordinates' => 35,
            'user' => 1,
        ),
    );

    foreach ($sample_data as $data) {
        $random_models_id = $models_ids[array_rand($models_ids)];
        $random_print_areas_id = $print_area_ids[array_rand($print_area_ids)];

        $data['models_id'] = $random_models_id;
        $data['print_area_id'] = $random_print_areas_id;

        $wpdb->insert(
            $print_area_model_coordinates_table,
            $data
        );
    }
}
