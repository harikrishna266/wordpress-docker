<?php
namespace FictiveCodes;

class FashionDesignsListingAdmin
{
    public function add_submenu()
    {
        $submenu = array(
            'page_title' => __('Designs', 'fashion_designs'),
            'menu_title' => __('Designs', 'fashion_designs'),
            'capability' => 'manage_options',
            'menu_slug' => FASHION_DESIGNS_BUILDER_SLUG,
            'callback' => array($this, 'get_page'),
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

    function get_page()
    {
        if (isset($_GET['action']) && ($_GET['action'] == 'edit' || $_GET['action'] == 'create')) {
            echo $this->create_edit_page();
        } else {
            echo $this->list_page();
        }
    }

    public function list_page()
    {
        $link_url = esc_url(admin_url('admin.php?page=' . FASHION_DESIGNS_BUILDER_SLUG));
        include plugin_dir_path(__FILE__) . 'fashion-designs-listing-helper.php';
        $fashion_design_table = new FashionDesignListingHelper();
        require_once (plugin_dir_path(__FILE__) . 'partials/fashion-designs-header.php');
    }

    public function create_edit_page()
    {
        require_once (plugin_dir_path(__FILE__) . '../create/fashion-design-create.php');
        $fashion_design_create_edit = new FashionDesignCreate();
        $fashion_design_create_edit->get_create_fashion_design_template();
    }



}