<div class="container" style="background-color: white;">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>MU Conversion</b></h3>
    </div>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="mu_conversion_form" role="form" method="post" action="<?php echo base_url('main/add_mu') ?>">
            <?php if (isset($value_from)) { ?>
                <input type="hidden" value="<?php echo $value_from[0]['id'] ?>" name="id" >
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="mu_from">MU From</label>
                <div class="col-sm-3">
                    <select required="required" class="form-control" id="" name="mu_from">
                        <option value="">Please Select</option>      
                        <?php
                      
                        foreach ($mu as $value) {
                            if ($value['keyword_id'] == $value_from[0]['mu_from']) {
                                $checked = 'selected';
                            } else {
                                $checked = '';
                            }
                            echo '<option ' . $checked . ' value="' . $value['keyword_id'] . '">' . $value['keyword_value'] . '</option>';
//                            echo '<option value="' . $value['keyword_id'] . '">' . $value['keyword_value'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="mu_to">MU To</label>
                <div class="col-sm-3">
                    <select required="required" class="form-control" id="" name="mu_to">
                        <option value="">Please Select</option>   
                        <?php
                        foreach ($mu as $to) {
                            if ($to['keyword_id'] == $value_to[0]['keyword_id']) {
                                $checked = 'selected';
                            } else {
                                $checked = '';
                            }
                            echo '<option ' . $checked . ' value="' . $to['keyword_id'] . '">' . $to['keyword_value'] . '</option>';
//                            echo '<option value="' . $to['keyword_id'] . '">' . $to['keyword_value'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="quantity">Quantity</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="quantity" value="<?php echo isset($value_from) ? $value_from[0]['quantity'] : '' ?>" id="currency_name" placeholder="Enter Quantity">
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
                    <a href="<?php echo base_url('main/mu_list'); ?>" class="btn col-sm-3 close-button-color" ><b><?php echo (isset($keywords)) ? 'Back' : 'Close' ?></b></a>                                                        
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
        $("#mu_conversion_form").validate({
            rules: {
                mu_from: "required",
                mu_to: "required",
                quantity: "required",
            },
            messages: {
                mu_from: "Please enter mu from !!",
                mu_to: "Please enter mu to !!",
                quantity: "Please enter quantity !!",
            }
        });
    });
</script>

