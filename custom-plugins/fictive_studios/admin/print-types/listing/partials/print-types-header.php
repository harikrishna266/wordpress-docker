<div class="wrap">
    <h2>
        <?php esc_html_e('Print Types', 'admin-table-tut'); ?>
    </h2>
    <form id="all-drafts" method="get">
        <input type="hidden" name="page" value="print-areas" />
        <?php
        $print_types_table->prepare_items();
        $print_types_table->display();
        ?>
    </form>
</div>