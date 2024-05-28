<?php

function add_designs_sample()
{
    global $wpdb;
    $designs_table = FICTIVE_TABLE . 'fashion_designs';

    $row_count = $wpdb->get_var("SELECT COUNT(*) FROM $designs_table");

    if ($row_count == 0) {
        $designs_sample_data = array(
            array(
                'name' => 'cross-desgin',
                'model_id' => 1,
                'user' => 1,
                'design_layer_1' => "https://raw.githubusercontent.com/krishnajithr5/graphics-design-/tiger/designs/cross-desgin/layer-1.txt",
                'design_layer_2' => "https://raw.githubusercontent.com/krishnajithr5/graphics-design-/tiger/designs/cross-desgin/layer-2.txt",
                'design_layer_3' => "",
                'design_layer_4' => "",
                'design_layer_5' => "",
            ),
            array(
                'name' => 'cross-line-desgin',
                'model_id' => 1,
                'user' => 1,
                'design_layer_1' => "https://raw.githubusercontent.com/krishnajithr5/graphics-design-/tiger/designs/cross-line-desgin/layer-1.txt",
                'design_layer_2' => "https://raw.githubusercontent.com/krishnajithr5/graphics-design-/tiger/designs/cross-line-desgin/layer-2.txt",
                'design_layer_3' => "",
                'design_layer_4' => "",
                'design_layer_5' => "",
            ),
            array(
                'name' => 'gradient-desgin',
                'model_id' => 1,
                'user' => 1,
                'design_layer_1' => "https://raw.githubusercontent.com/krishnajithr5/graphics-design-/tiger/designs/gradient-design/layer-1.txt",
                'design_layer_2' => "https://raw.githubusercontent.com/krishnajithr5/graphics-design-/tiger/designs/gradient-design/layer-2.txt",
                'design_layer_3' => "",
                'design_layer_4' => "",
                'design_layer_5' => "",
            ),
        );

        foreach ($designs_sample_data as $data) {
            $wpdb->insert(
                $designs_table,
                $data
            );
        }
    }
}