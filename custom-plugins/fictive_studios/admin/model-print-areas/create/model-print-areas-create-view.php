<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
    <input type="hidden" name="action" value="save_model_print_area_data">
    <input type="hidden" name="model_id" value="<?php echo isset($_GET['model']) ? esc_attr($_GET['model']) : ''; ?>">
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <h2>Save Model Print Area</h2>
                </th>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="height">Name:</label></th>
                <td><input type="text" id="model-name" name="model_name" required>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="height">Print Area:</label></th>
                <td> <select id="print-area" name="print_area_id" required>
                        <?php
                        if (isset($print_areas) && is_array($print_areas)) {
                            foreach ($print_areas as $option) {
                                echo '<option value="' . esc_attr($option['ID']) . '">' . esc_html($option['height'] . 'x' . $option['width']) . '</option>';
                            }
                        }
                        ?>
                    </select>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="x-coordinate">x coordinate:</label></th>
                <td><input type="text" id="x-coordinate" name="x_coordinate" required>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="y-coordinate">y coordinate:</label></th>
                <td><input type="text" id="y-coordinate" name="y_coordinate" required>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="camera-x-coordinate">camera x coordinate:</label></th>
                <td><input type="text" id="camera-x-coordinate" name="camera_x_coordinate" required>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="camera-y-coordinate">camera y coordinate:</label></th>
                <td><input type="text" id="camera-y-coordinate" name="camera_y_coordinate" required>
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