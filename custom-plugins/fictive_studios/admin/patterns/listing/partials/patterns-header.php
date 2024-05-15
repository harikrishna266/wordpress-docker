<?php
function createUrl()
{
    $edit_params = array(
        'page' => PATTERNS_BUILDER_SLUG,
        'action' => 'create',
    );
    return add_query_arg($edit_params, admin_url('admin.php'));
}

$url = createUrl();

?>

<div class="wrap">
    <h2>
        <?php esc_html_e('Patterns'); ?>
        <?php
        echo '  <a id="create-print-area" class="button-secondary" href=' . esc_url($url) . '>Add Patterns</a>'
            ?>
    </h2>
    <div id="all-print-areas">
        <?php
        $patterns_table->prepare_items();
        $patterns_table->display();
        ?>
    </div>
</div>