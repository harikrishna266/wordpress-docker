<?php

class WooProductAPI
{
    function createWooPrivateProduct()
    {

        $product = new WC_Product_Simple();

        $product->set_name('Wizard');

        $product->set_slug('medium-size-wizard-hat-in-new-york');

        $product->set_regular_price(500.00);

        $product->set_short_description('<p>Here it is... A WIZARD HAT!</p><p>Only here and now.</p>');

        $product->save();


        //alternate method

        // if (!class_exists('WooCommerce')) {
        //     return;
        // }

        // $product_data = array(
        //     'name' => 'Sample Product',
        //     'type' => 'simple',
        //     'regular_price' => '19.99',
        //     'description' => 'This is a sample product description.',
        //     'short_description' => 'This is a short description.',
        //     'sku' => 'sample-sku', // Optional
        //     'manage_stock' => true,
        //     'stock_quantity' => 10,
        //     'status' => 'publish',
        //     'categories' => array(
        //         array(
        //             'id' => 1 // Replace with your category ID
        //         ),
        //     ),
        // );

        // $product_id = wp_insert_post(
        //     array(
        //         'post_title' => $product_data['name'],
        //         'post_content' => $product_data['description'],
        //         'post_status' => $product_data['status'],
        //         'post_type' => 'product',
        //     ));

        // if ($product_id) {
        //     wp_set_object_terms($product_id, $product_data['type'], 'product_type');

        //     update_post_meta($product_id, '_regular_price', $product_data['regular_price']);
        //     update_post_meta($product_id, '_price', $product_data['regular_price']);

        //     update_post_meta($product_id, '_short_description', $product_data['short_description']);

        //     if (!empty($product_data['sku'])) {
        //         update_post_meta($product_id, '_sku', $product_data['sku']);
        //     }

        //     update_post_meta($product_id, '_manage_stock', $product_data['manage_stock'] ? 'yes' : 'no');
        //     update_post_meta($product_id, '_stock', $product_data['stock_quantity']);

        //     wp_set_post_terms($product_id, array($product_data['categories'][0]['id']), 'product_cat');

        // }
    }
}