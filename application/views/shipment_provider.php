<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Shipment Provider</b></h3>
    </div>

    <?php
//    echo '<pre>';
//    print_r($countrys);
//    echo '</pre>';
    ?>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="shipment_form" role="form" method="post" action="<?php echo base_url('main/add_shipment_provider') ?>">
            <?php if (isset($keywords)) { ?>
                <input type="hidden" value="<?php echo $keywords[0]['id'] ?>" name="id" >
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="material_name">Material Name</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="material_name" value="<?php echo isset($keywords) ? $keywords[0]['material_name'] : '' ?>" id="client_name" placeholder="Enter Material Name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="country">Country</label>
                <div class="col-sm-3">
                    <select class="form-control" id="country" name="country">
                        <option value="">Please Select...</option>
                        <?php
                        foreach ($countrys as $country) {
                            if ($country['keyword_id'] == $keywords[0]['country_id']) {
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
                <label class="control-label col-sm-2" for="contact_no">Contact No.</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="contact_no" value="<?php echo isset($keywords) ? $keywords[0]['contact_no'] : '' ?>" id="contact_no" placeholder="Enter Contact No">
                </div> 
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="mobile_no">Mobile No.</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="mobile_no" value="<?php echo isset($keywords) ? $keywords[0]['mobile_no'] : '' ?>" id="mobile_no" placeholder="Enter Mobile No">
                </div> 
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Email</label>
                <div class="col-sm-3">          
                    <input type="email" class="form-control" name="email" value="<?php echo isset($keywords) ? $keywords[0]['email'] : '' ?>" id="mail" placeholder="Enter Email" data-rule-required="true" data-rule-email="true" data-msg-required="Please enter your email address" data-msg-email="Please enter a valid email address">
                    <!--<input id="cemail" name="email" data-rule-required="true" data-rule-email="true" data-msg-required="Please enter your email address" data-msg-email="Please enter a valid email address">-->
                </div> 
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="address">Address</label>
                <div class="col-sm-3">          
                    <textarea class="form-control" name="address" id="adrress" placeholder="Enter Address"><?php echo isset($keywords) ? $keywords[0]['address'] : '' ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="interval_days">Interval Days</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="interval_days" id="interval_days" placeholder="Enter Interval Days" value="<?php echo isset($keywords) ? $keywords[0]['interval_days'] : '' ?>"></textarea>
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
                    <a href="<?php echo base_url('main/shipment_provider_list'); ?>" class="btn col-sm-3" style="background-color: #85C51F; padding: 4px; color: white; font-size: 20px;"><b><?php echo (isset($keywords)) ? 'Back' : 'Close' ?></b></a>                                                        
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
        $("#shipment_form").validate({
            rules: {
                material_name: "required",
                country: "required",
                contact_no: "required",
                mobile_no: "required",
                interval_days: "required",
            },
            messages: {
                material_name: "Please enter material name.",
                country: "Please enter country.",
                contact_no: "Please enter contact_no.",
                mobile_no: "Please enter mobile no.",
                interval_days: "Please enter interval days.",
            }
        });
    });

    $(document).ready(function () {
        $("#shipment_form").validate({
            messages: {
                email: {
                    required: 'Enter this!'
                }
            }
        });
    });
</script>