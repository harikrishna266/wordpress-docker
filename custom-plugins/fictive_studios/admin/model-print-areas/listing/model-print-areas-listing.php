<?php
namespace FictiveCodes;

class ModelPrintAreaListingAdmin
{

    public function add_submenu()
    {
        $submenu = array(
            'page_title' => null,
            'menu_title' => null,
            'capability' => 'manage_options',
            'menu_slug' => MODEL_PRINT_AREA_SLUG,
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
        $link_url = esc_url(admin_url('admin.php?page=' . MODEL_PRINT_AREA_SLUG));
        include plugin_dir_path(__FILE__) . 'model-print-areas-helper.php';
        $model_print_area_table = new ModelPrintAreasListingHelper();
        $model_data = $this->get_model_data();
        require_once (plugin_dir_path(__FILE__) . 'partials/model-print-areas-header.php');
    }

    public function get_model_data()
    {
        global $wpdb;
        $model_id = $_GET['model'];
        $table_name = FICTIVE_TABLE . 'models';
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE ID = %d", $model_id);
        return $model_data = $wpdb->get_row($query, ARRAY_A);
    }

    public function create_edit_page()
    {
        require_once (plugin_dir_path(__FILE__) . '../create/model-print-areas-create.php');
        $print_area_create_edit = new ModelPrintAreasCreate();
        $print_area_create_edit->get_model_print_area_create_template();
    }
}

?>