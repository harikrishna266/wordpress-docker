<?php

class Builder {

    protected $loader;

    protected $builder;

    protected $version;

    public function __construct() {
        if ( defined( 'BUILDER_VERSION' ) ) {
            $this->version = BUILDER_VERSION;
        } else {
            $this->version = '1.0.0';
        }
        $this->builder = 'builder';

        $this->createLoader();
        $this->dashboard();
        $this->TemplateCRUD();
        $this->builder2d();
        $this->printing_areas_CRUD();
        $this->print_types_CRUD();
        $this->fashion_designs_CRUD();
        $this->models_CRUD();
        $this->threeDModelCrud();
    }

    private function createLoader() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-builder-loader.php';
        $this->loader = new Builder_Loader();
    }

    private function TemplateCRUD() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/templates/listing/templates-listing.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/templates/create/templates-create.php';

        $templates_admin = new FictiveCodes\TemplatesListingAdmin();
        $this->loader->add_action( 'admin_menu', $templates_admin, 'add_submenu' );

        $templates_admin = new FictiveCodes\TemplatesCreateAdmin();
        $this->loader->add_action( 'wp_ajax_save_template_action', $templates_admin, 'save_template_hook' );
    }

    private function printing_areas_CRUD(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/printing-area/listing/printing-area-listing.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/printing-area/api/print-area-api.php';

        $printing_area_admin = new FictiveCodes\PrintingAreaListingAdmin();
        $this->loader->add_action( 'admin_menu', $printing_area_admin, 'add_submenu' );

        $printing_area_admin_api = new PrintAreaAPIAdmin();
        $this->loader->add_action( 'wp_ajax_get_print_areas', $printing_area_admin_api, 'get_print_area_data' );
        $this->loader->add_action( 'admin_post_save_print_area', $printing_area_admin_api, 'save_print_area_data' );
        $this->loader->add_action( 'admin_post_edit_print_area', $printing_area_admin_api, 'edit_print_area_data' );
    }

    private function print_types_CRUD(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/print-types/listing/print-types-listing.php';

        $print_types_admin = new FictiveCodes\PrintingTypesListingAdmin();
        $this->loader->add_action( 'admin_menu', $print_types_admin, 'add_submenu' );
    }
    private function fashion_designs_CRUD(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/fashion-designs/listing/fashion-designs-listing.php';

        $fashion_designs_admin = new FictiveCodes\FashionDesignsListingAdmin();
        $this->loader->add_action( 'admin_menu', $fashion_designs_admin, 'add_submenu' );
    }

    private function models_CRUD(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/models/listing/models-listing.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/models/api/models-api.php';

        $models_admin = new FictiveCodes\ModelsListingAdmin();
        $this->loader->add_action( 'admin_menu', $models_admin, 'add_submenu' );

        $models_admin_api = new FictiveCodes\ModelsAPIAdmin();
        $this->loader->add_action( 'wp_ajax_get_models', $models_admin_api, 'get_models_data' );
        $this->loader->add_action( 'wp_ajax_get_model_by_id', $models_admin_api, 'get_model_data_by_id' );
    }

    private function dashboard()
    {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/dashboard/dashboard.php';
        $dashboard = new Dashboard();
        $this->loader->add_action( 'admin_menu', $dashboard, 'add_admin_menu' );
    }

    private function threeDModelCrud()
    {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/three-d-products/listing/three-d-products-listing.php';
        $threeDProductListing = new FictiveCodes\ThreeDProductListing();
        $this->loader->add_action( 'admin_menu', $threeDProductListing, 'add_submenu' );
        $this->loader->add_action( 'admin_enqueue_scripts', $threeDProductListing, 'add_htmlx' );
        $this->loader->add_action( 'admin_enqueue_scripts', $threeDProductListing, 'add_3d_builder_script' );
        $this->loader->add_action( 'admin_enqueue_scripts', $threeDProductListing, 'add_tailwind' );
        $this->loader->add_filter( 'script_loader_tag', $threeDProductListing, 'process_3d_builder_script', 9, 3 );
        $this->loader->add_filter( 'style_loader_tag', $threeDProductListing, 'process_3d_builder_styles', 9, 3 );
    }


    private function builder2d()
    {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/builder-2d/builder-2d.php';
        $builder2d = new Builder2d();
        $this->loader->add_action( 'admin_menu', $builder2d, 'add_submenu' );
        $this->loader->add_action( 'admin_enqueue_scripts', $builder2d, 'add_2d_builder_script' );
        $this->loader->add_action( 'admin_enqueue_scripts', $builder2d, 'add_alphine_js' );
        $this->loader->add_action( 'admin_enqueue_scripts', $builder2d, 'add_tailwind' );
         $this->loader->add_filter( 'script_loader_tag', $builder2d, 'process_2d_builder_script', 9, 3 );
        $this->loader->add_filter( 'style_loader_tag', $builder2d, 'process_2d_builder_styles', 9, 3 );
    }


    private function define_public_hooks() {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-builder-public.php';
        $plugin_public = new Builder_Public( $this->get_builder(), $this->get_version() );
        $this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
    }

    public function run() {
        $this->loader->run();
    }

    public function get_builder() {
        return $this->builder;
    }

    public function get_loader() {
        return $this->loader;
    }

    public function get_version() {
        return $this->version;
    }

}