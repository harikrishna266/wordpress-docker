<?php

class AdminBuilder {

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

        $this->initDependencies();
        $this->createLoader();
        $this->dashboard();
        $this->TemplateCRUD();
//        $this->builder2d();
        $this->printing_areas_CRUD();
        $this->print_types_CRUD();
        $this->fashion_designs_CRUD();
        $this->models_CRUD();
        $this->threeDModelCrud();
        $this->model_print_area_CRUD();
        $this->patterns_CRUD();
        $this->fashion_design_layers_CRUD();
        $this->initUserDesigns();        
    }

    private function initDependencies(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/manage-is-customizable-field.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/private-products-handler.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/woo-products-filter.php';

        new ManageIsCustomizableField();
        new PrivateProductsHandler();
        new WooProductFilter();
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
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/print-types/api/print-types-api.php';

        $print_types_admin = new FictiveCodes\PrintingTypesListingAdmin();
        $this->loader->add_action( 'admin_menu', $print_types_admin, 'add_submenu' );

        $print_type_api = new FictiveCodes\PrintTypesAPIAdmin();
        $this->loader->add_action( 'admin_post_save_print_type', $print_type_api, 'save_print_types_data' );
        $this->loader->add_action( 'admin_post_edit_print_type', $print_type_api, 'edit_print_types_data' );
    }
    private function fashion_designs_CRUD(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/fashion-designs/listing/fashion-designs-listing.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/fashion-designs/api/fashion-design-api.php';

        $fashion_designs_admin = new FictiveCodes\FashionDesignsListingAdmin();
        $this->loader->add_action( 'admin_menu', $fashion_designs_admin, 'add_submenu' );

        $fashion_design_api = new FictiveCodes\FashionDesignAPIAdmin();
        $this->loader->add_action( 'admin_post_save_design_data', $fashion_design_api, 'save_design' );
        $this->loader->add_action( 'admin_post_edit_design_data', $fashion_design_api, 'edit_design' );
        $this->loader->add_action( 'wp_ajax_get_design_by_id', $fashion_design_api, 'get_design_by_id' );
        $this->loader->add_action( 'wp_ajax_get_all_designs', $fashion_design_api, 'get_all_designs' );
    }

    private function models_CRUD(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/models/listing/models-listing.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/models/api/models-api.php';

        $models_admin = new FictiveCodes\ModelsListingAdmin();
        $this->loader->add_action( 'admin_menu', $models_admin, 'add_submenu' );

        $models_admin_api = new FictiveCodes\ModelsAPIAdmin();
        $this->loader->add_action( 'wp_ajax_get_models', $models_admin_api, 'get_models_data' );
        $this->loader->add_action( 'wp_ajax_get_model_by_id', $models_admin_api, 'get_model_data_by_id' );
        $this->loader->add_action( 'admin_post_save_model_data', $models_admin_api, 'save_model_data' );
    }

    private function model_print_area_CRUD(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/model-print-areas/listing/model-print-areas-listing.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/model-print-areas/api/model-print-areas-api.php';

        $model_print_area_list = new FictiveCodes\ModelPrintAreaListingAdmin();
        $this->loader->add_action( 'admin_menu', $model_print_area_list, 'add_submenu' );

        $model_print_areas_api = new FictiveCodes\ModelPrintAreasAPIAdmin();
        $this->loader->add_action( 'admin_post_save_model_print_area_data', $model_print_areas_api, 'save_model_print_area_data' );
    }

    private function fashion_design_layers_CRUD(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/layers/listing/layers-listing.php';
        $layers_list = new FictiveCodes\LayersListingAdmin();
        $this->loader->add_action( 'admin_menu', $layers_list, 'add_submenu' );

        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/layers/api/layers-api.php';
        $layersAPI = new FictiveCodes\LayersAPIAdmin();
        $this->loader->add_action( 'admin_post_save_design_layers_data', $layersAPI, 'save_design_layers_data' );
        $this->loader->add_action( 'admin_post_edit_design_layers_data', $layersAPI, 'edit_design_layers_data' );
    }

    private function dashboard()
    {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/dashboard/dashboard.php';
        $dashboard = new Dashboard();
        $this->loader->add_action( 'admin_menu', $dashboard, 'add_admin_menu' );
    }

    private function threeDModelCrud()
    {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/user-custom-products/listing/user-custom-products-listing.php';
        $threeDProductListing = new FictiveCodes\UserCustomProducts();
        $this->loader->add_action( 'admin_menu', $threeDProductListing, 'add_submenu' );
        $this->loader->add_action( 'admin_enqueue_scripts', $threeDProductListing, 'add_3d_builder_script' );
        $this->loader->add_filter( 'script_loader_tag', $threeDProductListing, 'process_3d_builder_script', 9, 3 );

    }

    private function patterns_CRUD(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/patterns/listing/patterns-listing.php';
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/patterns/api/patterns-api.php';

        $patternListing = new FictiveCodes\PatternsListingAdmin();
        $this->loader->add_action( 'admin_menu', $patternListing, 'add_submenu' );

        $patternAPI = new FictiveCodes\PatternsAPIAdmin();
        $this->loader->add_action( 'admin_post_save_pattern_data', $patternAPI, 'save_pattern_data' );
        $this->loader->add_action( 'admin_post_edit_pattern_data', $patternAPI, 'edit_pattern_data' );
        $this->loader->add_action( 'wp_ajax_get_patterns', $patternAPI, 'get_all_patterns' );
        $this->loader->add_action( 'wp_ajax_get_pattern_by_id', $patternAPI, 'get_pattern_by_id' );
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

    private function initUserDesigns(){
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/user-designs/api/user-designs-api.php';
        $user_design_api = new UserDesignsAPIAdmin(); 
        $this->loader->add_action( 'wp_ajax_save_user_design', $user_design_api, 'create_user_product' );
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