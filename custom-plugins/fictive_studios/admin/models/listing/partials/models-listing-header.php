<?php

function createUrl()
{
    $edit_params = array(
        'page' => 'models_builder',
        'action' => 'create',
    );
    return add_query_arg($edit_params, admin_url('admin.php'));
}

$url = createUrl();

?>

<div class="wrap">
    <h2>
        <?php esc_html_e('Models'); ?>
        <?php
        echo '  <a id="create-print-area" class="button-secondary" href=' . esc_url($url) . '>Add New Model</a>'
            ?>
    </h2>
    <form id="all-drafts" method="get">
        <input type="hidden" name="page" value="brocha-template" />
        <?php
        $models_table->prepare_items();
        $models_table->display();
        ?>
    </form>
</div>