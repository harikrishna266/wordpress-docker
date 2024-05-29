<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
  <?php if (isset($print_type_id)): ?>
    <input type="hidden" name="id" value="<?php echo esc_attr($print_type_id); ?>">
    <input type="hidden" name="action" value="edit_print_type">
  <?php else: ?>
    <input type="hidden" name="action" value="save_print_type">
  <?php endif; ?>
  <table class="form-table">
    <tbody>
      <tr>
        <th scope="row">
          <h2>Save Print Types</h2>
        </th>
      </tr>
      <tr class="form-field">
        <th scope="row"><label for="name">Name:</label></th>
        <td><input type="text" id="name" name="name"
            value="<?php echo esc_attr($print_types_data ? $print_types_data->name : ''); ?>" required>
        </td>
      </tr>
      <tr class="form-field">
        <th scope="row"><label for="link">Link:</label></th>
        <td><input type="text" id="link" name="link" value="<?php echo esc_attr($print_types_data ? $print_types_data->link : ''); ?>" required>
        </td>
      </tr>
      <tr class="form-field">
        <th scope="row"></th>
        <td>
          <button id="savePrintTypeBtn" type="submit" class="button button-primary">Submit</button>
        </td>
      </tr>
    </tbody>
  </table>
</form>