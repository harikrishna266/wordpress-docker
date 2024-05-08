<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
    <input type="hidden" name="action" value="save_model_data">
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <h2>Save Model</h2>
                </th>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="model_name">Name:</label></th>
                <td><input type="text" id="model_name" name="model_name" required>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="model_url">Select Model:</label></th>
                <td><select id="model_url" name="model_url" required>
                        <?php
                        if (isset($models_dummy_data) && is_array($models_dummy_data)) {
                            foreach ($models_dummy_data as $option) {
                                echo '<option value="' . esc_attr($option['model_url']) . '">' . esc_html($option['name']) . '</option>';
                            }
                        }
                        ?>
                    </select>
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