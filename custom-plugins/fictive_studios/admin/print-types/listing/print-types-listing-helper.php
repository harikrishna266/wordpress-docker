<?php
namespace FictiveCodes;

require_once (ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class PrintTypesHelper extends \WP_List_Table
{

    public function __construct()
    {
        parent::__construct(
            array(
                'singular' => 'print_type',
                'plural' => 'print_types',
                'ajax' => false
            )
        );
    }

    public function get_columns()
    {
        return array(
            'cb' => '<input type="checkbox"/>',
            'name' => __('Name', 'name'),
            'link' => __('Link', 'link'),
        );
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
            'page' => PRINT_TYPES_BUILDER_SLUG,
            'action' => 'edit',
            'print_type' => $item['ID']
        );
        return add_query_arg($edit_params, admin_url('admin.php'));
    }

    function column_link($item)
    {
        $actions = !empty($item['link']) ? '<a href="' . esc_url($item['link']) . '" class="dashicons dashicons-visibility" target="_blank"></a>' : '--';
        return $actions;
    }


    public function prepare_items()
    {
        $columns = $this->get_columns();
        $sortable = $this->get_sortable_columns();
        $hidden = array();
        $primary = 'name';
        $this->_column_headers = array($columns, $hidden, $sortable, $primary);
        $this->items = $this->get_print_types_data('');
    }

    private function get_print_types_data($search_term = '')
    {
        global $wpdb;
        $table_name = FICTIVE_TABLE . 'print_types';
        $query = "SELECT * FROM $table_name";
        if ($search_term) {
            $search_term_like = '%' . $wpdb->esc_like($search_term) . '%';
            $query = $wpdb->prepare("SELECT * FROM $table_name WHERE name LIKE %s", $search_term_like);
        }
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }


}