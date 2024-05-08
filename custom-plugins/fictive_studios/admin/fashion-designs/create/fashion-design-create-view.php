<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post" enctype="multipart/form-data">
    <input type="hidden" name="action" value="save_design_data">
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <h2>Save Design</h2>
                </th>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="fashion_design_name">Name:</label></th>
                <td><input type="text" id="fashion_design_name" name="fashion_design_name" required>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="height">Select Model:</label></th>
                <td> <select id="fashion_design_model" name="fashion_design_model" required>
                        <option value=''>--</option>
                        <?php
                        if (isset($model_data) && is_array($model_data)) {
                            foreach ($model_data as $option) {
                                echo '<option value="' . esc_attr($option['ID']) . '">' . esc_html($option['name']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="fashion_design_file">Upload File:</label></th>
                <td><input type="file" id="fashion_design_file" name="fashion_design_file" required>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"></th>
                <td>
                    <button id="saveModelBtn" type="submit" class="button-primary">Submit</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>