<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Payment Mode</b></h3>
    </div>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="payment_form" role="form" method="post" action="<?php echo base_url('main/add_payment') ?>">
            <?php if (isset($value)) { ?>
                <input type="hidden" value="<?php echo $value[0]['id'] ?>" name="id" >
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="payment_mode">Payment Mode</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="payment_mode" value="<?php echo isset($value) ? $value[0]['payment_mode'] : '' ?>" id="currency_name" placeholder="Enter Payment Mode">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="description">Description</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="description" value="<?php echo isset($value) ? $value[0]['description'] : '' ?>" id="description" placeholder="Enter Description">
                </div>
            </div>    
            <div class="form-group">
                <label class="control-label col-sm-2" for="payment_particular">Payment Particular</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="payment_particular" value="<?php echo isset($value) ? $value[0]['payment_particular'] : '' ?>" id="payment_particular" placeholder="Payment Particular">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="remarks">Remarks</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="remarks" value="<?php echo isset($value) ? $value[0]['remarks'] : '' ?>" id="currency_name" placeholder="Enter Remarks">
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
                    <button type="submit" name="submit" id="submit" class="btn col-sm-3 save-button-color" style=""><b>Save</b></button>                  
                    <a href="<?php echo base_url('main/payment_list'); ?>" class="btn col-sm-3 close-button-color" style=""><b><?php echo (isset($value)) ? 'Back' : 'Close' ?></b></a>                                                        
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
    });;

    $().ready(function () {

        // validate signup form on keyup and submit
        $("#payment_form").validate({
            rules: {
                payment_mode: "required",
                description: "required",
                payment_particular: "required"
            },
            messages: {
                payment_mode: "Please enter payment mode.",
                description: "Please enter description.",
                payment_particular: "Please enter payment particular."
            }
        });
    });
</script>
