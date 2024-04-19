<div class="wrap">
     <h2>
        <?php esc_html_e('Models List', 'admin-table-tut'); ?>
    </h2>
    <form id="all-drafts" method="get">
        <input type="hidden" name="page" value="brocha-template" />
        <?php
            $models_table->prepare_items();
            $models_table->display();
        ?>
    </form>
</div>