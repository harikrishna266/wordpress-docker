<?php
function createUrl()
{
    $edit_params = array(
        'page' => TAGS_SLUG,
        'action' => 'create',
    );
    return add_query_arg($edit_params, admin_url('admin.php'));
}

$url = createUrl();

?>

<div class="wrap">
    <h2>
        <?php esc_html_e('Tags'); ?>
        <?php
        echo '  <a id="create-tags" class="button-secondary" href=' . esc_url($url) . '>Add New Tags</a>'
            ?>
    </h2>
    <div id="all-tags">
        <?php
        $tags_table->prepare_items();
        $tags_table->display();
        ?>
    </div>
</div>