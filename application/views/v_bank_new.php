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
                        <th>Branch Name</th>
                        <th>Address</th>                      
                        <th>Contact Number</th>
                        <th>Short Code</th>
                        <th>Status</th>
                        <th>Add Account</th>
                    </tr>
                </table>
            </div>

            <div style="float: left; width: 100%">
                <div class="col-lg-7">
                    <a  onclick="add_branch()" id="<?php echo(isset($branch)) ? 'add_row2' : 'add_row' ?>" style="margin-left: -14px; background-color: #6BCACE; width: auto;padding-bottom: 8px; border-radius:5px;cursor: pointer" class="control-label col-sm-2" for="">Add Branch</a>

                </div>
                <div class="col-lg-5" style="float: right;margin-top: -20px; margin-right: -15px">

                </div>

            </div>
            <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;">        
                <div class="col-sm-offset-2 col-sm-10" style="margin-top: 40px;">
                    <a href="<?php echo base_url('bank'); ?>" name="submit" id="submit" class="btn col-sm-3 save-button-color" style=""><b>Save</b></a>                  
                    <a href="<?php echo base_url('bank'); ?>" class="btn col-sm-3 close-button-color" style=""><b><?php echo (isset($value)) ? 'Back' : 'Close' ?></b></a>                                                        
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
                <div style="float: left; width: 100%; text-align: center;">
                    <table class="table table-bordered" id="account_table">
                        <thead>
                        <tr class="list_header"> 
                            <th class="hide_this">Branch id</th>
                            <th>Account Name</th>
                            <th>Account Number</th>                       
                            <th>Action</th>                       
                        </tr>                   
                        </thead>
                    </table>

                </div>                
                <input class="btn btn-success pull-left" type="button" id="add_account_row" value="Add Account" name="add_account"/>
            </div>
            <center> 
                <button type="button" id="add_account" class="btn btn-primary">Save</button>
                
            </center>
            <div class="modal-footer">
                <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div id="bModal" class="modal fade" role="dialog">
    <div class="modal-dialog" style="width: auto">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Branch Information</h4>
            </div>
            <div class="modal-body">
                <div style="float: left; width: 100%; text-align: center; margin-top: 50px">
                    <table class="table table-bordered" id="branch_table">
                        <tr class="list_header">  
                            <th class="hide_this"></th>
                            <th>Branch Name</th>
                            <th>Address</th>                           
                            <th>Contact Number</th>
                            <th>Short Code</th>
                            <th>Status</th>                      
                        </tr>                   
                        <tr>                
                            <?php if (isset($bank_info[0]['id'])) { ?>
                            <td class="hide_this"> <input  type="text"  name="bank_id" id="bank_id" value="<?php echo $bank_info[0]['id'] ?>"/></td>
                            <?php } ?>
                            <td><input type="text" id="branch_name" name="branch_name" class="form-control example" /></td>
                            <td><input type="text" id="branch_address" name="address" class="form-control"/></td>
                          
                            <td><input type="text" id="branch_contact" name="contact_number" class="form-control"/></td>
                            <td><input type="text" id="branch_short_code" name="short_code" class="form-control"/></td>
                            <td><select name="" id="branch_status" class="form-control">
                                    <option selected value="1">Active</option>
                                    <option value="0">Inactive</option>
                                </select></td>                  
                        </tr>                  
                    </table>

                </div>                

            </div>
            <center> 
                <button type="button" id="add_branch" class="btn btn-primary">Save</button>
                <input type="reset" value="Reset" class="btn btn-default"/>
            </center>
            <div class="modal-footer">
                <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>

<script src="<?php echo base_url('assets/js/custom/bank.js') ?>"></script>
