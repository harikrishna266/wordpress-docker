<?php
namespace FictiveCodes;

class ModelsListingAdmin {
     public function models_listing_admin() {
        $link_url = esc_url(admin_url('admin.php?page=' . MODELS_BUILDER_SLUG));
        include plugin_dir_path(__FILE__) . 'models-listing-helper.php';
        $models_table = new ModelsListingHelper();
        require_once (plugin_dir_path(__FILE__) . 'partials/models-listing.php');
     }

    public function add_submenu()
    {
        $submenu = array(
            'page_title' => __( 'Models', 'builder_models' ),
            'menu_title' =>__( 'Models', 'builder_models' ),
            'capability' => 'manage_options',
            'menu_slug' => MODELS_BUILDER_SLUG,
            'callback'   => array($this, 'models_listing_admin'),
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

?>
