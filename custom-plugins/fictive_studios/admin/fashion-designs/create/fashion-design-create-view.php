<form action="<?php echo esc_url(admin_url('admin-post.php')); ?>" method="post">
    <?php if (isset($design_data)) : ?>
        <input type="hidden" name="id" value="<?php echo esc_attr(($_GET['design'])); ?>">
        <input type="hidden" name="action" value="edit_design_data">
    <?php else : ?>
        <input type="hidden" name="action" value="save_design_data">
    <?php endif; ?>
    <table class="form-table">
        <tbody>
            <tr>
                <th scope="row">
                    <h2>Save Design</h2>
                </th>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="fashion_design_name">Name:</label></th>
                <td><input type="text" id="fashion_design_name" name="fashion_design_name" required value="<?php echo esc_attr($design_data ? $design_data->name : ''); ?>">
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"><label for="fashion_design_model">Select Model:</label></th>
                <td>
                    <select id="fashion_design_model" name="fashion_design_model" required>
                        <?php if ($action !== 'edit') : ?>
                            <option value="">--</option>
                        <?php endif; ?>
                        <?php foreach ($model_data as $option) : ?>
                            <option value="<?php echo esc_attr($option['ID']); ?>" <?php if ($design_data && $option['ID'] == $design_data->model_id) : ?> selected="selected" <?php endif; ?>>
                                <?php echo esc_html($option['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </td>
            </tr>
            <tr class="form-field layer-field">
                <th scope="row"><label for="fashion_design_layer_1">Upload Layer 1* :</label></th>
                <td>
                    <div class="layer-box">
                        <input type="text" id="fashion_design_layer_1_name" name="fashion_design_layer_1_name" placeholder="Name" value="<?php echo esc_attr($design_data ? $design_data->{'design_layer_1_name'} : ''); ?>" required>
                    </div>
                    <div class="layer-box">
                        <input type="text" id="fashion_design_layer_1" name="fashion_design_layer_1_link" placeholder="Link" value="<?php echo esc_attr($design_data ? $design_data->{'design_layer_1_link'} : ''); ?>" required>
                    </div>
                    <div class="layer-box">
                        <input type="text" id="fashion_design_layer_1_color" name="fashion_design_layer_1_color" value="<?php echo esc_attr($design_data ? $design_data->{'design_layer_1_color'} : ''); ?>" required>
                    </div>
                </td>
            </tr>
            <tr class="form-field layer-field">
                <th scope="row"><label textfor="fashion_design_layer_2">Upload Layer 2 :</label></th>
                <td>
                    <div class="layer-box">
                        <input type="text" id="fashion_design_layer_2_name" name="fashion_design_layer_2_name" placeholder="Name" value="<?php echo esc_attr($design_data ? $design_data->{'design_layer_2_name'} : ''); ?>">
                        <input type="text" id="fashion_design_layer_2" name="fashion_design_layer_2_link" placeholder="Link" value="<?php echo esc_attr($design_data ? $design_data->{'design_layer_2_link'} : ''); ?>">
                        <input type="text" id="fashion_design_layer_2_color" name="fashion_design_layer_2_color" value="<?php echo esc_attr($design_data ? $design_data->{'design_layer_2_color'} : ''); ?>">
                    </div>
                </td>
            </tr>
            <tr class="form-field layer-field">
                <th scope="row"><label for="fashion_design_layer_3">Upload Layer 3 :</label></th>
                <td>
                    <div class="layer-box">
                        <input type="text" id="fashion_design_layer_3_name" name="fashion_design_layer_3_name" placeholder="Name" value="<?php echo esc_attr($design_data ? $design_data->{'design_layer_3_name'} : ''); ?>">
                        <input type="text" id="fashion_design_layer_3" name="fashion_design_layer_3_link" placeholder="Link" value="<?php echo esc_attr($design_data ? $design_data->{'design_layer_3_link'} : ''); ?>">
                        <input type="text" id="fashion_design_layer_3_color" name="fashion_design_layer_3_color" value="<?php echo esc_attr($design_data ? $design_data->{'design_layer_3_color'} : ''); ?>">
                    </div>
                </td>
            </tr>
            <tr class="form-field layer-field">
                <th scope="row"><label for="fashion_design_layer_4">Upload Layer 4 :</label></th>
                <td>
                    <div class="layer-box">
                        <input type="text" id="fashion_design_layer_4_name" name="fashion_design_layer_4_name" placeholder="Name" value="<?php echo esc_attr($design_data ? $design_data->{'design_layer_4_name'} : ''); ?>">
                        <input type="text" id="fashion_design_layer_4" name="fashion_design_layer_4_link" placeholder="Link" value="<?php echo esc_attr($design_data ? $design_data->{'design_layer_4_link'} : ''); ?>">
                        <input type="text" id="fashion_design_layer_4_color" name="fashion_design_layer_4_color" value="<?php echo esc_attr($design_data ? $design_data->{'design_layer_4_color'} : ''); ?>">
                    </div>
                </td>
            </tr>
            <tr class="form-field layer-field">
                <th scope="row"><label for="fashion_design_layer_5">Upload Layer 5 :</label></th>
                <td>
                    <div class="layer-box">
                        <input type="text" id="fashion_design_layer_5_name" name="fashion_design_layer_5_name" placeholder="Name" value="<?php echo esc_attr($design_data ? $design_data->{'design_layer_5_name'} : ''); ?>">
                        <input type="text" id="fashion_design_layer_5" name="fashion_design_layer_5_link" placeholder="Link" value="<?php echo esc_attr($design_data ? $design_data->{'design_layer_5_link'} : ''); ?>">
                        <input type="text" id="fashion_design_layer_5_color" name="fashion_design_layer_5_color" value="<?php echo esc_attr($design_data ? $design_data->{'design_layer_5_color'} : ''); ?>">
                    </div>
                </td>
            </tr>
            <tr class="form-field">
                <th scope="row"></th>
                <td>
                    <button id="saveDesignBtn" type="submit" class="button-primary">Submit</button>
                </td>
            </tr>
        </tbody>
    </table>
</form>