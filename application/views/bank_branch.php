<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Bank Branch</b></h3>
    </div>

    <?php
//    echo '<pre>';
//    print_r($countrys);
//    echo '</pre>';
    ?>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="keyword_insert" role="form" method="post" action="<?php echo base_url('main/add_bank_branch') ?>">
            <?php if (isset($keywords)) { ?>
                <input type="hidden" value="<?php echo $keywords[0]['bank_branch_id'] ?>" name="bank_id" >
            <?php } ?>
                 <div class="form-group">
                <label class="control-label col-sm-2" for="bank_id">Bank Name</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="bank_id" value="<?php echo isset($keywords) ? $keywords[0]['bank_id'] : '' ?>" id="client_name" placeholder="Enter Bank id">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="branch_name">Branch Name</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="branch_name" value="<?php echo isset($keywords) ? $keywords[0]['branch_name'] : '' ?>" id="client_name" placeholder="Enter Branch Name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="address">Address</label>
                <div class="col-sm-3">          
                    <textarea class="form-control" name="address" id="shipping_address" placeholder="Enter Address"><?php echo isset($keywords) ? $keywords[0]['address'] : '' ?></textarea>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="account_name">Account Name</label>
                <div class="col-sm-3">
                    <input type="text"  name="account_name" id="account_name" value="<?php echo isset($keywords) ? $keywords[0]['account_name'] : '' ?>" class="form-control" placeholder="Enter Account Name"> 
                </div>
            </div>
                   <div class="form-group">
                <label class="control-label col-sm-2" for="account_number">Account Number</label>
                <div class="col-sm-3">
                    <input type="text"  name="account_number" id="account_no" value="<?php echo isset($keywords) ? $keywords[0]['account_number'] : '' ?>" class="form-control" placeholder="Enter Account Number"> 
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="short_code">Short Code</label>
                <div class="col-sm-3">          
                    <input type="text" class="form-control" name="short_code" value="<?php echo isset($keywords) ? $keywords[0]['short_code'] : '' ?>" id="prefix" placeholder="Enter Short Code">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="contact_number">Contact Number   </label>
                <div class="col-sm-3">          
                    <input  type="text" class="form-control" name="contact_number" value="<?php echo isset($keywords) ? $keywords[0]['contact_number'] : '' ?>" placeholder="Enter Contact Number">
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
                    <a href="<?php echo base_url('main/bank_branch_list'); ?>" class="btn col-sm-3" style="background-color: #85C51F; padding: 4px; color: white; font-size: 20px;"><b><?php echo (isset($keywords)) ? 'Back' : 'Close' ?></b></a>                                                        
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
                dataType:"json",
                success: function (data) {
                    var name=data.currency_name;
                    $('#currency').val(name);
                    
                }
            });
        });
    });
</script>
