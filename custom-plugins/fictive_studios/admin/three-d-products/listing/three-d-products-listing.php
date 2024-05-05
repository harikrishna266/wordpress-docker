<?php
namespace FictiveCodes;

class ThreeDProductListing
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
        wp_enqueue_script('3d-builder-script', plugin_dir_url(__FILE__) . '3d-builder.js', array(), null, true);
    }

    public function add_tailwind() {
        wp_enqueue_style('3d-tailwind-css', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.0.4/dist/tailwind.min.css');
    }


    public function add_htmlx()
    {
        wp_enqueue_script('3d-add_htmlx', 'https://unpkg.com/htmx.org@1.9.12', array(), null, true);
    }


    public function process_3d_builder_script($tag, $handle, $src)
    {
//        return $handle.$_GET['page']. '<br/>';
         if($handle == '3d-builder-script'  && $_GET['page'] == 'three_d_products_listing' ) {
            $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
        }
        if(isset($_GET['page']) && $_GET['page'] !== 'three_d_products_listing') {
            if (in_array($handle, ['3d-builder-script'])) {
                return '';
            }
            return $tag;
        }
        return $tag;

    }

    public function process_3d_builder_styles($tag, $handle, $src)
    {
        if(isset($_GET['page']) && $_GET['page'] != 'three_d_products_listing' &&  in_array($handle, ['tailwind-css-3d'])) {
            return '';
        }
        return $tag;
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