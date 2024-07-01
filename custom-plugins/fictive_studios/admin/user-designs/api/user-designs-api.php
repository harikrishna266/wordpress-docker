<?php

class UserDesignsAPIAdmin
{

    public function create_user_product()
    {
        $serialized_data = isset($_POST['serialized_data']) ? sanitize_text_field($_POST['serialized_data']) : '';
        $product = new WC_Product_Simple();
        $product->set_name('Product1');
        $product->set_status('publish');
        $product->set_price(19.99);
        $product->update_meta_data('_is_customizable', 'yes');
        $product->update_meta_data('_serialized_data', $serialized_data);
        $product->save();
        wp_die();
    }

    public function update_user_product()
    {
        $product_id = isset($_GET['id']) ? sanitize_text_field($_POST['id']) : '';
        $serialized_data = isset($_POST['serialized_data']) ? sanitize_text_field($_POST['serialized_data']) : '';
        update_post_meta($product_id, '_is_customizable', $serialized_data);
        wp_die();
    }
}
