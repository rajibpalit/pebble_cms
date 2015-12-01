<style type="text/css">
    .hide_this{
        display: none;
    }
    .form-group{
        width: 33%;
        margin-top: 10px;
    }
    .form-group label{
        min-width: 35%;
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
        margin-left: 45%;
        margin-bottom: 20px

    }
</style>
<div class="container" style="background-color: white;min-height: 600px">
    <input type="hidden" id="initilize_value" value="<?php echo (isset($inv_product)) ? count($inv_product) : 1 ?>"/>
    <?php
    if (isset($shipment)) {   
       
       
        $where = array('inv_id' => $shipment[0]['invoice_id']);
        $invoice_info = $this->um->get_data('invoice', $where);
             
        $inv_number = $invoice_info[0]['inv_number'];
        $inv_date = date('Y-m-d', $invoice_info[0]['created_at']);

        $cwhere = array('client_id' => $invoice_info[0]['client_id']);
        $clint_info = $this->um->get_data('conf_client', $cwhere);
        $client_name = $clint_info[0]['client_name'];
    }
    if (isset($invoices)) {
        $inv_number = $invoices[0]['inv_number'];
        $inv_date = date('Y-m-d', $invoices[0]['created_at']);
        $client_name = $invoices[0]['client_name'];
    }
    ?>
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>
                <?php echo (isset($packing)) ? 'Update Packing' : 'New Packing' ?></b>        
        </h3>
    </div> 
    <div style="margin-top: 5%; margin-left: 2%;">
        <form class="form-inline" id="packing_info" name="myform" method="POST" action="<?php echo base_url('shipment/save_shipment') ?>">                           
            <?php if (isset($shipment)) { ?>
            <input type="hidden" name="shimpment_id" value="<?php echo $shipment[0]['ship_id'] ?>"/>
            <?php } ?>
            <div class="form-group">
                <label for="inv_number">Invoice Number</label>
                <input type="text" name="invoice_namber" id="inv_number" value="<?php echo $inv_number; ?>" class="form-control" readonly/>                        
            </div>
            <input type="hidden" value="<?php echo(isset($invoices[0]['inv_id'])) ? $invoices[0]['inv_id'] : '' ?>" id="invoice_id" name="invoice_id"/>
            <div class="form-group">
                <label for="inv_number">Invoice Date</label>
                <input type="text" id="inv_date"  value="<?php echo $inv_date ?>" readonly class="form-control"/>                        
            </div>

            <div class="form-group">
                <label for="client_name">Client Name</label>
                <input type="text" class="form-control" id="client_name"  value="<?php echo $client_name ?>" readonly placeholder="Client Name" name="client_name" value="" >                     

            </div>
            <div class="form-group">
                <label for="ship_mode">Shipment Mode</label>
                <select class="form-control" name="ship_mode" required id="packing_size">
                    <option value="">Please Select Shipment Mode</option>
                    <?php
                    foreach ($shipment_mode as $shipment3) {
                        if (isset($shipment[0]['ship_mode_id'])) {
                            if ($shipment[0]['ship_mode_id'] == $shipment3['keyword_id']) {
                                $check = 'selected';
                            }
                        } else {
                            $check = '';
                        }
                        echo '<option ' . $check . ' value="' . $shipment3['keyword_id'] . '"> ' . $shipment3['keyword_value'] . ' </option>';
                    }
                    ?>
                </select>             

            </div>

            <div class="form-group">
                <label for="cargo">Vessel/Cargo</label>
                <input type="text" name="cargo" id="cargo" value="<?php echo (isset($shipment)) ? $shipment[0]['vessel_cargo'] : '' ?>" class="form-control"/>                        
            </div>
            <div class="form-group">
                <label for="ercno">ERC No.</label>
                <input type="text" name="ercno" id="ercno" value="<?php echo (isset($shipment)) ? $shipment[0]['erc_no'] : '' ?>"  class="form-control"/>                        
            </div>
            <div class="form-group">
                <label for="exportno">Export No</label>
                <input type="text" name="exportno" id="exportno" value="<?php echo (isset($shipment)) ? $shipment[0]['export_no'] : '' ?>"   class="form-control"/>                        
            </div>
            <div class="form-group">
                <label for="exportdate">Export Date</label>
                <input type="text" id="exportdate"  value="<?php echo (isset($shipment)) ? $shipment[0]['export_date'] : '' ?>"  name="exportdate"  class="form-control"/>                        
            </div>

            <div class="form-group">
                <label for="insurence">Insurance Company</label>
                <select class="form-control" required name="insurence" id="insurnce">
                    <option value="">Please Select Insurance Company</option>
                    <?php
                    foreach ($insurance_company as $icom) {

                        if (isset($shipment[0]['insurance_company_id'])) {
                            if ($shipment[0]['insurance_company_id'] == $icom['id']) {
                                $check = 'selected';
                            }
                        } else {
                            $check = '';
                        }

                        echo '<option ' . $check . ' value="' . $icom['id'] . '"> ' . $icom['company_name'] . ' </option>';
                    }
                    ?>
                </select>             

            </div>
            <div class="form-group">
                <label for="certification">Insurance Certificate No.</label>
                <input type="text" class="form-control" id="certification"  name="certification" value="<?php echo (isset($shipment)) ? $shipment[0]['insurance_cert_no'] : '' ?>" >
            </div>

            <div class="form-group">
                <label for="freight">Freight Term</label>
                <select class="form-control" required name="freight" id="freight">
                    <option value="">Please Select freight Term</option>
                    <?php
                    foreach ($freight_term as $fterm) {
                        if (isset($shipment[0]['insurance_company_id'])) {
                            if ($shipment[0]['freight_term_id'] == $fterm['keyword_id']) {
                                $check = 'selected';
                            }
                        } else {
                            $check = '';
                        }


                        echo '<option ' . $check . ' value="' . $fterm['keyword_id'] . '"> ' . $fterm['keyword_value'] . ' </option>';
                    }
                    ?>
                </select> 
            </div>
            <div class="form-group">
                <label for="sales">Sales Term</label>
                <input type="text" name="sales" id="sales" value="<?php echo (isset($shipment)) ? $shipment[0]['sales_term'] : '' ?>"  class="form-control"/>                        
            </div>
            <div class="form-group">
                <label for="container">Container No.</label>
                <input type="text" name="container" id="container" value="<?php echo (isset($shipment)) ? $shipment[0]['container_no'] : '' ?>"   class="form-control"/>                        
            </div>
            <div class="form-group">
                <label for="mode">Mode</label>
                <input type="text" name="mode" id="mode" value="<?php echo (isset($shipment)) ? $shipment[0]['mode'] : '' ?>"  class="form-control"/>                        
            </div>
            <div class="form-group">
                <label for="exportdate">Seal No.</label>
                <input type="text" id="sale_no"  name="sale_no" value="<?php echo (isset($shipment)) ? $shipment[0]['seal_no'] : '' ?>"  class="form-control"/>                        
            </div>

            <div class="form-group">
                <label for="counrty">Country of Origin</label>
                <select class="form-control" required name="counrty" id="counrty">
                    <option value="">Please Select Size</option>
                    <?php
                    foreach ($country as $cont) {

                      if (isset($shipment[0]['country_of_origin_id'])) {
                            if ($shipment[0]['country_of_origin_id'] == $cont['keyword_id'] ) {
                                $check = 'selected';
                            }
                        } else {
                            if($cont['keyword_value']=='Bangladesh'){
                           $check = 'selected';
                        }else{
                             $check = '';
                        }
                        }
                        echo '<option '.$check.'  value="' . $cont['keyword_id'] . '"> ' . $cont['keyword_value'] . ' </option>';
                    }
                    ?>
                </select>             

            </div>

            <div class="form-group">
                <label for="port_origin">Port of Origin</label>
                <input type="text" name="port_origin" id="port_origin" value="<?php echo (isset($shipment)) ? $shipment[0]['port_of_origin'] : '' ?>"  class="form-control"/>                        
            </div>
            <div class="form-group">
                <label for="port_dest">Port of Destination</label>
                <input type="text" name="port_dest" id="port_dest" value="<?php echo (isset($shipment)) ? $shipment[0]['port_of_destination'] : '' ?>"   class="form-control"/>                        
            </div>
            <div class="form-group">
                <label for="total_gross">Total gross weight(kg)</label>
                <input type="text" name="total_gross" id="total_gross" value="<?php echo (isset($shipment)) ? $shipment[0]['total_gross_wt'] : '' ?>"  class="form-control"/>                        
            </div>
            <div class="form-group">
                <label for="total_net">Total Net weight(kg)</label>
                <input type="text" id="total_net"  name="total_net" value="<?php echo (isset($shipment)) ? $shipment[0]['total_net_wt'] : '' ?>"   class="form-control"/>                        
            </div>
            <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks"><?php echo (isset($shipment)) ? $shipment[0]['remarks'] : '' ?> </textarea>
            </div>


        </form>     
        <div style="margin-top: 50px "></div>


        <table class="table table-bordered" id="bank_table">
            <tr class="list_header">


                <th>HS Code</th>               

                <th>Box Number</th> 

                <th>Agent</th>               

                <th>Shipped on Board</th>                
                <th>Track No.</th>
                <th>Dimension ‐ Length</th>
                <th>Dimension ‐ Width</th>               
                <th>Dimension – Height</th>                             
                <th>Dimension ‐ Unit</th>                             
                <th>Weight ‐ Gross</th>                             
                <th>Weight – Net</th>                             
                <th>Weight – Unit</th>                             
                <th></th>

                <?php
                if (isset($shipment_box)) {
                    echo '<th class="hide_this">packing product</th>';
                }
                ?>

            </tr>
            <?php
            if (isset($shipment_box)) {             
                $i = 0;
                foreach ($shipment_box as $value) {
                
                    ?>
                    <tr>                                        
                        <td><input type="text" name="" class="form-control " value="<?php echo $value['hs_code']?>"  id="hscode_<?php echo $i ?>" /></td>                                       
                        <td><input type="text" name=""  class="form-control"  value="<?php echo $value['box_number']?>" id="boxnum_<?php echo $i ?>"  /></td>                                       
                        <td><input type="text" name="" class="form-control"  value="<?php echo $value['agent_name']?>" id="agent_<?php echo $i ?>"  /></td>                      
                        <td><input type="text" name="" class="form-control"  value="<?php echo $value['shipped_on_board']?>" id="shipping_<?php echo $i ?>"  onfocus="get_date(this)"/></td>
                        <td><input type="text" name="" class="form-control"  value="<?php echo $value['track_number']?>" id="track_<?php echo $i ?>"  /></td>                                   
                        <td><input type="text" name="" class="form-control"  value="<?php echo $value['dimension_length']?>" id="length_<?php echo $i ?>" /></td>
                        <td><input type="text" name="" class="form-control"  value="<?php echo $value['dimension_width']?>" id="width_<?php echo $i ?>"  /></td>
                        <td><input type="text" name="" class="form-control "  value="<?php echo $value['dimension_height']?>" id="height_<?php echo $i ?>"/></td>
                        <td><input type="text" name="" class="form-control " value="<?php echo $value['dimension_unit']?>"  id="unit_<?php echo $i ?>" /></td>
                        <td><input type="text" name="" class="form-control "  value="<?php echo $value['weight_gross']?>" id="gross_<?php echo $i ?>" onkeyup="get_gross()"/></td>
                        <td><input type="text" name="" class="form-control "  value="<?php echo $value['weight_net']?>" id="net_<?php echo $i ?>" onkeyup="get_net()"/></td>
                        <td><input type="text" name="" class="form-control "  value="<?php echo $value['weight_unit']?>" id="unit_<?php echo $i ?>" /></td>
                        <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                        <td class="hide_this"><input type="text" name="" class="form-control "  value="<?php echo $value['ship_box_id']?>" id="unit_<?php echo $i ?>" /></td>
                    </tr>

                    <?php
                    $i++;
                }
            } else {
                $i = 0;
                foreach ($invoi_pro as $value) {
                    ?>
                    <tr>                

                        <td><input type="text" name="" class="form-control "  id="hscode_<?php echo $i ?>" /></td>                                       
                        <td><input type="text" name="" value="<?php echo $value['box_number'] ?>" class="form-control"id="boxnum_<?php echo $i ?>"  /></td>                                       
                        <td><input type="text" name="" class="form-control"  id="agent_<?php echo $i ?>"  /></td>                      
                        <td><input type="text" name="" class="form-control"  id="shipping_<?php echo $i ?>"  onfocus="get_date(this)"/></td>
                        <td><input type="text" name="" class="form-control"  id="track_<?php echo $i ?>"  /></td>                                   
                        <td><input type="text" name="" class="form-control" id="length_<?php echo $i ?>" /></td>
                        <td><input type="text" name="" class="form-control"  id="width_<?php echo $i ?>"  /></td>
                        <td><input type="text" name="" class="form-control "  id="height_<?php echo $i ?>"/></td>
                        <td><input type="text" name="" class="form-control " id="unit_<?php echo $i ?>" /></td>
                        <td><input type="text" name="" class="form-control gross" id="gross_<?php echo $i ?>" onkeyup="get_gross()"/></td>
                        <td><input type="text" name="" class="form-control net"  id="net_<?php echo $i ?>"  onkeyup="get_net()"/></td>
                        <td><input type="text" name="" class="form-control "  id="unit_<?php echo $i ?>" /></td>
                        <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                    </tr>

                    <?php
                    $i++;
                }
            }
            ?>
        </table>

        <center> <h3>Shipment Product</h3></center>

        <table class="table table-bordered" id="product_table">
            <tr class="list_header">                   
                <th>Box Number</th> 
                <th>Product Number</th>               
                <th>Product Name</th>                               
                <th>Quantity</th>


            </tr>
            <?php
            foreach ($packnot_pro as $value) {
                $pcon = array('pack_id' => $value['pack_id']);
                $box_num = $this->um->get_data('packingnote', $pcon);

                $pdcon = array('id' => $value['prod_id']);
                $product = $this->um->get_data('conf_product', $pdcon);
                ?>
                <tr>                

                    <td><input type="text" readonly name="" class="form-control " value=" <?php echo $box_num[0]['box_number'] ?>"  id="hscode_0" /></td>                                       
                    <td><input type="text" readonly name="" class="form-control"  value=" <?php echo $product[0]['code'] ?>" id="boxnum_0"  /></td>                                       
                    <td><input type="text" readonly name="" class="form-control"  value=" <?php echo $product[0]['product_name'] ?>" id="agent_0"  /></td>                      

                    <td><input type="text" name="" class="form-control" value=" <?php echo $value['pack_qty'] ?>"  id="track_0"  /></td>    
                </tr>
            <?php } ?>
        </table>        
        <div class="sub_cancel">

            <input type="button" id="<?php echo (isset($shipment)) ? 'update' : 'submit'; ?>" value="<?php echo (isset($shipment)) ? 'Update' : 'Submit'; ?>" class="btn btn-primary"/>
            <a href="<?php echo base_url('shipment') ?>" class="btn btn-success">Cancel</a>
        </div>
    </div>
</div>


<script src="<?php echo base_url('assets/js/custom/add_shipment.js') ?>"></script> 
