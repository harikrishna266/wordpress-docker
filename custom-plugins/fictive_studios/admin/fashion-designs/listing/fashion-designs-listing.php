<?php
namespace FictiveCodes;

class FashionDesignsListingAdmin
{

    public function fashion_designs_admin()
    {
        $link_url = esc_url(admin_url('admin.php?page=' . FASHION_DESIGNS_BUILDER_SLUG));
        include plugin_dir_path(__FILE__) . 'fashion-designs-listing-helper.php';
        $fashion_design_table = new FashionDesignListingHelper();
        require_once (plugin_dir_path(__FILE__) . 'partials/fashion-designs-header.php');
    }
    public function add_submenu()
    {
        $submenu = array(
            'page_title' => __('Fashion Designs', 'fashion_designs'),
            'menu_title' => __('Fashion Designs', 'fashion_designs'),
            'capability' => 'manage_options',
            'menu_slug' => FASHION_DESIGNS_BUILDER_SLUG,
            'callback' => array($this, 'fashion_designs_admin'),
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