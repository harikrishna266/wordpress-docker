<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
    <?php if (isset($pattern_data)): ?>
        <input type="hidden" name="id" value="<?php echo esc_attr(($_GET['pattern'])); ?>">
        <input type="hidden" name="action" value="edit_pattern_data">
    <?php else: ?>
        <input type="hidden" name="action" value="save_pattern_data">
    <?php endif; ?>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <?php if (isset($pattern_data)): ?>
                        <h2>Update Pattern</h2>
                    <?php else: ?>
                        <h2>Save Pattern</h2>
                    <?php endif; ?>
                </th>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="pattern_name">Name:</label></th>
                <td><input type="text" id="pattern_name" name="pattern_name" required
                        value="<?php echo esc_attr($pattern_data ? $pattern_data->name : ''); ?>">
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="pattern_image">Upload Pattern Image:</label></th>
                <td><input type="text" id="pattern_image" name="pattern_image" required
                        value="<?php echo esc_attr($pattern_data ? $pattern_data->pattern_image : ''); ?>">
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="pattern_file">Upload Pattern File:</label></th>
                <td><input type="text" id="pattern_file" name="pattern_file" required
                        value="<?php echo esc_attr($pattern_data ? $pattern_data->pattern_url : ''); ?>">
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"></th>
                <td>
                    <button id="savePatternBtn" type="submit" class="button-primary">Submit</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>