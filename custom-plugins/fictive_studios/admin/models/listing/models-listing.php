<?php
namespace FictiveCodes;

class ModelsListingAdmin
{

    public function add_submenu()
    {
        $submenu = array(
            'page_title' => __('Models', 'builder_models'),
            'menu_title' => __('Models', 'builder_models'),
            'capability' => 'manage_options',
            'menu_slug' => MODELS_BUILDER_SLUG,
            'callback' => array($this, 'display_models_page'),
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

    function display_models_page()
    {
        if (isset($_GET['action']) && ($_GET['action'] == 'edit' || $_GET['action'] == 'create')) {
            echo $this->display_models_edit_page();
        } else {
            echo $this->display_models_list_page();
        }
    }

    public function display_models_list_page()
    {
        $link_url = esc_url(admin_url('admin.php?page=' . MODELS_BUILDER_SLUG));
        include plugin_dir_path(__FILE__) . 'models-listing-helper.php';
        $models_table = new ModelsListingHelper();
        require_once (plugin_dir_path(__FILE__) . 'partials/models-listing-header.php');
    }

    public function display_models_edit_page()
    {
        require_once (plugin_dir_path(__FILE__) . '../create/model-create.php');
        $print_area_edit = new ModelCreate();
        $print_area_edit->get_model_create_template();
    }
}

?>