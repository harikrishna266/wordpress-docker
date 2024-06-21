<?php
namespace FictiveCodes;

class LayersListingAdmin
{

    public function add_submenu()
    {
        $submenu = array(
            'page_title' => null,
            'menu_title' => null,
            'capability' => 'manage_options',
            'menu_slug' => DESIGN_LAYERS_SLUG,
            'callback' => array($this, 'get_page'),
        );
        add_submenu_page(
            null,
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
        $link_url = esc_url(admin_url('admin.php?page=' . DESIGN_LAYERS_SLUG));
        include plugin_dir_path(__FILE__) . 'layers-listing-helper.php';
        $layers_table = new LayersListingHelper();
        $design_data = $this->get_design_data();
        require_once (plugin_dir_path(__FILE__) . 'partials/layers-header.php');
    }

    public function get_design_data()
    {
        global $wpdb;
        $model_id = $_GET['design'];
        $table_name = FICTIVE_TABLE . 'fashion_designs';
        $query = $wpdb->prepare("SELECT * FROM $table_name WHERE ID = %d", $model_id);
        return $wpdb->get_row($query, ARRAY_A);
    }

    public function create_edit_page()
    {
        require_once (plugin_dir_path(__FILE__) . '../create/layers-create.php');
        $design_layer_edit = new DesignLayerCreate();
        $design_layer_edit->get_create_design_layer_template();
    }
}

?>