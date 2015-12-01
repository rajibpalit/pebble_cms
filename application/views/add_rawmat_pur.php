<style type="text/css">
    .hide_this{
        display: none;
    }
    .form-group{
        width: 49%;
    }
    .form-group label{
        min-width: 30%;
    }
    .form-group .form-control{
        width: 65%!important;
        margin-top: 10px
    }
    td .form-control{
        width: 100%
    }
    .sub_cancel{
        text-align: center;
        float: left;
        margin-left: 30%;
        margin-bottom: 20px

    }
</style>
<div class="container" style="background-color: white;min-height: 600px">
    <?php
    
    ?>
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>
                <?php echo (isset($rawmat_pur)) ? 'Update Material Purchase' : 'New Raw Material Purchase' ?></b></h3>
    </div> 
    <input type="hidden" id="initilize_value" value="<?php echo (isset($inv_product)) ? count($inv_product) : 1 ?>"/>
    <div style="margin-top: 5%; margin-left: 2%;">
        <form class="form-inline" id="invoice_info" role="form" method="POST" action="<?php echo base_url('rawmat_pur/rawmat_from') ?>">
            <?php if (isset($rawmat_pur)) { ?>
                <input type="hidden" name="rmpo_id" id="rmpo_id" value="<?php echo $rawmat_pur[0]['rmpo_id'] ?>"/>
            <?php } ?>
            <div class="form-group">
                <label for="invoice_number">RM PO Number</label>
                <input type="text" class="form-control" id="invoice_number" readonly value="<?php echo (isset($rawmat_pur)) ? $rawmat_pur[0]['po_number'] : '' ?>" name="invoice_number">

            </div>
            <div class="form-group">
                <label for="client_name">Supplier Name*</label>
                <select name="supplier" id="supplier" class="form-control">
                    <option value="">Select Supplier</option>
                    <?php
                    foreach ($suppliers as $supplier) {
                        if(isset($rawmat_pur) && $rawmat_pur[0]['supplier_id']==$supplier['id']){
                            $selected='selected';
                        }
                        else
                        {
                            $selected='';
                        }
                        echo '<option '.$selected.' value="' . $supplier['id'] . '">' . $supplier['supplier_name'] . '</option>';
                    }
                    ?>
                </select>
            </div>

            <div class="form-group">
                <label for="exampleInputName2">Address</label>
                <textarea class="form-control" name="address" id="address" cols="10" rows="2" readonly><?php echo (isset($rawmat_pur)) ? $rawmat_pur[0]['address'] : '' ?></textarea>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo (isset($rawmat_pur)) ? $rawmat_pur[0]['email'] : '' ?>" readonly>

            </div>
            <div class="form-group">
                <label for="contact_no">Contact Number</label>
                <input type="text" class="form-control" id="contact_no" name="contact_no" value="<?php echo (isset($rawmat_pur)) ? $rawmat_pur[0]['contact_no'] : '' ?>"  placeholder="Contact Number" readonly>
            </div>
            <div class="form-group">
                <label for="delivery_date">Expected Delivery Date</label>
                <input type="text" class="form-control" id="delivery_date" value="<?php echo (isset($rawmat_pur)) ? $rawmat_pur[0]['expected_delivery'] : '' ?>" name="delivery_date" placeholder="Expected Delivery Date">
            </div>

            <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks"><?php echo (isset($rawmat_pur)) ? $rawmat_pur[0]['remarks'] : '' ?></textarea>
            </div>                           

        </form>     
        <div style="margin-top: 50px "></div>
        <?php if(!isset($rawmat_pur)){ ?>
        <div style="width: 100%">
            <div class="col-lg-1 pull-right">                
                <input type="button" id="<?php echo (isset($inv_product)) ? 'update_row' : 'add_row' ?>" value="Add Row" class="btn btn-primary"/>
            </div>
        </div>
        <?php }?>
        <table class="table table-bordered" id="bank_table">
            <tr class="list_header">

                <th>Material Name</th>
                <th class="hide_this">raw </th>
                <th>Color</th> 
                <th class="hide_this">Color id</th>
                <th>Size</th>
                <th class="hide_this">size id</th>
                <th>MU Name</th>
                <th>Origin</th>
                <th>Stock Quantity</th>
                <th>Order Quantity</th>
                <th>Unit Price</th>
                <th>Line Price</th>
                <th></th>
                <?php
                if (isset($rawmat_pur_product)) {
                    echo '<th class="hide_this">invoice Product id</th>';
                }
                ?>
            </tr>
            <?php
            if (isset($rawmat_pur_product)) {
                $i = count($rawmat_pur_product) - 1;
                foreach ($rawmat_pur_product as $product) {
                    $this->db->select('keyword_value');
                    $this->db->where('keyword_id', $product['color_id']);
                    $color_name = $this->db->get('conf_keyword')->result_array();

                    $this->db->select('keyword_value');
                    $this->db->where('keyword_id', $product['size_id']);
                    $size_name = $this->db->get('conf_keyword')->result_array();
                    
                    $this->db->select('keyword_value');
                    $this->db->where('keyword_id', $product['m_unit_id']);
                    $mu_name = $this->db->get('conf_keyword')->result_array();
                    ?>
                    <tr>                
                        <td><input type="text" name="" class="form-control " value="<?php echo $product['material_name'];?>" id="name_0" onclick="autocom(this)" onblur="compute_field(this)"/></td>
                        <td class="hide_this"><input type="text" name="" value="<?php echo $product['rawmaterial_id'];?>" class="form-control" id="marialid_0" readonly /></td>
                        <td><input type="text" name="" class="form-control" value="<?php echo $color_name[0]['keyword_value'];?>"  id="color_0" readonly /></td>
                        <td class="hide_this"><input type="text" name="" value="<?php echo $product['color_id'];?>"  class="form-control" id="colorid_0" readonly /></td>
                        <td><input type="text" name="" class="form-control" value="<?php echo $size_name[0]['keyword_value'];?>"  id="size_0" readonly /></td>
                        <td class="hide_this"><input type="text" name="" value="<?php echo $product['size_id'];?>"  class="form-control" id="sizeid_0" readonly /></td>                    
                        <td><input type="text" name="" class="form-control" value="<?php echo $mu_name[0]['keyword_value'];?>"  id="muname_0" readonly /></td>                    
                        <td><input type="text" name="" class="form-control" value="<?php echo $product['origin'];?>"  id="origin_0" /></td>
                        <td><input type="text" name="" class="form-control" value="<?php echo $product['stock_qty'];?>"   id="stockq_0" /></td>
                        <td><input type="text" name="" class="form-control" value="<?php echo $product['order_qty'];?>"  id="orderq_0"  onkeyup="get_line(this)"/></td>                  
                        <td><input type="text" name="" class="form-control" value="<?php echo $product['unit_price'];?>"  id="unit_0" onkeyup="get_line(this)"/></td>
                        <td><input type="text" name="" class="form-control price"  value="<?php echo $product['total_amount'];?>" id="line_0" readonly/></td>
                        <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                        <td class="hide_this"><input type="button" class="btn btn-danger" value="<?php echo $product['id'];?>" /></td>

                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>                
                    <td><input type="text" name="" class="form-control " id="name_0" onclick="autocom(this)" onblur="compute_field(this)"/></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="marialid_0" readonly /></td>
                    <td><input type="text" name="" class="form-control" id="color_0" readonly /></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="colorid_0" readonly /></td>
                    <td><input type="text" name="" class="form-control" id="size_0" readonly /></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="sizeid_0" readonly /></td>                    
                    <td><input type="text" name="" class="form-control" id="muname_0" readonly /></td>                    
                    <td><input type="text" name="" class="form-control" id="origin_0" /></td>
                    <td><input type="text" readonly name="" class="form-control" id="stockq_0" /></td>
                    <td><input type="text" name="" class="form-control" id="orderq_0"  onkeyup="get_line(this)"/></td>                  
                    <td><input type="text" name="" class="form-control" id="unit_0" onkeyup="get_line(this)"/></td>
                    <td><input type="text" name="" class="form-control price" id="line_0" readonly/></td>
                    <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                </tr>
<?php } ?>
        </table>



        <div class="sub_cancel">
            <input type="button" id="<?php echo (isset($rawmat_pur)) ? 'update' : 'submit'; ?>" value="<?php echo (isset($rawmat_pur)) ? 'Update' : 'Submit'; ?>" class="btn btn-primary"/>
            <a href="<?php echo base_url('rawmat_pur') ?>" class="btn btn-success">Cancel</a>
        </div>
    </div>
</div>


<script src="<?php echo base_url('assets/js/custom/add_rawmat_pur.js') ?>"></script> 
