<?php
namespace FictiveCodes;

class PrintingTypesListingAdmin
{

    public function listing()
    {
        $link_url = esc_url(admin_url('admin.php?page=' . PRINT_TYPES_BUILDER_SLUG));
        include plugin_dir_path(__FILE__) . 'print-types-listing-helper.php';
        $print_types_table = new PrintTypesHelper();
        require_once (plugin_dir_path(__FILE__) . 'partials/print-types-header.php');
    }

    public function add_submenu()
    {
        $submenu = array(
            'page_title' => __('Print Types', 'print_types'),
            'menu_title' => __('Print Types', 'print_types'),
            'capability' => 'manage_options',
            'menu_slug' => PRINT_TYPES_BUILDER_SLUG,
            'callback' => array($this, 'choose_display_page'),
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

    public function choose_display_page()
    {
        if (isset($_GET['action']) && ($_GET['action'] == 'edit' || $_GET['action'] == 'create')) {
            echo $this->display_print_types_edit_pages();
        } else {
            echo $this->display_print_types_list_pages();
        }
    }

    public function display_print_types_list_pages()
    {
        $link_url = esc_url(admin_url('admin.php?page=' . PRINT_TYPES_BUILDER_SLUG));
        include plugin_dir_path(__FILE__) . 'print-types-listing-helper.php';
        $print_types_table = new PrintTypesHelper();
        require_once (plugin_dir_path(__FILE__) . 'partials/print-types-header.php');
    }

    public function display_print_types_edit_pages()
    {
        require_once (plugin_dir_path(__FILE__) . '../create/print-types-create.php');
        $print_types_table = new PrintTypesCreate();
        $print_types_table->get_create_print_types_template();
    }
}