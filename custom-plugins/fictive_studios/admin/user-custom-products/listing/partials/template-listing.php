
<div class="wrap" >
     <h2>
        <?php esc_html_e('Products', 'admin-table-tut'); ?>
        <a id="editor2d" class="button-secondary" href="<?php echo $link_url; ?>" target="_blank">Open Template Editor</a>
    </h2>
    <button onclick="loadBuilder()">Open Editor</button>
 </div>
    <form id="all-drafts" method="get">
        <input type="hidden" name="page" value="brocha-template" />
        <?php
            $template_table->prepare_items();
            $template_table->display();
        ?>
    </form>
<style>
    #modal-3d {
        background: black;
        position: absolute;
        width: 100vw;
        height: 100vh;
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
    }

</style>
<script>
    function loadBuilder() {
        const builderHolder = document.createElement( 'div' );
        builderHolder.setAttribute('id', "modal-3d");
        builderHolder.style.zIndex = 100001;
        document.body.appendChild( builderHolder);
        document.body.scrollTop = document.documentElement.scrollTop = 0;
        document.body.style.overflow = 'hidden';
        const appBuilder = document.createElement('app-root');
        appBuilder.setAttribute('model', 'model url goes here');
        builderHolder.appendChild(appBuilder);
    }
</script>
<script src="<?php echo BUILDER_URL ?>polyfills.js" defer type="module" ></script>
<script src="<?php echo  BUILDER_URL ?>main.js" defer type="module"  onload="" ></script>
