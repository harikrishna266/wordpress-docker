<?php
namespace FictiveCodes;

class ModelCreate
{
    public function get_model_create_template()
    {
        $action = ($_GET['action']);
        $models_dummy_data = array(
            array(
                'name' => 'model_1',
                'model_url' => 'model_1_url',
            ),
            array(
                'name' => 'model_2',
                'model_url' => 'model_2_url',
            )
        );
        require_once (plugin_dir_path(__FILE__) . 'model-create-view.php');
    }
}