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
                <th scope="row"><label for="height">Name:</label></th>
                <td><input type="text" id="model-name" name="model_name" required>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="height">Select Model:</label></th>
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