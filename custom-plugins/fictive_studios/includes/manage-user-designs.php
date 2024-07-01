<?php

class ManageIsUserDesigns
{

    public function __construct()
    {
        // add_action('woocommerce_product_options_general_product_data', [$this, 'register_is_customizable_field']);
        add_action('woocommerce_process_product_meta', [$this, 'save_design_serialized_data']);
        // add_action('woocommerce_single_product_summary', [$this, 'display_is_customizable_field']);
    }
    // function register_is_customizable_field()
    // {
    //     woocommerce_wp_checkbox(
    //         array(
    //             'id' => '_is_customizable',
    //             'label' => __('Is Customizable?', 'woocommerce'),
    //             'description' => __('Check this box if the product is customizable.', 'woocommerce'),
    //         )
    //     );
    // }

    function save_design_serialized_data($post_id)
    {
        $serialized_data = isset($_POST['_serialized_data']) ? $_POST['_serialized_data'] : '';
        update_post_meta($post_id, '_serialized_data', $serialized_data);
    }

    // function display_is_customizable_field()
    // {
    //     global $post;
    //     $is_customizable = get_post_meta($post->ID, '_is_customizable', true);
    //     if ($is_customizable === 'yes') {
    //         echo '<div class="custom-field">';
    //         echo '<h2>' . __('Customizable:', 'woocommerce') . '</h2>';
    //         echo '<p>' . __('This product is customizable.', 'woocommerce') . '</p>';
    //         echo '</div>';
    //     }
    // }
}
