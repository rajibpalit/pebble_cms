<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Exchange Rate</b></h3>
    </div>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="exchange_form" role="form" method="post" action="<?php echo base_url('main/add_exchange_rate') ?>">
            <?php if (isset($exchange)) { ?>
                <input type="hidden" value="<?php echo $exchange[0]['exchange_id'] ?>" name="exchange_id" >
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="currency_from">Currency From</label>
                <div class="col-sm-3">
                    <select class="form-control" id="currency_from" name="currency_from">
                        <option value=""></option>
                       <?php
                        foreach ($exchange_name as $exc) {
                            
                            if ($exc['currency_id'] == $exchange[0]['currency_from']) {
                                $checked = 'selected';
                            } else {
                                $checked = '';
                            }
                            echo '<option ' . $checked . ' value="' . $exc['currency_id'] . '">' . $exc['short_form'] . '</option>';
                        }
                        ?>                             
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="currency_to">Currency To</label>
                <div class="col-sm-3">          
                    <input type="hidden" readonly class="form-control" name="currency_to" value="<?php echo $base[0]['currency_id'] ?>" id="currency_to">
                    <input type="text" readonly class="form-control" name="" value="<?php echo $base[0]['short_form'] ?>" id="currency_to">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="rate">Rate</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="rate" value="<?php echo isset($exchange) ? $exchange[0]['exchange_rate'] : '' ?>" id="rate" placeholder="Enter Rate">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="date">Date</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="date" value="<?php echo isset($exchange) ? $exchange[0]['exchange_date'] : '' ?>" id="date" placeholder="Enter Date">
                </div>
                <script type="text/javascript">
                        $(function () {
                            $("#date").datepicker();
                        });
                    </script>
            </div>
                <div class="form-group">
                <label class="control-label col-sm-2" for="remarks">Remarks</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="remarks" value="<?php echo isset($exchange) ? $exchange[0]['remarks'] : '' ?>" id="remarks" placeholder="Enter Remarks">
                </div>
            </div>
            <div class="form-group">
                <div>

                    <label class="control-label col-sm-2" for="status" style="margin-right: 20px">Status </label>
                </div>
                <div style="margin-left: 13px;">
                    <label class="radio-inline">
                        <input type="radio" name="status" <?php echo!isset($exchange) ? 'checked' : '' ?> <?php echo isset($exchange) && ($exchange[0]['status'] == 1) ? 'checked' : '' ?> id="inlineRadio1" value="1"> Active
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="status" id="inlineRadio2" <?php echo isset($exchange) && ($exchange[0]['status'] == 0) ? 'checked' : '' ?> value="0"> Inactive
                    </label>
                </div>

            </div>
            <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;">        
                <div class="col-sm-offset-2 col-sm-10">
                    <button type="submit" name="submit" id="submit" class="btn col-sm-3" style="background-color: #85C51F; margin-right: 10px; padding: 4px; color: white; font-size: 20px;"><b>Save</b></button>                  
                    <a href="<?php echo base_url('main/exchange_rates_list'); ?>" class="btn col-sm-3" style="background-color: #85C51F; padding: 4px; color: white; font-size: 20px;"><b><?php echo (isset($exchange)) ? 'Back' : 'Close' ?></b></a>                                                        
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
        $("#exchange_form").validate({
            rules: {
                currency_from: "required",
                rate: "required",
                date: "required",
            },
            messages: {
                currency_from: "Please Select Currency From !!",
                rate: "Please Enter Rate Field !!",
                date: "Please Select Date Field !!",
            }
        });
    });
</script>
