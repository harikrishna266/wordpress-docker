<div class="wrap">
     <h2>
        <?php esc_html_e('Template List', 'admin-table-tut'); ?>
        <a id="editor2d" class="button-secondary" href="<?php echo $link_url; ?>" target="_blank">Open Template Editor</a>
    </h2>
    <form id="all-drafts" method="get">
        <input type="hidden" name="page" value="brocha-template" />
        <?php
            $template_table->prepare_items();
            $template_table->display();
        ?>
    </form>
</div>