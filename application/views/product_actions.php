<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Production Action</b></h3>
    </div>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="production_action_form" role="form" method="post" action="<?php echo base_url('main/add_product_actions') ?>">
            <?php if (isset($keywords)) { ?>
                <input type="hidden" value="<?php echo $keywords[0]['id'] ?>" name="id" >
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="action_name">Action Name</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="action_name" value="<?php echo isset($keywords) ? $keywords[0]['action_name'] : '' ?>" placeholder="Enter Action Name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="action_place">Action Place</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="action_place" value="<?php echo isset($keywords) ? $keywords[0]['action_place'] : '' ?>" placeholder="Enter Action Place">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="remarks">Remarks</label>
                <div class="col-sm-3">          
                    <input  type="text" class="form-control" name="remarks" value="<?php echo isset($keywords) ? $keywords[0]['remarks'] : '' ?>" placeholder="Enter Remarks">
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
                    <button type="submit" name="submit" id="submit" class="btn col-sm-3" style="background-color: #85C51F; margin-right: 10px; padding: 4px; color: white; font-size: 20px;"><b>Save</b></button>                  
                    <a href="<?php echo base_url('main/product_actions_list'); ?>" class="btn col-sm-3" style="background-color: #85C51F; padding: 4px; color: white; font-size: 20px;"><b><?php echo (isset($keywords)) ? 'Back' : 'Close' ?></b></a>                                                        
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
                action_name: "Please enter action name.",
                action_place: "Please enter action place.",
            }
        });
    });
</script>
