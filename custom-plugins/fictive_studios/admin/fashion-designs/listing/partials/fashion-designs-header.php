<div class="wrap">
    <h2>
        <?php esc_html_e('Fashion Design', 'admin-table-tut'); ?>
    </h2>
    <form id="all-drafts" method="get">
        <input type="hidden" name="page" value="print-areas" />
        <?php
        $fashion_design_table->prepare_items();
        $fashion_design_table->display();
        ?>
    </form>
</div>