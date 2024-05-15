<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="save_pattern_data">
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <h2>Save Pattern</h2>
                </th>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="pattern_name">Name:</label></th>
                <td><input type="text" id="pattern_name" name="pattern_name" required>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="pattern_image">Upload Pattern Image:</label></th>
                <td><input type="file" id="pattern_image" name="pattern_image" required>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="pattern_file">Upload Pattern File:</label></th>
                <td><input type="file" id="pattern_file" name="pattern_file">
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