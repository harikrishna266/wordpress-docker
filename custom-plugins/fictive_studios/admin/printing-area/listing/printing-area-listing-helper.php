<?php
namespace FictiveCodes;

require_once (ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class PrintAreasListingHelper extends \WP_List_Table
{

    public function __construct()
    {
        parent::__construct(
            array(
                'singular' => 'print_area',
                'plural' => 'print_areas',
                'ajax' => false
            )
        );
    }

    public function get_columns()
    {
        return array(
            'cb' => '<input type="checkbox"/>',
            'col_actions_temp' => __('Height'),
            'width' => __('Width', 'width'),
        );
    }

    protected function column_default($item, $column_name)
    {
        return isset($item[$column_name]) ? $item[$column_name] : '';
    }


    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $primary = 'height';
        $this->_column_headers = array($columns, $hidden, $primary);
        $this->items = $this->get_print_areas_data();
    }

    public function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="%1$s_ID[]" value="%2$s" />',
            esc_attr($this->_args['singular']),
            esc_attr($item['height'])
        );
    }

    public function column_col_actions_temp($item)
    {
        $output = '<strong>';
        $output .= '<a>' . esc_html($item['height']) . '</a>';
        $output .= '</strong>';
        $edit_params = array(
            'page' => 'printing_areas_builder',
            'action' => 'edit',
            'print-area' => $item['ID']
        );
        $url = add_query_arg($edit_params, admin_url('admin.php'));
        $dynamic_id = 'edit-print-area-' . $item['ID'];
        $actions = array(
            'edit' => '<a id="' . esc_attr($dynamic_id) . '" href="'.esc_url($url).'">' . __('Edit') . '</a>',
        );
        $row_actions = array();
        foreach ($actions as $action => $link) {
            $row_actions[] = '<span class="' . esc_attr($action) . '">' . $link . '</span>';
        }
        $output .= '<div class="row-actions">' . implode(' | ', $row_actions) . '</div>';
        return $output;
    }

    private function get_print_areas_data()
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'print_areas';
        $query = "SELECT * FROM $table_name";
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }


}