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

    }
}