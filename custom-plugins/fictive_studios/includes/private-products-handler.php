<?php

class PrivateProductsHandler
{
    public function __construct()
    {
        add_filter('woocommerce_product_data_store_cpt_get_products_query', [$this, 'handle_private_product_query'], 10, 2);
        add_action('woocommerce_product_options_general_product_data', [$this, 'register_is_private_product_field']);
        add_action('woocommerce_single_product_summary', [$this, 'display_is_private_product_field'], 20);
        add_action('woocommerce_process_product_meta', [$this, 'save_is_private_product_field']);
    }

    public function handle_private_product_query($query, $query_vars)
    {
        if (!empty($query_vars['customvar'])) {
            $query['meta_query'][] = array(
                'key' => '_is_private_product',
                'value' => esc_attr($query_vars['customvar']),
                'compare' => '='
            );
        }
        return $query;
    }

    public function register_is_private_product_field()
    {
        woocommerce_wp_checkbox(
            array(
                'id' => '_is_private_product',
                'label' => __('Is Private?', 'woocommerce'),
                'description' => __('Check this box if the product is private.', 'woocommerce'),
            )
        );
    }

    public function save_is_private_product_field($post_id)
    {
        $is_private_product = isset($_POST['_is_private_product']) ? 'yes' : 'no';
        update_post_meta($post_id, '_is_private_product', $is_private_product);
    }

    public function display_is_private_product_field()
    {
        global $post;
        $is_private_product = get_post_meta($post->ID, '_is_private_product', true);
        if ($is_private_product === 'yes') {
            echo '<div class="custom-field">';
            echo '<h2>' . __('Private Product:', 'woocommerce') . '</h2>';
            echo '<p>' . __('This product is private.', 'woocommerce') . '</p>';
            echo '</div>';
        }
    }
}
