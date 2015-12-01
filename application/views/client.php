


<style>
    #commentForm {
        width: 500px;
    }
    #commentForm label {
        width: 250px;
    }
    #commentForm label.error, #commentForm input.submit {
        margin-left: 253px;
    }
    #signupForm {
        width: 670px;
    }
    #signupForm label.error {
        margin-left: 10px;
        width: auto;
        display: inline;
    }
    #newsletter_topics label.error {
        display: none;
        margin-left: 103px;
    }
    .hide_this{
        display: none;
    }
     .required:after { content:"*"; color: red; }
</style>

<div class="container" id="client_form" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Client</b></h3>
    </div>

    <?php // print_r($keywords);    ?>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="keyword_insert" role="form" method="post" action="<?php echo base_url('main/add_client') ?>">
            <?php if (isset($keywords)) { ?>
                <input type="hidden" value="<?php echo $keywords[0]['client_id'] ?>" name="client_id" >
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-sm-2 required" for="client_name">Client Name</label>
                <div class="col-sm-3">          
                    <input type="text"  class="form-control" name="client_name" value="<?php echo isset($keywords) ? $keywords[0]['client_name'] : '' ?>" id="client_name" placeholder="Enter Client Name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact_name">Contact Name</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="contact_name" required value="<?php echo isset($keywords) ? $keywords[0]['contact_name'] : '' ?>" id="contact_name" placeholder="Enter Contact Name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="shipping_address">Shipping Address</label>
                <div class="col-sm-3">          
                    <textarea class="form-control" name="shipping_address" id="shipping_address" placeholder="Enter Shipping Address"><?php echo isset($keywords) ? $keywords[0]['shipping_address'] : '' ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="mobile_no">Mobile Number</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="mobile_no" value="<?php echo isset($keywords) ? $keywords[0]['mobile_no'] : '' ?>" id="mobile_no" placeholder="Enter Moblie No.">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="home_phone">Home Phone</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="home_phone" value="<?php echo isset($keywords) ? $keywords[0]['home_phone'] : '' ?>" id="home_phone" placeholder="Enter Home Phone">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="email">Email</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="email" value="<?php echo isset($keywords) ? $keywords[0]['email'] : '' ?>" id="email" placeholder="Enter Email">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="vat_no">VAT no.</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="vat_no" value="<?php echo isset($keywords) ? $keywords[0]['vat_no'] : '' ?>" id="vat_no" placeholder="Enter VAT No.">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2 required" for="country">Country</label>
                <div class="col-sm-3">
                    <select class="form-control" id="country" required="" name="country">

                        <?php
                        foreach ($countrys as $country) {
                            if ($country['keyword_id'] == $keywords[0]['country']) {
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
                <label class="control-label col-sm-2" for="currency">Currency</label>
                <div class="col-sm-3">
                    <input type="text" readonly name="currency" value="<?php echo isset($keywords) ? $keywords[0]['currency_name'] : '' ?>" id="currency" class="form-control">
                    <input type="text" name="currency_id"  value="<?php echo isset($keywords) ? $keywords[0]['currency_id'] : '' ?>" id="currency_id" class="form-control hide_this">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="prefix">Prefix For Index</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" required name="prefix" value="<?php echo isset($keywords) ? $keywords[0]['invoice_prefix'] : '' ?>" id="prefix" placeholder="Enter Prefix for Index">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="last_invoice">Last Invoice Generated </label>
                <div class="col-sm-3">          
                    <input readonly type="text" class="form-control" name="last_invoice" value="<?php echo isset($keywords) ? $keywords[0]['last_invoice'] : '0' ?>" id="last_invoice">
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
                    <button type="submit" name="submit" id="submit" class="btn col-sm-3" style="background-color: #85C51F; margin-right: 10px; padding: 4px; color: white; font-size: 20px;"><b><?php echo (isset($keywords)) ? 'Update' : 'Save' ?></b></button>                  
                    <a href="<?php echo base_url('main/client_list'); ?>" class="btn col-sm-3" style="background-color: #85C51F; padding: 4px; color: white; font-size: 20px;"><b><?php echo (isset($keywords)) ? 'Back' : 'Close' ?></b></a>                                                        
                </div>
            </div>
        </form>
    </div>
</div>
<script>

    $(document).ready(function () {
        $('#country').on('change', function () {
            var key_id = $(this).val();
            var url = '<?php echo site_url('main/ajax_data') ?>';
            $.ajax({
                type: "POST",
                url: url, //Relative or absolute path to response.php file
                data: 'id=' + key_id,
                dataType: "json",
                success: function (data) {
                    $('#currency').val(data.currency_name);
                    $('#currency_id').val(data.currency_id);

                }
            });
        });
    });
</script>


<!--<script>

    $("#client_form").validate();

    $().ready(function () {

        // validate signup form on keyup and submit
        $("#keyword_insert").validate({
            rules: {
                client_name: "required",
                contact_name: "required",
                prefix: "required",
            },
            messages: {
                client_name: "Please Enter Client Name.",
                contact_name: "Please Enter Contact Name.",
                prefix: "Please Enter Prefix For Index.",
            }
        });

    });
</script>-->
