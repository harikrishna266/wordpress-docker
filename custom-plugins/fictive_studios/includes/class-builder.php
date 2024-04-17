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

        $templates_admin = new TemplatesCreateAdmin();
        $this->loader->add_action( 'wp_ajax_save_template_action', $templates_admin, 'save_template_hook' );
    }

    private function dashboard()
    {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/dashboard/dashboard.php';
        $dashboard = new Dashboard();
        $this->loader->add_action( 'admin_menu', $dashboard, 'add_admin_menu' );
    }


    private function builder2d()
    {
        require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/builder-2d/builder-2d.php';
        $builder2d = new Builder2d();
        $this->loader->add_action( 'admin_menu', $builder2d, 'add_submenu' );
        $this->loader->add_action( 'admin_enqueue_scripts', $builder2d, 'add_2d_builder_script' );
        $this->loader->add_filter( 'script_loader_tag', $builder2d, 'process_2d_builder_script', 9, 3 );
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