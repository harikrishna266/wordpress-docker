<div class="wrap">
    <h2>
        <?php esc_html_e('Print Areas', 'admin-table-tut'); ?>
    </h2>
    <form id="all-drafts" method="get">
        <input type="hidden" name="page" value="print-areas" />
        <?php
        $print_area_table->prepare_items();
        $print_area_table->display();
        ?>
    </form>
</div>