
<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>New Bank</b></h3>
    </div>
    <div style="margin-top: 5%; margin-left: 2%; margin-bottom: 50px">
        <form class="form-horizontal" id="bank_form" role="form" method="post" action="<?php echo base_url('main/add_currency') ?>">
            <div style="float: left; width: 100%">
                <div class="col-lg-5" style="float: left">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="">Bank</label>
                        <div class="col-sm-8">
                            <input type="text" readonly="readonly" name="" id="bank_name" class="form-control" value="<?php echo (isset($bank_info[0]['bank_name'])) ? $bank_info[0]['bank_name'] : ''; ?>"  placeholder="Enter Bank Name"/>
                        </div>
                    </div>
                </div>
                <?php if (isset($bank_info[0]['id'])) { ?>
                    <input type="hidden" id="bank_id" value="<?php echo $bank_info[0]['id'] ?>"/>
                <?php } ?>
                <div class="form-group">
                    <label class="control-label col-sm-2" for="address">Address</label>
                    <div class="col-sm-3">
                        <textarea class="form-control" name="address"  readonly="readonly" value="" id="bank_address"><?php echo (isset($bank_info[0]['address'])) ? $bank_info[0]['address'] : ''; ?></textarea>
                    </div>
                </div>
            </div>
            <div style="float: left; width: 100%; text-align: center; margin-top: 50px">
                <table class="table table-bordered" id="bank_table">
                    <tr id="table-header" class="list_header">
                    <thead>
                        <th class="hide_this">Branch Id</th>
                        <th>Branch Name</th>
                        <th>Address</th>                      
                        <th>Contact Number</th>
                        <th>Short Code</th>
                        <th>Status</th>
                        <th>Add Account</th>
                    </tr>
</thead>
                    <?php foreach ($branch_info as $value) { ?>
                        <tr>                           
                            <td class="hide_this"><input type="text" name="branch_id" class="form-control example" value="<?php echo $value['id']?>"/></td>
                            <td><input type="text" name="branch_name" class="form-control example" value="<?php echo $value['branch_name']?>"/></td>
                            <td><input type="text" name="address" class="form-control"  value="<?php echo $value['address']?>"/></td>                            
                            <td><input type="text" name="contact_number" class="form-control"  value="<?php echo $value['contact_number']?>"/></td>
                            <td><input type="text" name="short_code" class="form-control"  value="<?php echo $value['short_code']?>"/></td>
                            <td>
                                <select name="" class="form-control">
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select>
                            </td>
                            <td><input type="button" onclick="get_account(<?php echo $value['id']?>)" id=""  class="btn btn-primary" value="Edit Account"></td>
                        </tr>
                    <?php } ?>
                </table>
            </div>

            <div style="float: left; width: 100%">
                <div class="col-lg-7">


                </div>
                <div class="col-lg-5" style="float: right;margin-top: -20px; margin-right: -15px">

                </div>

            </div>
            <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;">        
                <div class="col-sm-offset-2 col-sm-10" style="margin-top: 40px;">
                    <button type="button" name="submit" id="<?php echo(isset($branch)) ? 'update' : 'submit' ?>" class="btn col-sm-3 save-button-color" style=""><b>Save</b></button>                  
                    <a href="<?php echo base_url('main/bank_list'); ?>" class="btn col-sm-3 close-button-color" style=""><b><?php echo (isset($value)) ? 'Back' : 'Close' ?></b></a>                                                        
                </div>
            </div>
        </form>
    </div>
</div>

<div id="rcModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Account Name and Number</h4>
            </div>
            <div class="modal-body">
                <input type="hidden" id='default_account'/>
                <div style="float: left; width: 100%; text-align: center;">
                    <table class="table table-bordered" id="account_table">
                       <thead>
                        <tr class="list_header"> 
                            <th class="hide_this">Branch id</th>
                            <th>Account Name</th>
                            <th>Account Number</th>   
                            <th>Status</th>
                            <!--<th>Action</th>-->                       
                        </tr>                   
</thead>
                    </table>

                </div>                
                <input class="btn btn-success pull-left" type="button" id="add_account_row" value="Add Account" name="add_account"/>
            </div>
            <center> 
                <button type="button" id="add_account" class="btn btn-primary">Save</button>
                <!--<button type="button" id="add_account_row" class="btn btn-primary">Add Account</button>-->

            </center>
            <div class="modal-footer">
                <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>


<script src="<?php echo base_url('assets/js/custom/update_bank.js') ?>"></script>
