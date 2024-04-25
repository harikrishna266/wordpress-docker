<?php
echo <<<HTML
<style>
  #print-area-form {
    /* background-color: #f9f9f9; */
    padding: 20px;
    /* border-radius: 8px; */
    /* box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1); */
    max-width: 400px;
    /* margin: 20px auto; */
  }

  #print-area-form h2 {
    margin-top: 0;
    margin-bottom: 20px;
    font-size: 24px;
    color: #333;
  }

  #print-area-form label {
    display: block;
    margin-bottom: 8px;
    font-weight: bold;
  }

  #print-area-form input[type="number"] {
    width: 100%;
    padding: 10px;
    border: 1px solid #ccc;
    border-radius: 4px;
    margin-bottom: 15px;
  }

  #print-area-form button {
    background-color: #007bff;
    color: #fff;
    padding: 10px 20px;
    border: none;
    border-radius: 4px;
    cursor: pointer;
  }

  #print-area-form button:hover {
    background-color: #0056b3;
  }

  #print-area-form button:disabled {
    background-color: grey;
  }
</style>
HTML;

$heightValue = isset($print_area_data) && isset($print_area_data->height) ? $print_area_data->height : '';
$widthValue = isset($print_area_data) && isset($print_area_data->width) ? $print_area_data->width : '';

echo <<<HTML
<div id="print-area-form">
  <div class="print-area-form-content">
    <h2>Save Print Area</h2>
    <div>
      <label for="height">Height:</label>
      <input type="number" id="height-field" name="height" value='$heightValue' required>
    </div>
    <div>
      <label for="width">Width:</label>
      <input type="number" id="width-field" name="width" value='$widthValue' required>
    </div>
    <div>
      <button id="savePrintAreaBtn" type="submit">Submit</button>
    </div>
  </div>
</div>

<script>
  document.addEventListener('DOMContentLoaded', function() {
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
HTML;
?>