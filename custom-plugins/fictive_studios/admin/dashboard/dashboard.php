<?php
class Dashboard {

    public function builder_dashboard() {
        $link_url = esc_url(admin_url('admin.php?page=' . TEMPLATE_BUILDER_SLUG));
        include plugin_dir_path(__FILE__) . 'partials/dashboard.php';
    }

    public function add_admin_menu() {
        $menus = array(
            'page_title' => __( 'Dashboard', 'builder_dashboard' ),
            'menu_title' => __( 'Builder', 'builder_dashboard' ),
            'capability' => 'manage_options',
            'menu_slug' => 'builder_main_menu',
            'callback'   => array($this, 'builder_dashboard'),
            'icon_url' =>  'dashicons-admin-generic',
        );
        add_menu_page(
            $menus['page_title'],
            $menus['menu_title'],
            $menus['capability'],
            $menus['menu_slug'],
            $menus['callback'],
            $menus['icon_url']
        );
        $submenu = array(
            'page_title' => __( 'Dashboard', 'builder_dashboard' ),
            'menu_title' => __( 'Dashboard', 'builder_dashboard' ),
            'capability' => 'manage_options',
            'menu_slug' => 'dashboard',
            'callback'   => array($this, 'builder_dashboard'),
            'position' => 1
        );
        add_submenu_page(
            'builder_main_menu',
            $submenu['page_title'],
            $submenu['menu_title'],
            $submenu['capability'],
            $submenu['menu_slug'],
            $submenu['callback'],
            $submenu['position']
        );
        unset($GLOBALS['submenu']['builder_main_menu'][0]);



    }
}

?>
