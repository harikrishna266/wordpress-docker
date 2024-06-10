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
                'design_layer_1_name' => "layer-1",
                'design_layer_1_link' => "https://raw.githubusercontent.com/krishnajithr5/graphics-design-/tiger/designs/cross-desgin/layer-1.txt",
                'design_layer_1_color' => "red",

                'design_layer_2_name' => "layer-2",
                'design_layer_2_link' => "https://raw.githubusercontent.com/krishnajithr5/graphics-design-/tiger/designs/cross-desgin/layer-2.txt",
                'design_layer_2_color' => "blue",

                'design_layer_3_name' => "",
                'design_layer_3_link' => "",
                'design_layer_3_color' => "",

                'design_layer_4_name' => "",
                'design_layer_4_link' => "",
                'design_layer_4_color' => "",

                'design_layer_5_name' => "",
                'design_layer_5_link' => "",
                'design_layer_5_color' => "",
            ),
            array(
                'name' => 'cross-line-desgin',
                'model_id' => 1,
                'user' => 1,

                'design_layer_1_name' => "layer-1",
                'design_layer_1_link' => "https://raw.githubusercontent.com/krishnajithr5/graphics-design-/tiger/designs/cross-line-desgin/layer-1.txt",
                'design_layer_1_color' => "red",

                'design_layer_2_name' => "layer-2",
                'design_layer_2_link' => "https://raw.githubusercontent.com/krishnajithr5/graphics-design-/tiger/designs/cross-line-desgin/layer-2.txt",
                'design_layer_2_color' => "blue",

                'design_layer_3_name' => "",
                'design_layer_3_link' => "",
                'design_layer_3_color' => "",

                'design_layer_4_name' => "",
                'design_layer_4_link' => "",
                'design_layer_4_color' => "",

                'design_layer_5_name' => "",
                'design_layer_5_link' => "",
                'design_layer_5_color' => "",
            ),
            array(
                'name' => 'gradient-desgin',
                'model_id' => 1,
                'user' => 1,

                'design_layer_1_name' => "layer-1",
                'design_layer_1_link' => "https://raw.githubusercontent.com/krishnajithr5/graphics-design-/tiger/designs/gradient-design/layer-1.txt",
                'design_layer_1_color' => "red",

                'design_layer_2_name' => "layer-2",
                'design_layer_2_link' => "https://raw.githubusercontent.com/krishnajithr5/graphics-design-/tiger/designs/gradient-design/layer-2.txt",
                'design_layer_2_color' => "blue",

                'design_layer_3_name' => "",
                'design_layer_3_link' => "",
                'design_layer_3_color' => "",

                'design_layer_4_name' => "",
                'design_layer_4_link' => "",
                'design_layer_4_color' => "",

                'design_layer_5_name' => "",
                'design_layer_5_link' => "",
                'design_layer_5_color' => "",
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
