<div class="wrap">
    <h2>
        <?php esc_html_e('Create Template', 'admin-table-tut'); ?>
        <a id="editor2d" class="button-secondary" href="<?php echo $link_url; ?>" target="_blank">Open Template Editor</a>
    </h2>
     <div x-data="editor">
        <ul class="bg-white shadow rounded-lg divide-y divide-gray-200">
            <template x-for="res in availablePrintAreas">
                <li class="px-6 py-4   cursor-pointer" @click="openEditor()"  >
                    <p class="text-lg font-semibold" x-text="res.name">name</p>
                    <p class="text-sm text-gray-500" x-text="`${res.resolution.width} x ${res.resolution.height}`">Resolution</p>
                </li>
            </template>
        </ul>
    </div>
</div>
