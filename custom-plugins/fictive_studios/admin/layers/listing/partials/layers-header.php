<?php

function createUrl()
{
    $design_id = $_GET['design'];
    $edit_params = array(
        'page' => 'design_layers',
        'action' => 'create',
        'design' => $design_id
    );
    return add_query_arg($edit_params, admin_url('admin.php'));
}

$url = createUrl();

?>

<div class="wrap">
    <h2>
        <?php esc_html_e('Design' . '/' . $design_data['name'] . '/' . 'Layers'); ?>
        <?php
        echo '  <a id="create-layers" class="button-secondary" href=' . esc_url($url) . '>Add Layers</a>'
        ?>
    </h2>
    <?php
    $layers_table->prepare_items();
    $layers_table->display();
    ?>
</div>