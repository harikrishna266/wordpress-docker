<?php
namespace FictiveCodes;

class ModelCreate
{
    public function get_model_create_template()
    {
        $action = ($_GET['action']);
        require_once (plugin_dir_path(__FILE__) . 'model-create-view.php');
    }
}