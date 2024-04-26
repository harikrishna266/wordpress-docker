<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
  <?php if (isset($print_area_id)): ?>
    <input type="hidden" name="id" value="<?php echo esc_attr($print_area_id); ?>">
    <input type="hidden" name="action" value="edit_print_area">
  <?php else: ?>
    <input type="hidden" name="action" value="save_print_area">
  <?php endif; ?>
  <table class="form-table">
    <tbody>
      <tr>
        <th scope="row">
          <h2>Save Print Area</h2>
        </th>
      </tr>
      <tr class="form-field">
        <th scope="row"><label for="height">Height:</label></th>
        <td><input type="number" id="height-field" name="height" value="<?php echo esc_attr($heightValue); ?>" required>
        </td>
      </tr>
      <tr class="form-field">
        <th scope="row"><label for="width">Width:</label></th>
        <td><input type="number" id="width-field" name="width" value="<?php echo esc_attr($widthValue); ?>" required>
        </td>
      </tr>
      <tr class="form-field">
        <th scope="row"></th>
        <td>
          <button id="savePrintAreaBtn" type="submit" class="button button-primary">Submit</button>
        </td>
      </tr>
    </tbody>
  </table>
</form>

<script>
  document.addEventListener('DOMContentLoaded', function () {
    const heightField = document.getElementById('height-field');
    const widthField = document.getElementById('width-field');
    const saveButton = document.getElementById('savePrintAreaBtn');
    toggleButton();
    function toggleButton() {
      saveButton.disabled = !(heightField.value && widthField.value);
    }
    heightField.addEventListener('input', toggleButton);
    widthField.addEventListener('input', toggleButton);
  });
</script>