<?php
function createUrl()
{
    $edit_params = array(
        'page' => PRINT_TYPES_BUILDER_SLUG,
        'action' => 'create',
    );
    return add_query_arg($edit_params, admin_url('admin.php'));
}

$url = createUrl();

?>

<div class="wrap">
    <h2>
        <?php esc_html_e('Print Types'); ?>
        <?php
        echo '  <a id="create-print-types" class="button-secondary" href=' . esc_url($url) . '>Add New Print Types</a>'
            ?>
    </h2>
    <?php
    $print_types_table->prepare_items();
    $print_types_table->display();
    ?>
</div>