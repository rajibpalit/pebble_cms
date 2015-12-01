<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Production Action</b></h3>
    </div>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="production_action_form" role="form" method="post" action="">
            <div class="form-group">
                <label class="control-label col-sm-2" for="action_name">Action Name*</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="action_name" value="" id="" placeholder="Action Name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="action_place">Action Place</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="action_place" value="" id="" placeholder="Action Place">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="remarks">Remarks</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="remarks" value="" id="" placeholder="Remarks">
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
                    <button type="submit" name="submit" id="submit" class="btn col-sm-3 save-button-color"><b>Save</b></button>                  
                    <a href="<?php echo base_url('main/list_keyword'); ?>" class="btn col-sm-3 close-button-color"><b><?php echo (isset($keywords)) ? 'Back' : 'Close' ?></b></a>                                                        
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
        $("#production_action_form").validate({
            rules: {
                action_name: "required",
                action_place: "required",
            },
            messages: {
                action_name: "Please enter currency name !!",
                action_place: "Please enter short form",
            }
        });
    });
</script>
