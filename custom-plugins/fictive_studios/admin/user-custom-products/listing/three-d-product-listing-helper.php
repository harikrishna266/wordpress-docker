<?php
namespace FictiveCodes;

require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');


class ThreeDProductListingHelper extends \WP_List_Table
{


    public function __construct()
    {
        parent::__construct(array(
            'singular' => 'products',
            'plural' => 'products',
            'ajax' => false
        ));


    }

    function get_columns() {
        return array(
            'id' => '#',
            'name' => 'Name',
            'price' => 'Price',
            'status' => 'Status'
        );
    }

    public function get_sortable_columns()
    {
        return array(
            'name' => array('name', false),
        );
    }

    protected function column_default( $item, $column_name ) {
        return isset( $item[ $column_name ] ) ? $item[ $column_name ] : '';
    }

    function display_rows() {
        foreach ($this->items as $item) {
            echo '<tr>';
            foreach ($this->get_columns() as $column_name => $column_display_name) {
                echo '<td>' .esc_html($item[$column_name]) . '</td>';
            }
            echo '</tr>';
        }
    }

    public function prepare_items()
    {

        $products = wc_get_products( array( 'customvar' => 'yes' ,     'limit' => 100,) );
        $data = array();
        foreach ($products as $product) {
            $data[] = array(
                'id' => $product->get_id(),
                'name' => $product->get_name(),
                'price' => wc_price($product->get_price()),
                'status' => $product->get_status()
            );
        }
        $this->items = $data;
    }
}