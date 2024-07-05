<?php

class ManageIsCustomizableField
{

    public function __construct()
    {
        add_action('woocommerce_product_options_general_product_data', [$this, 'register_is_customizable_field']);
        add_action('woocommerce_process_product_meta', [$this, 'save_is_customizable_field']);
        add_action('woocommerce_single_product_summary', [$this, 'display_is_customizable_field']);
    }
    function register_is_customizable_field()
    {
        woocommerce_wp_checkbox(
            array(
                'id' => IS_CUSTOMIZABLE,
                'label' => __('Is Customizable?', 'woocommerce'),
                'description' => __('Check this box if the product is customizable.', 'woocommerce'),
            )
        );
    }

    function save_is_customizable_field($post_id)
    {
        $is_customizable = isset($_POST[IS_CUSTOMIZABLE]) ? 'yes' : 'no';
        update_post_meta($post_id, IS_CUSTOMIZABLE, $is_customizable);
    }

    function display_is_customizable_field()
    {
        global $post;
        $BUILDER_URL = BUILDER_URL;
        $is_customizable = get_post_meta($post->ID, IS_CUSTOMIZABLE, true);
        if ($is_customizable === 'yes') {
            echo <<<EOD
                <div class="custom-field">
                    <h2>Customizable:</h2>
                    <button class="button" onclick="loadBuilder()">Customize Product</button>
                </div>
                <style>
                    #modal-3d {
                        background: black;
                        position: absolute;
                        width: 100vw;
                        height: 100vh;
                        position: absolute;
                        top: 0;
                        left: 0;
                        right: 0;
                        bottom: 0;
                    }

                </style>
                <script>
                    function loadBuilder() {
                        const builderHolder = document.createElement( 'div' );
                        builderHolder.setAttribute('id', "modal-3d");
                        builderHolder.style.zIndex = 100001;
                        document.body.appendChild( builderHolder);
                        document.body.scrollTop = document.documentElement.scrollTop = 0;
                        document.body.style.overflow = 'hidden';
                        const appBuilder = document.createElement('app-root');
                        appBuilder.setAttribute('model', 'model url goes here');
                        builderHolder.appendChild(appBuilder);
                    }
                </script>
                <script src="{$BUILDER_URL}polyfills.js" defer type="module"></script>
                <script src="{$BUILDER_URL}main.js" defer type="module"></script>
                EOD;
        }
    }
}


