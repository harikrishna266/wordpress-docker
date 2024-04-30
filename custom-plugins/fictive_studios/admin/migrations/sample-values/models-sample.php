<?php

function add_models_sample()
{
    global $wpdb;
    $models_table = $wpdb->prefix . 'models';

    $row_count = $wpdb->get_var("SELECT COUNT(*) FROM $models_table");

    if ($row_count == 0) {
        $models_sample_data = array(
            array(
                'name' => 'model_1',
                'model_url' => 'dummy_url',
                'user' => 1
            ),
            array(
                'name' => 'model_2',
                'model_url' => 'dummy_url',
                'user' => 1
            ),
        );

        foreach ($models_sample_data as $data) {
            $wpdb->insert(
                $models_table,
                $data
            );
        }
    }
}