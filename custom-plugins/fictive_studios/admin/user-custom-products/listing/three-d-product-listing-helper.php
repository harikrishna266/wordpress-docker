<?php
namespace FictiveCodes;

require_once (ABSPATH . 'wp-admin/includes/class-wp-list-table.php');


class ThreeDProductListingHelper extends \WP_List_Table
{

    public function __construct()
    {
        parent::__construct(
            array(
                'singular' => 'products',
                'plural' => 'products',
                'ajax' => false
            )
        );
    }

    public function get_columns()
    {
        return array(
            'cb' => '<input type="checkbox"/>',
            'thumbnail' => __('Thumbnail', 'thumbnail'),
            'name' => __('Name', 'name'),
            'sku' => __('SKU', 'sku'),
            'price' => __('Price', 'price'),
            'categories' => __('Categories', 'categories'),
            'tags' => __('Tags', 'tags'),
            'date' => __('Date', 'date'),
        );
    }

    protected function column_default($item, $column_name)
    {
        return isset($item[$column_name]) ? $item[$column_name] : '';
    }

    protected function column_categories($item)
    {
        $categories = '';
        foreach ($item['categories'] as $category) {
            $categories .= $category . ', ';
        }
        return rtrim($categories, ', ');
    }

    protected function column_tags($item)
    {
        $tags = '';
        foreach ($item['tags'] as $tag) {
            $tags .= $tag . ', ';
        }
        return rtrim($tags, ', ');
    }


    protected function column_thumbnail($item)
    {
        $thumbnail_url = isset($item['thumbnail']) ? esc_url($item['thumbnail']) : '';
        if ($thumbnail_url) {
            return '<img src="' . $thumbnail_url . '" alt="' . esc_attr($item['name']) . '" style="width: 50px; height: auto;"/>';
        } else {
            return __('No Thumbnail', 'text_domain');
        }
    }

    public function column_name($item)
    {
        $output = '<strong>';
        $output .= '<a>' . esc_html($item['name']) . '</a>';
        $output .= '</strong>';

        $actions = array(
            'id' => '<a id="' . esc_attr('id-' . $item['id']) . '>' . 'ID:' . __($item['id']) . '</a>',
            'edit' => '<a id="' . esc_attr('edit-' . $item['id']) . '" href="' . esc_url($this->getEditQueryArguments($item)) . '">' . __('Edit') . '</a>',
            'view' => '<a id="' . esc_attr('view-' . $item['id']) . '" href="' . esc_url('/?product=' . $item['name']) . '">' . __('View') . '</a>',
            'delete' => '<a id="' . esc_attr('delete-' . $item['id']) . '">' . __('Trash') . '</a>',
        );
        $row_actions = array();
        foreach ($actions as $action => $link) {
            $row_actions[] = '<span class="' . esc_attr($action) . '">' . $link . '</span>';
        }
        $output .= '<div class="row-actions">' . implode(' | ', $row_actions) . '</div>';
        return $output;
    }

    private function getEditQueryArguments($item): string
    {
        $edit_params = array(
            'action' => 'edit',
            'post' => $item['id']
        );
        return add_query_arg($edit_params, admin_url('post.php'));
    }

    private function getViewQueryArguments($item)
    {
        if (isset($_GET['custom_redirect']) && $_GET['custom_redirect'] === 'yes' && isset($_GET['post'])) {
            $post_id = $item['id'];
            if (get_post_type($post_id) === 'product') {
                $product_url = get_permalink($post_id);

                wp_redirect($product_url);
                exit;
            }
        }
    }



    public function prepare_items()
    {
        $columns = $this->get_columns();
        $primary = 'name';
        $sortable = array();
        $hidden = array();
        $this->_column_headers = array($columns, $hidden, $sortable, $primary);
        $this->items = $this->get_custom_product_data_data();
    }

    public function get_custom_product_data_data()
    {
        $products = wc_get_products(array('customvar' => 'yes', 'limit' => 100, ));
        $data = [];
        foreach ($products as $product) {
            $thumbnail_id = $product->get_image_id();
            $thumbnail_url = wp_get_attachment_image_url($thumbnail_id, 'thumbnail');

            $category_ids = $product->get_category_ids();
            $categories = array();
            foreach ($category_ids as $category_id) {
                $category = get_term_by('id', $category_id, 'product_cat');
                if ($category) {
                    $categories[] = $category->name;
                }
            }

            $tag_ids = $product->get_tag_ids();
            $tags = array();
            foreach ($tag_ids as $tag_id) {
                $tag = get_term_by('id', $tag_id, 'product_tag');
                if ($tag) {
                    $tags[] = $tag->name;
                }
            }

            $data[] = array(
                'id' => $product->get_id(),
                'thumbnail' => $thumbnail_url,
                'name' => $product->get_name(),
                'price' => wc_price($product->get_price()),
                'sku' => $product->get_sku(),
                'date' => $product->get_date_created()->date('Y-m-d H:i:s'),
                'status' => $product->get_status(),
                'categories' => $categories,
                'tags' => $tags
            );
        }
        return $data;
    }

}