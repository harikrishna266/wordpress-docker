<?php

class WooProductFilter
{

    public function __construct()
    {
        add_action('pre_get_posts', [$this, 'exclude_customizable_products']);
    }

    public function exclude_customizable_products($query)
    {
        if (isset($_GET['page']) && $_GET['page'] === 'User_custom_Products') {
            return;
        }
        if (isset($_GET['post_type']) && $_GET['post_type'] === 'product') {
            if (isset($query->query['post_type']) && $query->query['post_type'] === 'product') {
                $meta_query = $query->get('meta_query');
                if (!is_array($meta_query)) {
                    $meta_query = array();
                }
                $meta_query[] = array(
                    'relation' => 'OR',
                    array(
                        'key' => '_is_private_product',
                        'value' => 'no',
                        'compare' => '='
                    ),
                    array(
                        'key' => '_is_private_product',
                        'compare' => 'NOT EXISTS'
                    )
                );
                $query->set('meta_query', $meta_query);
            }
        }
    }
}