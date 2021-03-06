<div class="container">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Insurance Company</b></h3>
    </div>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="insurance_form" role="form" method="post" action="<?php echo base_url('main/add_insurance_company') ?>">
            <?php if (isset($value)) { ?>
                <input type="hidden" value="<?php echo $value[0]['id'] ?>" name="id" >
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="company_name">Company Name*</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="company_name" value="<?php echo isset($value) ? $value[0]['company_name'] : '' ?>" id="currency_name" placeholder="Enter Company Name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="address">Address *</label>
                <div class="col-sm-3">
                    <textarea class="form-control" name="address" value="" id=""><?php echo isset($value) ? $value[0]['address'] : '' ?></textarea>

                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="country_id">Country</label>
                <div class="col-sm-3">
                    <select class="form-control" id="country_id" name="country_id">
                        <option value="">Please Select...</option>
                        <?php
                        foreach ($countrys as $country) {
                            if ($country['keyword_id'] == $value[0]['country_id']) {
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
            <div class="form-group" style="alignment-adjust: middle; margin-top: 30px;">        
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="submit" id="submit" class="btn col-sm-3 save-button-color" style=""><b>Save</b></button>                  
                    <a href="<?php echo base_url('main/insurance_companies_list'); ?>" class="btn col-sm-3 close-button-color" style=""><b><?php echo (isset($value)) ? 'Back' : 'Close' ?></b></a>                                                        
                </div>
            </div>
        </form>
    </div>
</div>
<script>

    $().ready(function () {

        // validate signup form on keyup and submit
        $("#insurance_form").validate({
            rules: {
                company_name: "required",
                country_id: "required"
            },
            messages: {
                company_name: "Please enter company name.",
                country_id: "Please select country id.",
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
            $('#keyword_value').css('border', '1px solid red');

        }
        else {
            $('#keyword_value').css('border', '1px solid #ccc');

        }
    });
</script>
