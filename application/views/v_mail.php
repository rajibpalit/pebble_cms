<div class="container">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>New Mail</b></h3>
    </div>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="mail_form" role="form" method="post" action="<?php echo base_url('main/add_mail') ?>">
            <?php if (isset($value)) { ?>
                <input type="hidden" value="<?php echo $value[0]['id'] ?>" name="id" >
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="mail_subject">Mail Subject</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="mail_subject" value="<?php echo isset($value) ? $value[0]['mail_subject'] : '' ?>" id="currency_name" placeholder="Enter Mail Subject">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="mail_text">Mail Text*</label>
                <div class="col-sm-3">
                    <textarea class="form-control" name="mail_text" value="" id=""><?php echo isset($value) ? $value[0]['mail_text'] : '' ?></textarea>

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
                    <a href="<?php echo base_url('main/mail_list'); ?>" class="btn col-sm-3 close-button-color" style=""><b><?php echo (isset($value)) ? 'Back' : 'Close' ?></b></a>                                                        
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
//    $.validator.setDefaults({
//        submitHandler: function () {
//            alert("submitted!");
//        }
//    });

    $().ready(function () {

        // validate signup form on keyup and submit
        $("#mail_form").validate({
            rules: {
                mail_subject: "required"
            },
            messages: {
                mail_subject: "Please write mail Subject."
            }
        });
    });
</script>
