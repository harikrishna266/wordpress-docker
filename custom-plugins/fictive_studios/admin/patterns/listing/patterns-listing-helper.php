<?php
namespace FictiveCodes;

require_once (ABSPATH . 'wp-admin/includes/class-wp-list-table.php');

class PatternsListingHelper extends \WP_List_Table
{

    public function __construct()
    {
        parent::__construct(
            array(
                'singular' => 'pattern',
                'plural' => 'patterns',
                'ajax' => false
            )
        );
    }

    public function get_columns()
    {
        return array(
            'cb' => '<input type="checkbox"/>',
            'thumbnail' => __('Image', 'thumbnail'),
            'name' => __('Name', 'name'),
        );
    }

    public function get_sortable_columns()
    {
        return array(
            'name' => array('name', false),
        );
    }

    protected function column_thumbnail($item)
    {
        $thumbnail_url = isset($item['pattern_image']) ? esc_url($item['pattern_image']) : '';
        if ($thumbnail_url) {
            return '<img src="' . $thumbnail_url . '" alt="' . esc_attr($item['name']) . '" style="width: 50px; height: auto;"/>';
        } else {
            return __('No Thumbnail', 'text_domain');
        }
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
        $this->items = $this->get_patterns_data();
    }

    private function get_patterns_data()
    {
        global $wpdb;
        $patterns_table = FICTIVE_TABLE . 'patterns';
        $query = "SELECT * from $patterns_table";
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }


}