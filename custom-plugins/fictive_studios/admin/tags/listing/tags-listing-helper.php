<?php

namespace FictiveCodes;

require_once(ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class TagsListingHelper extends \WP_List_Table
{


    public function __construct()
    {
        parent::__construct(
            array(
                'singular' => 'tag',
                'plural' => 'tags',
                'ajax' => false
            )
        );
    }

    public function get_columns()
    {
        return array(
            'cb' => '<input type="checkbox"/>',
            'name' => __('Name', 'name'),
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

    public function column_cb($item)
    {
        return sprintf(
            '<input type="checkbox" name="%1$s_ID[]" value="%2$s" />',
            esc_attr($this->_args['singular']),
            esc_attr($item['name'])
        );
    }

    private function getEditQueryArguments($item): string
    {
        $edit_params = array(
            'page' => TAGS_SLUG,
            'action' => 'edit',
            'tag' => $item['ID']
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
        $this->items = $this->get_tags_data();
    }

    private function get_tags_data()
    {
        global $wpdb;
        $table_name = FICTIVE_TABLE . 'tags';
        $query = "SELECT * FROM $table_name";
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }
}
