<?php

function add_patterns_sample()
{
    global $wpdb;
    $patterns_table = $wpdb->prefix . 'patterns';

    $row_count = $wpdb->get_var("SELECT COUNT(*) FROM $patterns_table");

    if ($row_count == 0) {
        $designs_sample_data = array(
            array(
                'name' => 'pattern_2',
                'user' => 1,
                'pattern_image' => "https://images.pexels.com/photos/13840942/pexels-photo-13840942.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
                'pattern_url' => "https://raw.githubusercontent.com/krishnajithr5/graphics-design-/tiger/parrterns/PARRTERN-2/patterns-2.txt",
            ),
            array(
                'name' => 'pattern_3',
                'user' => 1,
                'pattern_image' => "https://images.pexels.com/photos/13840942/pexels-photo-13840942.jpeg?auto=compress&cs=tinysrgb&w=1260&h=750&dpr=1",
                'pattern_url' => "https://raw.githubusercontent.com/krishnajithr5/graphics-design-/tiger/parrterns/PARRTERN-3/pattern-3.txt",
            ),
        );

        foreach ($designs_sample_data as $data) {
            $wpdb->insert(
                $patterns_table,
                $data
            );
        }
    }
}