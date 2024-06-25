<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
    <input type="hidden" name="design_id" value="<?php echo isset($_GET['design']) ? esc_attr($_GET['design']) : ''; ?>">
    <?php if (!isset($layer_data)) : ?>
        <input type="hidden" name="action" value="save_design_layers_data">
    <?php else : ?>
        <input type="hidden" name="action" value="edit_design_layers_data">
        <input type="hidden" name="layer_id" value="<?php echo isset($_GET['layer']) ? esc_attr($_GET['layer']) : ''; ?>">
    <?php endif; ?>


    <table class="form-table">
        <tbody>
            <tr class="form-field">
                <th scope="row"><label for="name">Name*:</label></th>
                <td><input type="text" id="name" name="name" required value="<?php echo esc_attr($layer_data ? $layer_data->name : ''); ?>">
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="color">Color*:</label></th>
                <td><input type="text" id="color" name="color" required value="<?php echo esc_attr($layer_data ? $layer_data->color : ''); ?>">
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="file_url">File*:</label></th>
                <td><input type="text" id="file_url" name="file_url" required value="<?php echo esc_attr($layer_data ? $layer_data->file_url : ''); ?>">
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="allow_pattern">Allow Pattern:</label></th>
                <td> <input type="checkbox" id="allow_pattern" name="allow_pattern" value="1" <?php checked($layer_data ? $layer_data->allow_pattern : false); ?>>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"></th>
                <td>
                    <button id="saveLayerBtn" type="submit" class="button-primary">Submit</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>