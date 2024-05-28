<?php
namespace FictiveCodes;

require_once (ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

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
            'design_layer_1' => __('Layer 1', 'design_layer_1'),
            'design_layer_2' => __('Layer 2', 'design_layer_2'),
            'design_layer_3' => __('Layer 3', 'design_layer_3'),
            'design_layer_4' => __('Layer 4', 'design_layer_4'),
            'design_layer_5' => __('Layer 5', 'design_layer_5'),
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

    private function getEditQueryArguments($item): string
    {
        $edit_params = array(
            'page' => FASHION_DESIGNS_BUILDER_SLUG,
            'action' => 'edit',
            'design' => $item['ID']
        );
        return add_query_arg($edit_params, admin_url('admin.php'));
    }

    function column_design_layer_1($item)
    {
        $actions = !empty($item['design_layer_1']) ? '<a href="' . esc_url($item['design_layer_1']) . '" class="dashicons dashicons-visibility" target="_blank"></a>' : '--';
        return $actions;
    }

    function column_design_layer_2($item)
    {
        $actions = !empty($item['design_layer_2']) ? '<a href="' . esc_url($item['design_layer_2']) . '" class="dashicons dashicons-visibility" target="_blank"></a>' : '--';
        return $actions;
    }

    function column_design_layer_3($item)
    {
        $actions = !empty($item['design_layer_3']) ? '<a href="' . esc_url($item['design_layer_3']) . '" class="dashicons dashicons-visibility" target="_blank"></a>' : '--';
        return $actions;
    }

    function column_design_layer_4($item)
    {
        $actions = !empty($item['design_layer_4']) ? '<a href="' . esc_url($item['design_layer_4']) . '" class="dashicons dashicons-visibility" target="_blank"></a>' : '--';
        return $actions;
    }

    function column_design_layer_5($item)
    {
        $actions = !empty($item['design_layer_5']) ? '<a href="' . esc_url($item['design_layer_5']) . '" class="dashicons dashicons-visibility" target="_blank"></a>' : '--';
        return $actions;
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
        $table_name = $wpdb->prefix . 'fashion_designs';
        $query = "SELECT * FROM $table_name";
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }


}