<?php
namespace FictiveCodes;

class PatternsCreate
{
    public function get_create_patterns_template()
    {
        $action = ($_GET['action']);
        require_once (plugin_dir_path(__FILE__) . '../create/patterns-create-view.php');
    }
}