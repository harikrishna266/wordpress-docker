<?php

function register_is_customizable_field() {
     woocommerce_wp_checkbox(
        array(
            'id' => '_is_customizable',
            'label' => __('Is Customizable?', 'woocommerce'),
            'description' => __('Check this box if the product is customizable.', 'woocommerce'),
        )
    );
}

 function save_is_customizable_field($post_id) {
    $is_customizable = isset($_POST['_is_customizable']) ? 'yes' : 'no';
    update_post_meta($post_id, '_is_customizable', $is_customizable);
}

function display_is_customizable_field() {
    global $post;
    $is_customizable = get_post_meta($post->ID, '_is_customizable', true);
    if ($is_customizable === 'yes') {
        echo '<div class="custom-field">';
        echo '<h2>' . __('Customizable:', 'woocommerce') . '</h2>';
        echo '<p>' . __('This product is customizable.', 'woocommerce') . '</p>';
        echo '</div>';
    }
}


function exclude_customizable_products($q) {
    if (isset($q->query['post_type']) && $q->query['post_type'] === 'product') {
        $meta_query = $q->get('meta_query');
        if (!is_array($meta_query)) {
            $meta_query = array();
        }
        $meta_query[] = array(
            'relation' => 'OR',
            array(
                'key' => '_is_customizable',
                'value' => 'no',
                'compare' => '='
            ),
            array(
                'key' => '_is_customizable',
                'value' => 'no',
                'compare' => 'NOT EXISTS'
            ),
            array(
                'relation' => 'AND',
                array(
                    'key' => '_is_customizable',
                    'value' => 'true',
                    'compare' => '=' // Check if _is_customizable is true
                ),
                array(
                    'taxonomy' => 'product_visibility',
                    'field'    => 'name',
                    'terms'    => array( 'exclude-from-search', 'exclude-from-catalog' ),
                    'operator' => 'NOT IN'
                ),
            ),
        );
        $q->set('meta_query', $meta_query);
    }
}

add_action('pre_get_posts', 'exclude_customizable_products');
add_action('woocommerce_product_options_general_product_data', 'register_is_customizable_field');
add_action('woocommerce_process_product_meta', 'save_is_customizable_field');
add_action('woocommerce_single_product_summary', 'display_is_customizable_field');
