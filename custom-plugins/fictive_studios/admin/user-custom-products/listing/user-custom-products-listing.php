<?php
namespace FictiveCodes;

class UserCustomProducts
{

    public function listing()
    {
        if(isset($_GET['selected_product'])) {
            $this->showSelectedProductBuilder();
            return;
        }
        $link_url = esc_url(admin_url('admin.php?page=' . PRINT_TYPES_BUILDER_SLUG.'&selected_product=1'));
        include plugin_dir_path(__FILE__) . 'three-d-product-listing-helper.php';
        $template_table = new ThreeDProductListingHelper();
        require_once (plugin_dir_path(__FILE__) . 'partials/template-listing.php');
    }

    public function showSelectedProductBuilder() {
        require_once (plugin_dir_path(__FILE__) . 'partials/selected-product-listing.php');
    }

    public function add_3d_builder_script() {
//        wp_enqueue_script('3d-builder-polyfills-module', 'https://fictivecodes.com/wordpress-scripts/polyfills.js', array(), null, true);
//        wp_enqueue_script('3d-builder-main-module', 'https://fictivecodes.com/wordpress-scripts/main.js', array(), null, true);
    }


    public function process_3d_builder_script($tag, $handle, $src)
    {
        if (str_contains($handle, 'module')) {
            return'<script type="module" src="' . esc_url($src) . '"></script>';
        }
        return $tag;
    }


    public function add_submenu()
    {
        $submenu = array(
            'page_title' => __('Custom Products', 'User_custom_Products'),
            'menu_title' => __('Custom Products', 'User_custom_Products'),
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