<?php

namespace FictiveCodes;

require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class FashionDesignListingHelper extends \WP_List_Table
{

    public function __construct()
    {
        parent::__construct(
            array(
                'singular' => 'fashion_design',
                'plural' => 'fashion_designs',
                'ajax' => false
            )
        );
    }

    public function get_columns()
    {
        return array(
            'cb' => '<input type="checkbox"/>',
            'name' => __('Name', 'name'),
            'no_of_layers' => __('No of Layer', 'no_of_layers'),
            'view_layers' => __('View Layers', 'view_layers'),
        );
    }

    public function column_name($item)
    {
        $output = '<strong>';
        $output .= '<a>' . esc_html($item['name']) . '</a>';
        $output .= '</strong>';

        $actions = array(
            'id' => '<a id="' . esc_attr('id-' . $item['ID']) . '>' . 'ID:' . __($item['ID']) . '</a>',
            'edit' => '<a id="' . esc_attr('edit-' . $item['ID']) . '" href="' . esc_url($this->getEditQueryArguments($item)) . '">' . __('Edit') . '</a>',
        );
        $row_actions = array();
        foreach ($actions as $action => $link) {
            $row_actions[] = '<span class="' . esc_attr($action) . '">' . $link . '</span>';
        }
        $output .= '<div class="row-actions">' . implode(' | ', $row_actions) . '</div>';
        return $output;
    }

    public function column_no_of_layers($item)
    {
        global $wpdb;

        if (isset($item['ID'])) {
            $table_name = FICTIVE_TABLE . 'design_layers';
            $design_id = intval($item['ID']);
            $query = $wpdb->prepare(
                "SELECT COUNT(*) FROM $table_name WHERE design_id = %d",
                $design_id
            );
            $count = $wpdb->get_var($query);
            return $count;
        } else {
            return 0;
        }
    }

    public function column_view_layers($item)
    {
        $view_page = esc_url(add_query_arg(array('design' => $item['ID']), admin_url('admin.php?page=' . DESIGN_LAYERS_SLUG)));
        $actions = '<a href="' . $view_page . '"class="dashicons dashicons-visibility"></a>';
        return $actions;
    }

    private function getEditQueryArguments($item): string
    {
        $edit_params = array(
            'page' => FASHION_DESIGNS_BUILDER_SLUG,
            'action' => 'edit',
            'design' => $item['ID']
        );
        return add_query_arg($edit_params, admin_url('admin.php'));
    }

    public function get_sortable_columns()
    {
        return array(
            'name' => array('name', false),
        );
    }

    protected function column_default($item, $column_name)
    {
        return isset($item[$column_name]) ? $item[$column_name] : '';
    }


    public function prepare_items()
    {
        $columns = $this->get_columns();
        $sortable = $this->get_sortable_columns();
        $hidden = array();
        $primary = 'name';
        $this->_column_headers = array($columns, $hidden, $sortable, $primary);
        $this->items = $this->get_fashion_designs_data();
    }

    private function get_fashion_designs_data()
    {
        global $wpdb;
        $table_name = FICTIVE_TABLE . 'fashion_designs';
        $query = "SELECT * FROM $table_name";
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }
}
