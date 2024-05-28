<?php

function createUrl()
{
    $edit_params = array(
        'page' => 'fashion_designs_builder',
        'action' => 'create',
    );
    return add_query_arg($edit_params, admin_url('admin.php'));
}

$url = createUrl();

?>

<div class="wrap">
    <h2>
        <?php esc_html_e('Design', 'admin-table-tut'); ?>
        <?php
        echo '  <a id="create-design" class="button-secondary" href=' . esc_url($url) . '>Add Design</a>'
            ?>
    </h2>
    <?php
    $fashion_design_table->prepare_items();
    $fashion_design_table->display();
    ?>
</div>