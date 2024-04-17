<?php

if(!class_exists('WP_List_Table')){
    require_once( ABSPATH . 'wp-admin/includes/screen.php' );
    require_once( ABSPATH . 'wp-admin/includes/class-wp-list-table.php' );
}

class Template_List_Table extends \WP_List_Table
{

    public function __construct()
    {
        parent::__construct(
            array(
                'singular' => 'Draft',
                'plural' => 'Drafts',
                'ajax' => false,
            )
        );
    }

    protected function get_brocha_templates($search_term = null)
    {
        global $wpdb;
        $table_name = $wpdb->prefix . 'brocha_templates';
        $query = "SELECT * FROM $table_name";
        if ($search_term) {
            $query = $wpdb->prepare("SELECT * FROM $table_name WHERE name LIKE %s", '%' . $wpdb->esc_like($search_term) . '%');
        } else {
            $query = "SELECT * FROM $table_name";
        }
        $results = $wpdb->get_results($query, ARRAY_A);
        return $results;
    }

    public function no_items()
    {
        esc_html_e('No templates found.', 'admin-table-tut');
    }


    public function get_columns()
    {
        return array(
            'cb' => '<input type="checkbox"/>',
            'col_temp_name' => __('Name', 'admin-table-tut'),
        );
    }

    public function column_col_temp_name($item)
    {
        $edit_url = get_edit_post_link($item['ID']);
        $post_link = get_permalink($item['ID']);
        $output = '<strong>';
        $output .= '<a class="row-col_temp_name" href="' . esc_url($edit_url) . '" aria-label="' . sprintf(__('%s (Edit)', 'admin-table-tut'), $item['name']) . '">' . esc_html($item['name']) . '</a>';
        // $output .= _post_states(get_post($item['ID']), false);
        $output .= '</strong>';
        $actions = array(
            'edit' => '<a href="' . esc_url(admin_url('admin.php?page=builder-2d&template_id=' . $item['ID'])) . '">' . __('Edit', 'admin-table-tut') . '</a>',
            'trash' => '<a href="' . esc_url(get_delete_post_link($item['ID'])) . '" class="submitdelete">' . __('Trash', 'admin-table-tut') . '</a>',
            'view' => '<a href="' . esc_url(admin_url('admin.php?page=builder-2d&template_id=' . $item['ID'])) . '">' . __('View', 'admin-table-tut') . '</a>',
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
            esc_attr($item['ID'])
        );
    }

    public function prepare_items()
    {
        $columns = $this->get_columns();
        $sortable = $this->get_sortable_columns();
        $hIdden = array();
        $primary = 'name';
        $this->_column_headers = array($columns, $hIdden, $sortable, $primary);
        $search_term = filter_input(INPUT_GET, 's', FILTER_UNSAFE_RAW);
        $data = $this->get_brocha_templates($search_term);
        $this->process_bulk_action();
        $this->items = $data;
    }

    public function get_bulk_actions()
    {
        return array(
            'trash' => __('Move to Trash', 'admin-table-tut'),
        );
    }

    public function process_bulk_action()
    {
        if ('trash' === $this->current_action()) {
            $post_IDs = filter_input(INPUT_GET, 'draft_ID', FILTER_DEFAULT, FILTER_REQUIRE_ARRAY);
            if (is_array($post_IDs)) {
                $post_IDs = array_map('intval', $post_IDs);
                if (count($post_IDs)) {
                    array_map('wp_trash_post', $post_IDs);
                }
            }
        }
    }

    protected function display_tablenav($which)
    {
        ?>
        <div class="tablenav <?php echo esc_attr($which); ?>">

            <?php if ($this->has_items()): ?>
                <div class="alignleft actions bulkactions">
                    <?php $this->bulk_actions($which); ?>
                </div>
            <?php
            endif;
            $this->extra_tablenav($which);
            $this->pagination($which);
            ?>

            <br class="clear" />
        </div>
        <?php
    }

    protected function extra_tablenav($which)
    {
        if ('top' === $which) {
            $drafts_dropdown_arg = array(
                'options' => array('' => 'All'),
                'container' => array(
                    'class' => 'alignleft actions',
                ),
                'label' => array(
                    'class' => 'screen-reader-text',
                    'inner_text' => __('Filter by Post Type', 'admin-table-tut'),
                ),
                'select' => array(
                    'name' => 'type',
                    'ID' => 'filter-by-type',
                    'selected' => filter_input(INPUT_GET, 'type', 513),
                ),
            );

            $this->html_dropdown($drafts_dropdown_arg);

            submit_button(__('Filter', 'admin-table-tut'), 'secondary', 'action', false);
        }
    }

    private function html_dropdown($args)
    {
        ?>
        <div class="<?php echo (esc_attr($args['container']['class'])); ?>">
            <label for="<?php echo (esc_attr($args['select']['ID'])); ?>"
                   class="<?php echo (esc_attr($args['label']['class'])); ?>">
            </label>
            <select name="<?php echo (esc_attr($args['select']['name'])); ?>"
                    ID="<?php echo (esc_attr($args['select']['ID'])); ?>">
                <?php
                foreach ($args['options'] as $ID => $title) {
                    ?>
                    <option <?php if ($args['select']['selected'] === $ID) { ?> selected="selected" <?php } ?>
                        value="<?php echo (esc_attr($ID)); ?>">
                        <?php echo esc_html(\ucwords($title)); ?>
                    </option>
                    <?php
                }
                ?>
            </select>
        </div>
        <?php
    }

    public function get_sortable_columns()
    {
        return array(
            'col_template_name' => array('col_template_name', false),
        );
    }
}