<?php

namespace FictiveCodes;

require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class LayersListingHelper extends \WP_List_Table
{

    public function __construct()
    {
        parent::__construct(
            array(
                'singular' => 'layer',
                'plural' => 'layers',
                'ajax' => false
            )
        );
    }

    public function get_columns()
    {
        return array(
            'cb' => '<input type="checkbox"/>',
            'name' => __('Name', 'name'),
            'file_url' => __('File', 'file_url'),
            'color' => __('Color', 'color'),
            'allow_pattern' => __('Allow Pattern', 'allow_pattern'),
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
            'page' => DESIGN_LAYERS_SLUG,
            'action' => 'edit',
            'layer' => $item['ID'],
            'design' => $item['design_id']
        );
        return add_query_arg($edit_params, admin_url('admin.php'));
    }

    protected function column_default($item, $column_name)
    {
        return isset($item[$column_name]) ? $item[$column_name] : '';
    }

    protected function column_allow_pattern($item)
    {
        if ($item['allow_pattern']) {
            return __('Yes', 'text_domain');
        } else {
            return __('No', 'text_domain');
        }
    }

    public function prepare_items()
    {
        $columns = $this->get_columns();
        $hidden = array();
        $primary = 'name';
        $this->_column_headers = array($columns, $hidden, $primary);
        $this->items = $this->get_layers_data();
    }

    public function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="%1$s_ID[]" value="%2$s" />',
            esc_attr($this->_args['singular']),
            esc_attr($item['name'])
        );
    }

    private function get_layers_data()
    {
        global $wpdb;
        $table_name = FICTIVE_TABLE . 'design_layers';
        $design_id = $_GET['design'];
        $query = "SELECT * from $table_name WHERE `design_id` = $design_id";
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }
}
