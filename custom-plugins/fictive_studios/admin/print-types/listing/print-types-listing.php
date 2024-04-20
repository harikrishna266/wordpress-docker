<?php
namespace FictiveCodes;

class PrintingTypesListingAdmin
{

    public function printing_types_admin()
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
            'callback' => array($this, 'printing_types_admin'),
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
}