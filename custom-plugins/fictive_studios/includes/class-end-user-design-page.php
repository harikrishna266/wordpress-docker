<?php

class EndUserDesignPage
{

    public function __construct()
    {
        add_filter('woocommerce_account_menu_items', [$this, 'add_user_design_tab']);
        add_action('init', [$this, 'add_user_design_endpoint']);
        add_action('woocommerce_account_designs-by-you_endpoint', [$this, 'designs_by_you_content']);
        register_activation_hook(__FILE__, [$this, 'flush_rewrite_rules']);
        register_deactivation_hook(__FILE__, [$this, 'flush_rewrite_rules']);
    }

    public function add_user_design_tab($items)
    {
        $new_items = array_slice($items, 0, 1, true) +
            array('designs-by-you' => 'Designs By You') +
            array_slice($items, 1, null, true);
        return $new_items;
    }

    public function add_user_design_endpoint()
    {
        add_rewrite_endpoint('designs-by-you', EP_ROOT | EP_PAGES);
    }

    public function designs_by_you_content() {
        echo '<h3>Designs By You</h3>';
    
        $current_user_id = get_current_user_id();
        $args = array(
            'post_type'      => 'product',
            'posts_per_page' => -1,
            'author'         => $current_user_id,
            'meta_query'     => array(
                array(
                    'key'   => IS_PRIVATE,
                    'value' => 'yes',
                ),
            ),
        );
        $products = new WP_Query($args);
    
        if ($products->have_posts()) {
            echo '<ul class="products">';
            while ($products->have_posts()) {
                $products->the_post();
                wc_get_template_part('content', 'product');
            }
            echo '</ul>';
        } else {
            echo '<p>No private custom designs found.</p>';
        }
        wp_reset_postdata();
    }
    

    public function flush_rewrite_rules()
    {
        flush_rewrite_rules();
    }
}
