<?php

function createUrl()
{
    $model_id = $_GET['model'];
    $edit_params = array(
        'page' => 'model_print_areas',
        'action' => 'create',
        'model' => $model_id
    );
    return add_query_arg($edit_params, admin_url('admin.php'));
}

$url = createUrl();

?>

<div class="wrap">
    <h2>
        <?php esc_html_e('Models' . '/' . $model_data['name'] . '/' . 'Print Areas'); ?>
        <?php
        echo '  <a id="create-print-area" class="button-secondary" href=' . esc_url($url) . '>Add Print Area</a>'
            ?>
    </h2>
    <form id="all-drafts" method="get">
        <input type="hidden" name="page" value="brocha-template" />
        <?php
        $model_print_area_table->prepare_items();
        $model_print_area_table->display();
        ?>
    </form>
</div>