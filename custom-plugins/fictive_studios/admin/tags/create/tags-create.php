<?php

namespace FictiveCodes;

class TagsCreate
{
    public function get_create_tags_template()
    {
        $action = ($_GET['action']);
        $tags_data = null;
        if ($action == 'edit') {
            $tag_id = ($_GET['tag']);
            $tags_data = $this->get_tag_data_for_edit($tag_id);
        }
        require_once(plugin_dir_path(__FILE__) . '../create/tags-create-view.php');
    }

    public function get_tag_data_for_edit($tag_id)
    {
        global $wpdb;
        $table_name = FICTIVE_TABLE . 'tags';
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE ID = %d", $tag_id);
        return $wpdb->get_row($query);
    }
}
