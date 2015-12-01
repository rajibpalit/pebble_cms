<div class="container" style="background-color: white;">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>New Keyword</b></h3>
    </div>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="keyword_form" role="form" method="post" action="<?php echo base_url('main/data_insert') ?>">
            <?php if (isset($keywords)) { ?>
                <input type="hidden" value="<?php echo $keywords[0]['keyword_id'] ?>" name="keyword_id" >
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="keyword_for">Keyword For</label>
                <div class="col-sm-3">
                    <select required="required" class="form-control" id="key_id" name="key_id">
                        <option value="">Please Select</option>
                        <?php
                        foreach ($value as $key) {
                            if (isset($keywords)) {
                                if ($key['key_id'] == $keywords[0]['key_id']) {
                                    $checked = 'selected';
                                } else {
                                    $checked = '';
                                }
                            } else {
                                $checked = '';
                            }
                            echo '<option ' . $checked . ' value="' . $key['key_id'] . '">' . $key['key_name'] . '</option>';
                        }
                        ?>                                              
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="keyword_value">Keyword Value</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="keyword_value" value="<?php echo isset($keywords) ? $keywords[0]['keyword_value'] : '' ?>" id="keyword_value" placeholder="Enter Keyword Value">
                </div>
            </div>
            <div class="form-group">
                <div>

                    <label class="control-label col-sm-2" for="status" style="margin-right: 20px">Status </label>
                </div>
                <div style="margin-left: 13px;">
                    <label class="radio-inline">
                        <input type="radio" name="status" <?php echo!isset($keywords) ? 'checked' : '' ?> <?php echo isset($keywords) && ($keywords[0]['status'] == 1) ? 'checked' : '' ?> id="inlineRadio1" value="1"> Active
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="status" id="inlineRadio2" <?php echo isset($keywords) && ($keywords[0]['status'] == 0) ? 'checked' : '' ?> value="0"> Inactive
                    </label>
                </div>

            </div>
            <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;">        
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="submit" id="submit" class="btn col-sm-3 save-button-color" style=""><b>Save</b></button>                  
                    <a href="<?php echo base_url('main/list_keyword'); ?>" class="btn col-sm-3 close-button-color" style=""><b><?php echo (isset($keywords)) ? 'Back' : 'Close' ?></b></a>                                                        
                </div>
            </div>
        </form>
    </div>
</div>
<script>
//    $.validator.setDefaults({
//        submitHandler: function () {
//            alert("submitted!");
//        }
//    });

    $().ready(function () {

        // validate signup form on keyup and submit
        $("#keyword_form").validate({
            rules: {
                key_id: "required",
                keyword_value: "required"
            },
            messages: {
                company_name: "Please select keyword for.",
                keyword_value: "Please enter keyword value.",
            }
        });
    });
</script>


<script>
    $('#submit').on('click', function () {
        if ($('#key_id').val() == '') {
            $('#key_id').css('border', '1px solid red');
            
        }
        else {
            $('#key_id').css('border', '1px solid #ccc');
           
        }

        if ($('#keyword_value').val() == '') {
            $('#keyword_value').css('border','1px solid red');
           
        }
        else {
            $('#keyword_value').css('border', '1px solid #ccc');
           
        }
    });
</script>
