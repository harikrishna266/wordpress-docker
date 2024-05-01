<?php
namespace FictiveCodes;

class ThreeDProductListing
{

    public function listing()
    {
        $link_url = esc_url(admin_url('admin.php?page=' . PRINT_TYPES_BUILDER_SLUG));
        include plugin_dir_path(__FILE__) . 'three-d-product-listing-helper.php';
        $template_table = new ThreeDProductListingHelper();
        require_once (plugin_dir_path(__FILE__) . 'partials/template-listing.php');
    }

    public function add_submenu()
    {
        $submenu = array(
            'page_title' => __('3d Products', '3d_products'),
            'menu_title' => __('3d Products', '3d_products'),
            'capability' => 'manage_options',
            'menu_slug' => THREE_D_PRODUCTS_LISTING,
            'callback' => array($this, 'listing'),
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