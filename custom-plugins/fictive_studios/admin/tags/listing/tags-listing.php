<?php
namespace FictiveCodes;

class TagsListingAdmin
{

    public function add_submenu()
    {
        $submenu = array(
            'page_title' => __('Tags', 'tags'),
            'menu_title' => __('Tags', 'tags'),
            'capability' => 'manage_options',
            'menu_slug' => TAGS_SLUG,
            'callback' => array($this, 'display_items_page'),
        );
        add_submenu_page(
            'builder_main_menu',
            $submenu['page_title'],
            $submenu['menu_title'],
            $submenu['capability'],
            $submenu['menu_slug'],
            $submenu['callback']
        );
    }

    function display_items_page()
    {
        if (isset($_GET['action']) && ($_GET['action'] == 'edit' || $_GET['action'] == 'create')) {
            echo $this->display_tags_edit_pages();
        } else {
            echo $this->display_tags_list_pages();
        }
    }

    public function display_tags_list_pages()
    {
        $link_url = esc_url(admin_url('admin.php?page=' . TAGS_SLUG));
        include plugin_dir_path(__FILE__) . 'tags-listing-helper.php';
        $tags_table = new TagsListingHelper();
        require_once (plugin_dir_path(__FILE__) . 'partials/tags-header.php');
    }

    public function display_tags_edit_pages()
    {
        require_once (plugin_dir_path(__FILE__) . '../create/tags-create.php');
        $tags_edit = new TagsCreate();
        $tags_edit->get_create_tags_template();
    }


}