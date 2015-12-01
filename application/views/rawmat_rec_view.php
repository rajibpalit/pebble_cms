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


    if (isset($rawmat_pur_edit)) {
        $rmpo_id = $rawmat_pur_edit[0]['rmpo_id'];

        $supplier_name = $client_info[0]['supplier_name'];
        $address = $client_info[0]['address'];
        $email = $client_info[0]['email'];
        $contact = $client_info[0]['phone_no'];

        $rcv_number = $rawmat_pur_edit[0]['rcv_number'];
        $po_number = $rawmat_pur_edit[0]['po_number'];
        $po_date = $rawmat_pur_edit[0]['po_date'];
        $expected_delivery = $rawmat_pur_edit[0]['expected_delivery'];
        $remarks = $rawmat_pur_edit[0]['remarks'];
    } else {
        $rmpo_id = $rawmat_pur[0]['rmpo_id'];


        $supplier_name = $rawmat_pur[0]['supplier_name'];
        $address = $rawmat_pur[0]['address'];
        $email = $rawmat_pur[0]['email'];
        $contact = $rawmat_pur[0]['phone_no'];

        $rcv_number = $rawmat_pur[0]['last'];
        $po_number = $rawmat_pur[0]['po_number'];
        $po_date = $rawmat_pur[0]['created_at'];
        $expected_delivery = $rawmat_pur[0]['expected_delivery'];
        $remarks = $rawmat_pur[0]['remarks'];
    }
    ?>
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>
                <?php echo (isset($rawmat_pur_edit)) ? 'View Material Purchase' : 'New Raw Material Purchase' ?></b></h3>
    </div> 
    <input type="hidden" id="initilize_value" value="<?php echo (isset($inv_product)) ? count($inv_product) : 1 ?>"/>
    <div style="margin-top: 5%; margin-left: 2%;">
        <form class="form-inline" id="invoice_info" role="form" method="POST" action="<?php echo base_url('rawmat_rec/rawmat_from') ?>">
            <?php if (isset($rawmat_pur_edit)) { ?>
                <input type="hidden" name="rmrcv_id" value="<?php echo $rawmat_pur_edit[0]['rmrcv_id'] ?>"/>
            <?php } ?>
            <input type="hidden" name="rmpo_id" id="rmpo_id" value="<?php echo $rmpo_id ?>"/>

            <div class="form-group">
                <label for="invoice_number">RM Receive Number</label>
                <input type="text" class="form-control" id="invoice_number" readonly value="<?php echo $rcv_number ?>" name="rawmat_rec_no">
            </div>
            <div class="form-group">
                <label for="client_name">Supplier Name</label>

                <input type="text" class="form-control" id="supplier_name" readonly value="<?php echo $supplier_name ?>" name="supplier_name">
            </div>
            <div class="form-group">
                <label for="exampleInputName2">Address</label>
                <textarea class="form-control" name="address" id="address" cols="10" rows="2" readonly><?php echo $address ?></textarea>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="text" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo $email ?>" readonly>
            </div>
            <div class="form-group">
                <label for="contact_no">Contact Number</label>
                <input type="text" class="form-control" id="contact_no" name="contact_no" value="<?php echo $contact ?>"  placeholder="Contact Number" readonly>
            </div>
            <div class="form-group">
                <label for="invoice_number">RM PO Number</label>
                <input type="text" class="form-control" id="invoice_number" readonly value="<?php echo $po_number ?>" name="po_number">
            </div>
            <div class="form-group">
                <label for="invoice_number">PO Date</label>
                <input type="text" class="form-control" id="invoice_number" readonly value="<?php echo $po_date ?>" name="po_date">
            </div>
            <div class="form-group">
                <label for="delivery_date">Expected Delivery Date</label>
                <input type="text" class="form-control" id="expected_delivery_date" value="<?php echo $expected_delivery ?>" name="delivery_date" readonly>
            </div>
            <div class="form-group">
                <label for="delivery_date">Challan No.</label>
                <input type="text" class="form-control" id="challan_no" value="<?php echo (isset($rawmat_pur_edit)) ? $rawmat_pur_edit[0]['challan_number'] : '' ?>" name="challan_no" readonly>
            </div>
            <div class="form-group">
                <label for="delivery_date">Challan Date.</label>
                <input type="text" class="form-control" id="challan_date" value="<?php echo (isset($rawmat_pur_edit)) ? $rawmat_pur_edit[0]['challan_date'] : '' ?>" name="challan_date"  readonly>
            </div>

            <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks" readonly><?php echo $remarks ?></textarea>
            </div>                           

        </form>     
        <div style="margin-top: 50px "></div>

        <table class="table table-bordered" id="bank_table">
            <tr class="list_header">

                <th>Material Number</th>
                <th>Material Name</th>

                <th>Color</th> 

                <th>Size</th>

                <th>MU Name</th>

                <th>Received Qut</th>
                <th>Receive Qut</th>
                <th>Batch No</th>
                <th>Expire Date</th>

                <?php
                if (isset($rawmat_pur_edit)) {
                    echo '<th class="hide_this">invoice Product id</th>';
                }
                ?>
            </tr>
            <?php
     
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
                        <td><input type="text" name="" class="form-control " value="<?php echo $product['material_code']; ?>" id="name_0" readonly/></td>
                        <td><input type="text" name="" class="form-control " value="<?php echo $product['material_name']; ?>" id="name_0" readonly/></td>

                        <td><input type="text" name="" class="form-control" value="<?php echo $color_name[0]['keyword_value']; ?>"  id="color_0" readonly /></td>

                        <td><input type="text" name="" class="form-control" value="<?php echo $size_name[0]['keyword_value']; ?>"  id="size_0" readonly /></td>

                        <td><input type="text" name="" class="form-control" value="<?php echo $mu_name[0]['keyword_value']; ?>"  id="muname_0" readonly /></td>
                        <td><input type="text" name="" class="form-control"   id="recived_0" value="<?php echo $product['received_qty']; ?>" readonly/></td>
                        <td><input type="text" name="" class="form-control"  id="recive_0" value="<?php echo $product['receive_qty']; ?>" readonly/></td>
                        <td><input type="text" name="" class="form-control"  id="batch_0"  value="<?php echo $product['batch_no']; ?>" readonly/></td>
                        <td><input type="text" name="" class="form-control "   id="expired_<?php echo $i?>" value="<?php echo $product['expiry_date']; ?>" readonly/></td>
                        <td class="hide_this"><input type="text" class="form-control" value="<?php echo $product['rawmaterial_id']; ?>" /></td>

                    </tr>
                    <?php
                }
           
            ?>
        </table>
        <div class="sub_cancel">

            <a href="<?php echo base_url('rawmat_rec') ?>" class="btn btn-success">Cancel</a>
        </div>

    </div>
</div>


<!--<script src="--><?php //echo base_url('assets/js/custom/add_rawmat_rec.js') ?><!--"></script> -->
