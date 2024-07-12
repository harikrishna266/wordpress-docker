<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
    <?php if (isset($tag_id)) : ?>
        <input type="hidden" name="id" value="<?php echo esc_attr($tag_id); ?>">
        <input type="hidden" name="action" value="edit_tag_data">
    <?php else : ?>
        <input type="hidden" name="action" value="save_tag_data">
    <?php endif; ?>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <?php if (isset($tag_id)) : ?>
                        <h2>Edit Tag</h2>
                    <?php else : ?>
                        <h2>Save Tag</h2>
                    <?php endif; ?>

                </th>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="name">Tag Name:</label></th>
                <td><input type="text" id="name" name="name" value="<?php echo esc_attr($tags_data ? $tags_data->name : ''); ?>" required>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"></th>
                <td>
                    <button id="saveTagBtn" type="submit" class="button button-primary">Submit</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>