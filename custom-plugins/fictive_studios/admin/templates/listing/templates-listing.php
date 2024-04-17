<?php
class TemplatesListingAdmin {

     public function template_listing_admin() {
        $link_url = esc_url(admin_url('admin.php?page=' . TEMPLATE_BUILDER_SLUG));
        include plugin_dir_path(__FILE__) . 'template-list-helper.php';
        $template_table = new Template_List_Table();
        require_once (plugin_dir_path(__FILE__) . 'partials/template-listing.php');
     }

    public function add_submenu()
    {
        $submenu = array(
            'page_title' => __( 'Templates', 'builder_templates' ),
            'menu_title' =>__( 'Templates', 'builder_templates' ),
            'capability' => 'manage_options',
            'menu_slug' => 'templates_listing',
            'callback'   => array($this, 'template_listing_admin'),
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
