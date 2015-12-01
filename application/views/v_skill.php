<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>New Skills</b></h3>
    </div>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="skill_form" role="form" method="post" action="<?php echo base_url()?>main/add_skills">
            <?php if (isset($skills)) { ?>
                <input type="hidden" value="<?php echo $skills[0]['id'] ?>" name="id" >
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="description">Skill Description*</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="description" value="<?php echo isset($skills) ? $skills[0]['description'] : '' ?>" id="description" placeholder="Skill Description">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="associated_action">Associated Action</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="associated_action" value="<?php echo isset($skills) ? $skills[0]['associated_action'] : '' ?>" id="associated_action" placeholder="Associated Action">
                </div>
            </div>
            <div class="form-group">
                <div>

                    <label class="control-label col-sm-2" for="status" style="margin-right: 20px">Status </label>
                </div>
                <div style="margin-left: 13px;">
                    <label class="radio-inline">
                        <input type="radio" name="status" <?php echo!isset($skills) ? 'checked' : '' ?> <?php echo isset($skills) && ($skills[0]['status'] == 1) ? 'checked' : '' ?> id="inlineRadio1" value="1"> Active
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="status" id="inlineRadio2" <?php echo isset($skills) && ($skills[0]['status'] == 0) ? 'checked' : '' ?> value="0"> Inactive
                    </label>
                </div>
            </div>
            <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;">        
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="submit" id="submit" class="btn col-sm-3 save-button-color"><b>Save</b></button>                  
                    <a href="<?php echo base_url('main/skill_list'); ?>" class="btn col-sm-3 close-button-color"><b><?php echo (isset($skills)) ? 'Back' : 'Close' ?></b></a>                                                        
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
        $("#skill_form").validate({
            rules: {
                description: "required",
                associated_action: "required",
            },
            messages: {
                description: "Please enter description field.",
                associated_action: "Please enter associated action.",
            }
        });
    });
</script>

