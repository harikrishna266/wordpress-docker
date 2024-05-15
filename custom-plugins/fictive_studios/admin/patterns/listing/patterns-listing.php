<?php
namespace FictiveCodes;

class PatternsListingAdmin
{

    public function add_submenu()
    {
        $submenu = array(
            'page_title' => __('Patterns', 'patterns'),
            'menu_title' => __('Patterns', 'patterns'),
            'capability' => 'manage_options',
            'menu_slug' => PATTERNS_BUILDER_SLUG,
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
            echo $this->display_patterns_edit_pages();
        } else {
            echo $this->display_patterns_list_pages();
        }
    }

    public function display_patterns_list_pages()
    {
        $link_url = esc_url(admin_url('admin.php?page=' . PATTERNS_BUILDER_SLUG));
        include plugin_dir_path(__FILE__) . 'patterns-listing-helper.php';
        $patterns_table = new PatternsListingHelper();
        require_once (plugin_dir_path(__FILE__) . 'partials/patterns-header.php');
    }

    public function display_patterns_edit_pages()
    {
        require_once (plugin_dir_path(__FILE__) . '../create/patterns-create.php');
        $print_area_edit = new PatternsCreate();
        $print_area_edit->get_create_patterns_template();
    }


}