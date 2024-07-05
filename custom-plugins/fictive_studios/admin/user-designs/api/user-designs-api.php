<?php

class UserDesignsAPIAdmin
{

    public function create_user_product()
    {
        $design_data = json_decode(file_get_contents('php://input'), true);
        $design_name = sanitize_text_field($design_data['name']);
        $serialized_data = sanitize_text_field($design_data['serialized_data']);
        $product = new WC_Product_Simple();
        $product->set_name($design_name);
        $product->set_status('publish');
        $product->set_price(19.99);
        $product->update_meta_data(IS_CUSTOMIZABLE, 'yes');
        $product->update_meta_data(DESIGN_SERIALIZED_DATA, $serialized_data);
        $product->save();
        wp_die();
    }
 
    public function update_user_product()
    {
        $product_id = isset($_GET['id']) ? sanitize_text_field($_POST['id']) : '';
        $serialized_data = isset($_POST[DESIGN_SERIALIZED_DATA]) ? sanitize_text_field($_POST[DESIGN_SERIALIZED_DATA]) : '';
        update_post_meta($product_id, IS_CUSTOMIZABLE, 'yes');
        update_post_meta($product_id, DESIGN_SERIALIZED_DATA, $serialized_data);
        wp_die();
    }
}
