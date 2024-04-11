<?php

/**
 * The admin-specific functionality of the plugin.
 *
 * @link       http://example.com
 * @since      1.0.0
 *
 * @package    Plugin_Name
 * @subpackage Plugin_Name/admin
 */



/**
 * The admin-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    Builder
 * @subpackage Builder/admin
 * @author     Your Name <email@example.com>
 */
class Builder_Admin {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $builder    The ID of this plugin.
	 */
	private $builder;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $builder       The name of this plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $builder, $version ) {
		$this->builder = $builder;
		$this->version = $version;
	}

	/**
	 * Register the stylesheets for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {
		wp_enqueue_style( $this->builder, plugin_dir_url( __FILE__ ) . 'css/builder-admin.css', array(), $this->version, 'all' );
	}

	/**
	 * Register the JavaScript for the admin area.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {
        wp_enqueue_script( $this->builder, plugin_dir_url( __FILE__ ) . 'js/builder-admin-n234234234.js', array( 'jquery' ), $this->version, false );
	}


    public function builder_dashboard() {
        echo "hi";
    }


    public function add_admin_menu() {
        $menus = array(
            'page_title' => __( 'Builder', 'builder_dashboard' ),
            'menu_title' => __( 'Builder', 'builder_dashboard' ),
            'capability' => 'manage_options',
            'menu_slug' => 'builder_main_menu',
            'callback'   => array($this, 'builder_dashboard'),
            'icon_url' =>  'dashicons-admin-generic',
            'position' => 6
        );
         add_menu_page(
            $menus['page_title'],
            $menus['menu_title'],
            $menus['capability'],
            $menus['menu_slug'],
            $menus['callback'],
            $menus['icon_url'],
            $menus['position']
        );
    }

    public function add_admin_submenu() {
        $submenus = array(
            array(
                'page_title' => __( 'Dashboard', 'builder_dashboard' ),
                'menu_title' => __( 'Dashboard', 'builder_dashboard' ),
                'capability' => 'manage_options',
                'menu_slug' => 'builder_dashboard',
                'callback'   => array($this, 'builder_dashboard'),
             ),
            array(
                'page_title' => __( 'Models', 'builder_models' ),
                'menu_title' => __( 'Models', 'builder_models' ),
                'capability' => 'manage_options',
                'menu_slug' => 'builder_dashboard',
                'callback'   => array($this, 'builder_dashboard'),
             ),
            array(
                'page_title' => __( 'Print Area Designs', 'builder_print_area_designs' ),
                'menu_title' => __( 'Print Area Designs', 'builder_print_area_designs' ),
                'capability' => 'builder_print_area_designs',
                'menu_slug' => 'builder_print_area_designs',
                'callback'   => array($this, 'builder_dashboard'),
             ),
            array(
                'page_title' => __( 'Designs', 'builder_saved_designs' ),
                'menu_title' =>__( 'Designs', 'builder_saved_designs' ),
                'capability' => 'manage_options',
                'menu_slug' => 'builder_saved_designs',
                'callback'   => array($this, 'builder_dashboard'),
            ),
         );

        foreach ($submenus as $submenu) {
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

}
