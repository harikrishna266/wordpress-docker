<?php
function createUrl()
{
    $edit_params = array(
        'page' => 'printing_areas_builder',
        'action' => 'create',
    );
    return add_query_arg($edit_params, admin_url('admin.php'));
}

$url = createUrl();

?>

<div class="wrap">
    <h2>
        <?php esc_html_e('Print Areas'); ?>
        <?php
        echo '  <a id="create-print-area" class="button-secondary" href=' . esc_url($url) . '>Add New Print Area</a>'
            ?>
    </h2>
    <div id="all-print-areas">
        <?php
        $print_area_table->prepare_items();
        $print_area_table->display();
        ?>
    </div>
</div>