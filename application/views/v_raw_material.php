<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Raw Material</b></h3>
    </div>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="keyword_insert" role="form" method="post" action="<?php echo base_url('main/add_raw_material') ?>">
            <?php if (isset($value)) { ?>
                <input type="hidden" value="<?php echo $value[0]['id'] ?>" name="id" >
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="material_code">Material Code</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="material_code" value="<?php echo isset($value) ? $value[0]['material_code'] : '' ?>" id="material_code" placeholder="Enter Material Code">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="material_name">Material Name</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="material_name" value="<?php echo isset($value) ? $value[0]['material_name'] : '' ?>" id="material_code" placeholder="Enter Material Name">
                </div>
            </div>    
            <div class="form-group">
                <label class="control-label col-sm-2" for="material_type_id">Material Type</label>
                <div class="col-sm-3">
                    <select class="form-control" id="material_type_id" name="material_type_id">
                        <option value="">Please Select...</option>
                        <?php
                        foreach ($materials_type as $material) {
                            if ($material['keyword_id'] == $value[0]['material_type_id']) {
                                $checked = 'selected';
                            } else {
                                $checked = '';
                            }
                            echo '<option ' . $checked . ' value="' . $material['keyword_id'] . '">' . $material['keyword_value'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>    
            <div class="form-group">
                <label class="control-label col-sm-2" for="size_id">Size</label>
                <div class="col-sm-3">
                    <select class="form-control" id="size_id" name="size_id">
                        <option value="">Please Select...</option>
                        <?php
                        foreach ($sizes as $size) {
                            if ($size['keyword_id'] == $value1[0]['size_id']) {
                                $checked = 'selected';
                            } else {
                                $checked = '';
                            }
                            echo '<option ' . $checked . ' value="' . $size['keyword_id'] . '">' . $size['keyword_value'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>    
            <div class="form-group">
                <label class="control-label col-sm-2" for="color_id">Color</label>
                <div class="col-sm-3">
                    <select class="form-control" id="color_id" name="color_id">
                        <option value="">Please Select...</option>
                        <?php
                        foreach ($colors as $color) {
                            if ($color['keyword_id'] == $value2[0]['color_id']) {
                                $checked = 'selected';
                            } else {
                                $checked = '';
                            }
                            echo '<option ' . $checked . ' value="' . $color['keyword_id'] . '">' . $color['keyword_value'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>    
            <div class="form-group">
                <label class="control-label col-sm-2" for="m_unit_id">measurement Unit</label>
                <div class="col-sm-3">
                    <select class="form-control" id="m_unit_id" name="m_unit_id">
                        <option value="">Please Select...</option>
                        <?php
                        foreach ($mus as $mu) {
                            if ($mu['keyword_id'] == $value3[0]['m_unit_id']) {
                                $checked = 'selected';
                            } else {
                                $checked = '';
                            }
                            echo '<option ' . $checked . ' value="' . $mu['keyword_id'] . '">' . $mu['keyword_value'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div> 
            <div class="form-group">
                <label class="control-label col-sm-2" for="reorder_level">Reorder</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="reorder_level" value="<?php echo isset($value) ? $value[0]['reorder_level'] : '' ?>" id="reorder_level" placeholder="Enter Reorder">
                </div>
            </div>    
            <div class="form-group">
                <label class="control-label col-sm-2" for="raw_remarks">Remarks</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="raw_remarks" value="<?php echo isset($value) ? $value[0]['raw_remarks'] : '' ?>" id="raw_remarks" placeholder="Enter Remarks">
                </div>
            </div> 
            <div class="form-group">
                <div>

                    <label class="control-label col-sm-2" for="raw_status" style="margin-right: 20px">Status </label>
                </div>
                <div style="margin-left: 13px;">
                    <label class="radio-inline">
                        <input type="radio" name="raw_status" <?php echo!isset($value) ? 'checked' : '' ?> <?php echo isset($value) && ($value[0]['raw_status'] == 1) ? 'checked' : '' ?> id="inlineRadio1" value="1"> Active
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="raw_status" id="inlineRadio2" <?php echo isset($value) && ($value[0]['raw_status'] == 0) ? 'checked' : '' ?> value="0"> Inactive
                    </label>
                </div>

            </div>
            <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;">        
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="submit" id="submit" class="btn col-sm-3" style="background-color: #85C51F; margin-right: 10px; padding: 4px; color: white; font-size: 20px;"><b>Save</b></button>                  
                    <a href="<?php echo base_url('main/raw_material_list'); ?>" class="btn col-sm-3" style="background-color: #85C51F; padding: 4px; color: white; font-size: 20px;"><b><?php echo (isset($value)) ? 'Back' : 'Close' ?></b></a>                                                        
                </div>
            </div>
        </form>
    </div>
</div>
<script>
    $('#submit').on('click', function () {
        if ($('#key_id').val() == '') {
            $('#key_id').css('border', '1px solid red');

        }
        else {
            $('#key_id').css('border', '1px solid #ccc');

        }
        if ($('#keyword_value').val() == '') {
            $('#keyword_value').css('border', '1px solid red');

        }
        else {
            $('#keyword_value').css('border', '1px solid #ccc');

        }
    });
</script>
