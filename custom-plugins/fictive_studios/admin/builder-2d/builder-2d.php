<?php

class Builder2d {


    public function templates()
    {
        $link_url = esc_url(admin_url('admin.php?page=' . TEMPLATE_BUILDER_SLUG));
        include plugin_dir_path(__FILE__) . 'partials/builder-2d.php';
    }


    public function add_2d_builder_script() {
        wp_enqueue_script('2b-builder-script', plugin_dir_url(__FILE__) . 'builder-2d.js', array(), null, true);
    }

    public function add_tailwind() {
        wp_enqueue_style('tailwind-css', 'https://cdn.jsdelivr.net/npm/tailwindcss@2.0.4/dist/tailwind.min.css');
    }


    public function add_htmlx()
    {
        wp_enqueue_script('add_htmlx', 'https://unpkg.com/htmx.org@1.9.12', array(), null, true);
    }

    public function add_alphine_js()
    {
        wp_enqueue_script('alphine-js', 'https://cdn.jsdelivr.net/npm/alpinejs@3', array(), null, true);
    }


    public function process_2d_builder_script($tag, $handle, $src)
    {
        if($handle == '2b-builder-script') {
            $tag = '<script type="module" src="' . esc_url($src) . '"></script>';
        }
        if(isset($_GET['page']) && $_GET['page'] !== 'create_template') {
            if (in_array($handle, ['2b-builder-script', 'alphine-js'])) {
                return '';
            }
            return $tag;
        }
        return $tag;

    }

    public function process_2d_builder_styles($tag, $handle, $src)
    {
        if(isset($_GET['page']) && $_GET['page'] != 'create_template' &&  in_array($handle, ['tailwind-css'])) {
            return '';
        }
        return $tag;
    }
    public function add_submenu()
    {
        $submenu = array(
            'page_title' => __( 'CreateTemplates', 'Templates' ),
            'menu_title' =>__( 'Create Templates', 'Templates' ),
            'capability' => 'manage_options',
            'menu_slug' => 'create_template',
            'callback'   => array($this, 'templates'),
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