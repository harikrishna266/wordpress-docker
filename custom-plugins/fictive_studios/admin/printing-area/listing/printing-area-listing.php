<?php
namespace FictiveCodes;

class PrintingAreaListingAdmin
{

    public function printing_area_admin()
    {
        $link_url = esc_url(admin_url('admin.php?page=' . PRINTING_AREAS_BUILDER_SLUG));
        include plugin_dir_path(__FILE__) . 'printing-area-listing-helper.php';
        $print_area_table = new PrintAreasListingHelper();
        require_once (plugin_dir_path(__FILE__) . 'partials/printing-area-header.php');
    }
    public function add_submenu()
    {
        $submenu = array(
            'page_title' => __('Printing Areas', 'printing_areas'),
            'menu_title' => __('Printing Areas', 'printing_areas'),
            'capability' => 'manage_options',
            'menu_slug' => PRINTING_AREAS_BUILDER_SLUG,
            'callback' => array($this, 'printing_area_admin'),
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