<?php
namespace FictiveCodes;

class TemplatesCreateAdmin {
    public function save_template_data()
    {
        $templateData = isset ($_POST['data']) ? $_POST['data'] : '';
        $templateName = isset ($_POST['name']) ? $_POST['name'] : '';
        global $wpdb;
        $table_name = FICTIVE_TABLE . 'templates';
        $wpdb->insert(
            $table_name,
            array(
                'templateData' => $templateData,
                'user' => get_current_user_id(),
                'name' => $templateName,
            )
        );
    }

    public function save_template_hook()
    {
        add_action('wp_ajax_save_template_action', 'save_template_data');
    }


}
