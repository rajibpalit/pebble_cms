<style type="text/css">

    .form-group{
        width: 49%;
    }
    .form-group label{
        width: 30%;
    }
    .form-group .form-control{
        width: 65%!important;
        margin-top: 10px
    }
    td .form-control{
        width: 100%
    }    
    .radio-inline {
        padding-right: 20px;
    }
 
</style>
<div class="container" style="background-color: white;min-height: 600px">
    <?php
    if (isset($invoice)) {
        if ($invoice == 1) {
            $d_sum = $invoice[0]['total_value'] - $invoice[0]['discount_value'];
        } else {
            $discount = ($invoice[0]['discount_value'] / 100) * $invoice[0]['total_value'];
            $d_sum = $invoice[0]['total_value'] - $discount;
        }
    }
    ?>
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>
                <?php echo (isset($invoice)) ? 'Add Work Order' : 'New Invoice' ?></b>
            <span style="float: right;color: #6BCACE"><?php echo(isset($invoice[0]['inv_number'])) ? $invoice[0]['inv_number'] : ''; ?></span>
        </h3>
    </div> 



    <input type="hidden" id="initilize_value" value="<?php echo (isset($inv_product)) ? count($inv_product) : 1 ?>"/>
    <div style="margin-top: 5%; margin-left: 2%;">
        <form class="form-inline" id="invoice_form" name="myform" method="POST" action="<?php echo base_url('home/invoice_from') ?>">

            <!--                  <?php if (isset($invoice)) { ?>
                            
                                    <input type="submit" name="work_order" formaction="google.com" id="work_order" value="Create Work Order" class="btn btn-primary pull-right"/>
                            
            <?php } ?>  -->

            <?php if (isset($invoice)) { ?>
                <input type="hidden" name="inv_number" id="inv_number" value="<?php echo $invoice[0]['inv_id'] ?>"/>
            <?php } ?>                           
            <input type="hidden" class="form-control" id="invoice_number" readonly value="<?php echo (isset($invoice)) ? $invoice[0]['inv_number'] : '' ?>" name="invoice_number">
            <input type="hidden" class="form-control" id="last_invoice" readonly name="last_invoice">
            <div class="form-group">
                <label for="client_name*">Client Name</label>
                <input type="text" class="form-control" id="client_name" required value="<?php echo (isset($invoice)) ? $invoice[0]['client_name'] : '' ?>" placeholder="Client Name" name="client_name">
                <label class="error invoice_error" for="name" id="client_name_error">Please enter the client name.</label>
                <input type="hidden" class="form-control" id="client_id" value="<?php echo (isset($invoice)) ? $invoice[0]['client_id'] : '' ?>" readonly name="client_id">
            </div>
            <div class="form-group">
                <label for="exampleInputName2">Address</label>
                <textarea class="form-control" name="address" id="address" cols="10" rows="2" readonly><?php echo (isset($invoice)) ? $invoice[0]['address'] : '' ?></textarea>
            </div>
            <div class="form-group">
                <label for="currency">Currency</label>
                <input type="text" class="form-control" required id="currency" placeholder="Currency" name="currency"value="<?php echo (isset($invoice)) ? $invoice[0]['currency_name'] : '' ?>" readonly>
                <input type="hidden" class="form-control" id="currency_id" placeholder="Currency" value="<?php echo (isset($invoice)) ? $invoice[0]['currency_id'] : '' ?>" name="currency_id">
            </div>
            <div class="form-group">
                <label for="po_number">PO Number</label>
                <input type="text" class="form-control" required id="po_number" name="po_number" value="<?php echo (isset($invoice)) ? $invoice[0]['po_number'] : '' ?>"  placeholder="PO Number">
                <label class="error invoice_error" for="name" id="po_number_error">Please enter the PO number.</label>
            </div>
            <div class="form-group">
                <label for="b_number">Bank Account Number</label>
                <span id="account_value"><?php echo (isset($invoice)) ? $invoice[0]['ac_number'] : '' ?></span>
                <input type="hidden" class="form-control" value="<?php echo (isset($invoice)) ? $invoice[0]['ac_number'] : '' ?>" id="b_number" name="b_number" placeholder="Bank Account Number">
                <button type="button" id="find_account" class="btn btn-primary " data-toggle="modal" data-target="#myModal">
                    Search Account Number
                </button>
            </div>
            <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks"><?php echo (isset($invoice)) ? $invoice[0]['remarks'] : '' ?></textarea>
            </div>
            <div class="form-group">
                <label for="discount">Discount</label>
                <?php
                if (isset($invoice)) {
                    if ($invoice[0]['discount_type'] == 2) {
                         $checked="Checked";
                    }
                    else{
                         $checked="";
                    }
                }
                else{
                    $checked="Checked";
                }
                ?>
                <span class="radio-inline">
                    <input type="radio" name="discount" <?php echo(isset($invoice[0]['discount_type']) && $invoice[0]['discount_type'] == 0) ? 'Checked' : '' ?> id="inlineRadio1" class="inline_checkbox" value="0"> Percentage
                </span>
                <span class="radio-inline">
                    <input type="radio" name="discount" id="inlineRadio2" <?php echo(isset($invoice[0]['discount_type']) && $invoice[0]['discount_type'] == 1) ? 'Checked' : '' ?> class="inline_checkbox" value="1"> Flat
                </span>
                <span class="radio-inline">
                    <input type="radio" name="discount" id="inlineRadio2" <?php echo  $checked;?> class="inline_checkbox" value="2"> N/A
                </span>
                <label class="error invoice_error" for="name" id="radio_value_error">Please check discount.</label>
            </div>
            <div class="form-group" id="discount_value_group">
                <label for="discount_value">Discount Value</label>
                <input type="text" class="form-control" required id="discount_value" value="<?php echo (isset($invoice)) ? $invoice[0]['discount_value'] : '' ?>" name="discount_value" placeholder="Discount Value">
                <label class="error invoice_error" for="name" id="discount_value_error">Please enter the discount value.</label>
            </div>
            <div class="form-group">
                <label for="total">Total</label>
                <input type="text" class="form-control" name="total" value="<?php echo (isset($invoice)) ? $invoice[0]['total_value'] : '' ?>" id="total" placeholder="" readonly>
            </div>
            <div class="form-group" id="after_discount_group">
                <label for="after_discount">After Discount</label>
                <input type="text" class="form-control" name="after_discount" value="<?php echo (isset($invoice)) ? $d_sum : '' ?>" id="after_discount" readonly>
            </div>
            <?php if (isset($invoice) && empty($inv_id)) { ?>
                <div class="form-group" style="margin-top: 20px">   
                    <input type="submit" required name="work_order" formaction="<?php echo base_url('workorder/save_workorder') ?>" id="work_order" value="Create Work Order" class="btn btn-success"/>
                </div>
            <?php } ?>

        </form>     
        <div style="margin-top: 50px "></div>
        <?php if (empty($inv_id)) { ?>
<!--            <div style="float: right;">
                <div class="col-lg-7">          
                    <input type="button" id="<?php echo (isset($inv_product)) ? 'update_row' : 'add_row' ?>" value="Add Row" class="btn btn-primary"/>
                </div>
            </div>-->
        <?php } ?>
        <table class="table table-bordered" id="bank_table">
            <tr class="list_header">
                <?php
                if (isset($inv_product)) {
                    echo '<th class="hide_this">invoice Product id</th>';
                    echo '<th class="hide_this">invoice id</th>';
                }
                ?>
                <th>Product</th>
                <th class="hide_this">Product_id</th>
                <th>Color</th> 
                <th class="hide_this">Color id</th>
                <th>Size</th>
                <th class="hide_this">size id</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Line Price</th>
                <?php if (empty($inv_id)) { ?>
                    <th></th>
                <?php } ?>
            </tr>
            <?php
            if (isset($inv_product)) {
                $i = count($inv_product) - 1;
                foreach ($inv_product as $product) {

                    $this->db->select('keyword_value');
                    $this->db->where('keyword_id', $product['color_id']);
                    $coror_name = $this->db->get('conf_keyword')->result_array();

                    $this->db->select('keyword_value');
                    $this->db->where('keyword_id', $product['size_id']);
                    $size_name = $this->db->get('conf_keyword')->result_array();
                    ?>
                    <tr>                
                        <td class="hide_this"><input type="text" name="" class="form-control" value="<?php echo $invoice[0]['inv_id']; ?>" id="invoice_<?php echo $i; ?>"/></td>
                        <td class="hide_this"><input type="text" name="" class="form-control" value="<?php echo $product['inv_prod_id']; ?>" id="invproduct_<?php echo $i; ?>"/></td>
                        <td><input type="text" name=""  value="<?php echo $product['prod_name'] ?>" class="form-control " id="name_<?php echo $i; ?>" onclick="autocom(this)" onblur="comput(this)"/></td>
                        <td class="hide_this"><input type="text" value="<?php echo $product['prod_id'] ?>" name="" class="form-control" id="pid_<?php echo $i; ?>" readonly /></td>
                        <td><input type="text" name="" class="form-control" value="<?php echo $coror_name[0]['keyword_value'] ?>"  id="color_<?php echo $i; ?>" readonly /></td>
                        <td class="hide_this"><input type="text" name="" value="<?php echo $product['color_id'] ?>" class="form-control" id="colorid_<?php echo $i; ?>" readonly /></td>
                        <td><input type="text" name="" class="form-control" value="<?php echo $size_name[0]['keyword_value'] ?>" id="size_<?php echo $i; ?>" readonly /></td>
                        <td class="hide_this"><input type="text" name="" value="<?php echo $product['size_id'] ?>" class="form-control" id="sizeid_<?php echo $i; ?>" readonly /></td>
                        <td><input type="text" name="" class="form-control" value="<?php echo $product['quantity'] ?>" id="quantity_<?php echo $i; ?>" onkeyup="get_line(this)"/></td>
                        <td><input type="text" name="" class="form-control" value="<?php echo $product['unit_price'] ?>" id="unit_<?php echo $i; ?>" onkeyup="get_line2(this)"/></td>
                        <td><input type="text" name="" class="form-control price" value="<?php echo $product['line_total'] ?>" id="line_<?php echo $i; ?>" readonly/></td>
                        <?php if (isset($invoice) && empty($inv_id)) { ?>
                            <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                        <?php } ?>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>                
                    <td><input type="text" name="" class="form-control " id="name_0" onclick="autocom(this)" onblur="comput(this)"/></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="pid_0" readonly /></td>
                    <td><input type="text" name="" class="form-control" id="color_0" readonly /></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="colorid_0" readonly /></td>
                    <td><input type="text" name="" class="form-control" id="size_0" readonly /></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="sizeid_0" readonly /></td>
                    <td><input type="text" name="" class="form-control" id="quantity_0" onkeyup="get_line(this)"/></td>
                    <td><input type="text" name="" class="form-control" id="unit_0" onkeyup="get_line2(this)"/></td>
                    <td><input type="text" name="" class="form-control price" id="line_0" readonly/></td>
                    <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                </tr>
            <?php } ?>
        </table>



<!--        <div class="sub_cancel">

            <?php if (empty($inv_id)) { ?>
                <input type="button" id="<?php echo (isset($inv_product)) ? 'update' : 'submit'; ?>" value="<?php echo (isset($inv_product)) ? 'Update' : 'Submit'; ?>" class="btn btn-primary"/>
            <?php } ?>
            <a href="<?php echo base_url('home/invoice') ?>" class="btn btn-success">Cancel</a>
        </div>-->
    </div>
</div>
<!-- Button trigger modal -->

<!-- Modal -->
<div class="modal fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">Modal title</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline">
                    <div class="form-group" style="width: 100%">
                        <label for="bank_name" >Bank Name</label>
                        <!--<input type="text" class="form-control" id="bank_name" name="bank_name" placeholder="Bank Name">-->
                        <select name=""  class="form-control" id="bank_name">
                            <option value="" >Please Select Bank</option>
                            <?php
                            foreach ($banks as $bank) {
                                echo '<option  value="' . $bank['id'] . '">' . $bank['bank_name'] . '</option>';
                            }
                            ?>
                        </select>
                    </div>
                    <div class="form-group" style="width: 100%">
                        <label for="branch_name">Branch Name</label>
                        <!--<input type="text" class="form-control" name="branch_name" id="branch_name" placeholder="Branch Name">-->
                        <select name=""  class="form-control" id="branch_name"></select>
                    </div>
                    <div class="form-group" style="width: 100%">
                        <label for="account_numnber">Account Number</label>
                        <!--<input type="text" class="form-control" name="account_numnber" id="account_numnber" placeholder="Account Number">-->
                        <select name="" class="form-control" id="account_numnber"></select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="button" id="add_account_number" class="btn btn-primary">OK</button>
            </div>
        </div>
    </div>

</div>



<script type="text/javascript">
    $(document).ready(function () {
        $("#client_name").keyup(function () {
            $('#client_name_error').hide();
        });
        $("#po_number").keyup(function () {
            $('#po_number_error').hide();
        });
        $("#discount_value").keyup(function () {
            $('#discount_value_error').hide();
        });
        $("#inlineRadio1").on('change', function () {
            $('#radio_value_error').hide();
        });
        $("#inlineRadio2").on('change', function () {
            $('#radio_value_error').hide();
        });

    })
</script>
<script>
    $('.error').hide();
</script>
<script src="<?php echo base_url('assets/js/custom/add_invoice.js') ?>"></script> 