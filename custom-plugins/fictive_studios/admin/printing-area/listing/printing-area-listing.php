<?php
namespace FictiveCodes;

class PrintingAreaListingAdmin
{

    public function add_submenu()
    {
        $submenu = array(
            'page_title' => __('Printing Areas', 'printing_areas'),
            'menu_title' => __('Printing Areas', 'printing_areas'),
            'capability' => 'manage_options',
            'menu_slug' => PRINTING_AREAS_BUILDER_SLUG,
            'callback' => array($this, 'display_items_page'),
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

    function display_items_page()
    {
        if (isset($_GET['action']) && ($_GET['action'] == 'edit' || $_GET['action'] == 'create')) {
            echo $this->display_print_area_edit_pages();
        } else {
            echo $this->display_print_area_list_pages();
        }
    }

    public function display_print_area_list_pages()
    {
        $link_url = esc_url(admin_url('admin.php?page=' . PRINTING_AREAS_BUILDER_SLUG));
        include plugin_dir_path(__FILE__) . 'printing-area-listing-helper.php';
        $print_area_table = new PrintAreasListingHelper();
        require_once (plugin_dir_path(__FILE__) . 'partials/printing-area-header.php');
        echo '<a id="getPrintArea" class="button-secondary">Get All Print Areas</a>';
    }

    public function display_print_area_edit_pages()
    {
        require_once (plugin_dir_path(__FILE__) . '../create/print-area-create.php');
        $print_area_edit = new PrintAreaCreate();
        $print_area_edit->get_create_print_area_template();
    }


}