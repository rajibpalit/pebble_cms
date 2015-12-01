

<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Currency</b></h3>
    </div>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="currency_form" role="form" method="post" action="<?php echo base_url('main/add_currency') ?>">
            <?php if (isset($value)) { ?>
                <input type="hidden" value="<?php echo $value[0]['currency_id'] ?>" name="currency_id" >
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="currency_name">Currency Name</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="currency_name" value="<?php echo isset($value) ? $value[0]['currency_name'] : '' ?>" id="currency_name" placeholder="Enter Currency Name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="short_form">Short Form</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="short_form" value="<?php echo isset($value) ? $value[0]['short_form'] : '' ?>" id="short_form" placeholder="Enter Short Form">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="symbol_text">Symbol Text</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="symbol_text" value="<?php echo isset($value) ? $value[0]['symbol_text'] : '' ?>" id="symbol_text" placeholder="Enter Symbol Text">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="country">Country</label>
                <div class="col-sm-3">
                    <select class="form-control" id="country" name="country">

                        <?php
                        foreach ($countrys as $country) {
                            if ($country['keyword_id'] == $value[0]['country']) {
                                $checked = 'selected';
                            } else {
                                $checked = '';
                            }
                            echo '<option ' . $checked . ' value="' . $country['keyword_id'] . '">' . $country['keyword_value'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="fractional_unit">Fractional Unit</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="fractional_unit" value="<?php echo isset($value) ? $value[0]['fractional_unit'] : '' ?>" id="fractional_unit" placeholder="Enter Fractional Unit">
                </div>
            </div>
            <!--                
                            <div class="form-group">
                            <label class="control-label col-sm-2" for="remarks">Remarks</label>
                            <div class="col-sm-3">          
                                <input type="text" class="form-control" name="remarks" value="<?php echo isset($value) ? $value[0]['remarks'] : '' ?>" id="remarks" placeholder="Enter Remarks"> 
                            </div>
                        </div>-->
            <div class="form-group">
                <div>

                    <label class="control-label col-sm-2" for="is_base" style="margin-right: 20px">Base Currency </label>
                </div>
                <div style="margin-left: 13px;">
                    <label class="radio-inline">
                        <input type="radio" name="is_base" <?php echo!isset($value) ? 'checked' : '' ?> <?php echo isset($value) && ($value[0]['is_base'] == 0) ? 'checked' : '' ?> id="base_currency1" value="0"> No
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="is_base" id="base_currency2" <?php echo isset($value) && ($value[0]['is_base'] == 1) ? 'checked' : '' ?> value="1"> Yes
                    </label>
                </div>
            </div>
            <div class="form-group">
                <div>

                    <label class="control-label col-sm-2" for="status" style="margin-right: 20px">Status </label>
                </div>
                <div style="margin-left: 13px;">
                    <label class="radio-inline">
                        <input type="radio" name="status" <?php echo!isset($value) ? 'checked' : '' ?> <?php echo isset($value) && ($value[0]['status'] == 1) ? 'checked' : '' ?> id="inlineRadio1" value="1"> Active
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="status" id="inlineRadio2" <?php echo isset($value) && ($value[0]['status'] == 0) ? 'checked' : '' ?> value="0"> Inactive
                    </label>
                </div>

            </div>
            <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;">        
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="submit" id="submit" class="btn col-sm-3" style="background-color: #85C51F; margin-right: 10px; padding: 4px; color: white; font-size: 20px;"><b>Save</b></button>                  
                    <a href="<?php echo base_url('main/currency_list'); ?>" class="btn col-sm-3" style="background-color: #85C51F; padding: 4px; color: white; font-size: 20px;"><b><?php echo (isset($keywords)) ? 'Back' : 'Close' ?></b></a>                                                        
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


<script>
//    $.validator.setDefaults({
//        submitHandler: function () {
//            alert("submitted!");
//        }
//    });

    $().ready(function () {

        // validate signup form on keyup and submit
        $("#currency_form").validate({
            rules: {
                currency_name: "required",
                short_form: "required",
                symbol_text: "required",
                fractional_unit: "required",
            },
            messages: {
                currency_name: "Please enter currency name.",
                short_form: "Please enter short form.",
                symbol_text: "Please enter symbol text.",
                fractional_unit: "Please enter fractional uni.",
            }
        });
    });
</script>
