<style type="text/css">
    .hide_this{
        display: none;
    }
    .sub_cancel{
        text-align: center;
        float: left;
        margin-left: 30%;
        margin-bottom: 20px

    }
</style>
<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Payment</b></h3>
    </div>

    <input type="hidden" id="initilize_value1" value="1">
    <?php // print_r($dis_pay);exit;  ?>
    <div style="margin-top: 5%; margin-left: 15%;">
        <form class="form-horizontal" id="keyword_insert" role="form" method="post" action="<?php echo base_url('home/distribution') ?>">

            <div class="col-sm-3">          
                <input  style="width: 210%; margin-left: 27%" value="<?php echo $dis_pay[0]['pay_id']  ?>"  type="text" readonly class="form-control hide_this" name="dist_rcv_id"  id="pay_id">
            </div>
            <div style="float: left; width: 100%">
                <div class="col-lg-5" style="float: left">

                    <div class="form-group">
                        <label class="control-label col-sm-5" for="" style="margin-left: -33px;padding: 7px">Distribution Number</label>
                        <div class="col-sm-3">          
                            <input  style="width: 210%; margin-left: 27%" value="<?php echo $distribution[0]['distribution_no'] ?>"  type="text" readonly class="form-control" name="dis_number"  id="dis_number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5" for="" style="margin-left: -33px;padding: 7px">Invoice Number</label>
                        <div class="col-sm-3">          
                            <input  style="width: 210%; margin-left: 27%" value="<?php echo $invoice_no[0]['inv_number'] ?>" type="text" readonly class="form-control" name="invoice_number"  id="invoice_number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5" for="" style="margin-left: -33px;padding: 7px">RC Number</label>
                        <div class="col-sm-3">          
                            <input  style="width: 210%; margin-left: 27%" value="<?php echo $rc_name[0]['center_name'] ?>"  type="text" readonly class="form-control" name="rc_number"  id="rc_number">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5" for="" style="margin-left: -33px;padding: 7px">Receive Date </label>
                        <div class="col-sm-3">          
                            <input  style="width: 210%; margin-left: 27%" value="<?php echo $receive_date[0]['receive_date'] ?>"   type="text" readonly class="form-control" name="receive_date"  id="receive_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>
                            <label class="control-label col-sm-4" for="status" style="margin-right: 20px">Status </label>
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
                </div>
                <div class="col-lg-7">                 
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">Payment Date</label>
                        <div class="col-sm-3">          
                            <input style="width: 184%" type="text" readonly required="required" class="form-control" name="payment_date" value="<?php echo date('Y/m/d'); ?>" id="payment_date" placeholder="Payment Date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">Payment Mode</label>
                        <div class="col-sm-2">
                            <select style="width: 320%;" class="form-control col-sm-4" id="payment_mode" name="payment_mode">
                                <option value="">None</option>
                                <?php
//                                print_r($payment_mode);exit;
                                foreach ($payment_mode as $co) {
                                    if ($co['id'] == $dis_pay[0]['pay_mode_id']) {
                                        $checked = 'selected';
                                    } else {
                                        $checked = '';
                                    }
                                    echo '<option ' . $checked . ' value="' . $co['id'] . '">' . $co['payment_mode'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">Payment Currency</label>
                        <div class="col-sm-2">
                            <select style="width: 320%;" class="form-control col-sm-4" id="payment_currency" name="payment_currency">
                                <option value="">None</option>
                                <?php
//                                 print_r($payment_currency);exit;
                                foreach ($payment_currency as $co) {
                                    if ($co['currency_id'] == $dis_pay[0]['pay_currency_id']) {
                                        $checked = 'selected';
                                    } else {
                                        $checked = '';
                                    }
                                    echo '<option ' . $checked . ' value="' . $co['currency_id'] . '">' . $co['currency_name'] . '</option>';
                                }
                                ?>
                            </select>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">Remarks</label>
                        <div class="col-sm-5">     
                            <textarea rows="2" cols="20" class="form-control" name="remarks" id="remarks" placeholder="Remarks Here..." style="min-height: 80px;"> </textarea>
                        </div>
                    </div>
                </div>
                <div style="float: left; width: 115%; margin-left: -15%;">


                    <table class="table table-bordered" id="distribution_wozerd">
                        <tr class="list_header">
                            <th>Product Name</th>                       
                            <th>Product Number</th>    
                            <th>Receive Quantity</th>
                            <th>Price</th>
                            <th>Total</th>
                            <th>Due</th>
                            <th>Paid</th>
                            <th>Action</th>
                        </tr>
                        <?php
//                                    print_r($clientrate[0]['currency_id']);exit;
                        if (isset($receive_dis)) {
//                        print_r($receive_dis);                        exit;
                            $i = 0;
                            foreach ($receive_dis as $value) {
//                            print_r($value['distrcvprod_id']);exit;
                                $this->db->select('prod_id');
                                $this->db->where('distrcvprod_id=' . $value['distrcvprod_id']);
                                $product_name1 = $this->db->get('distribution_receive_product')->result_array();
//                                print_r($product_name1);exit;
                                $this->db->select('id,product_name,code');
                                $this->db->where('id=' . $product_name1[0]['prod_id']);
                                $product_name = $this->db->get('conf_product')->result_array();
//                                print_r($product_name);                                exit;

                                echo ' <tr>
                            <td><input type="text" name="product_name" readonly value="' . $product_name[0]['product_name'] . '"  class="form-control" id="product_id_' . $i . '"/></td>                       
                            <td class="hide_this"><input type="text" name="payprod_id" readonly value="' . $value['pay_prod_id'] . '"  class="form-control" id="payprod_id_' . $i . '"/></td>                        
                            <td><input type="text" name="product_number" readonly value="' . $product_name[0]['code'] . '" class="form-control" id="product_number_' . $i . '"/></td>                       
                            <td><input type="text" name="receive_quantity" readonly value="' . $value['received_qty'] . '" class="form-control" id="receive_quantity_' . $i . '"/></td>
                            <td><input type="text" name="price_single" readonly value="' . $value['price'] . '"  class="form-control" id="price_single_' . $i . '"/></td>
                            <td><input type="text" name="total_price" readonly value="' . $value['total_price'] . '"  class="form-control" id="total_price_' . $i . '" /></td>
                            <td><input type="text" name="due_price" readonly value="' . $value['due_price'] . '" class="form-control" id="due_price_' . $i . '"/></td>
                            <td><input type="number" name="paid_price" value="' . $value['paid_price'] . '" class="form-control" id="paid_price_' . $i . '"/></td>
                            <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                            ';
                                $i++;
                            }
                        }
                        ?>                
                    </table>
                </div>
                <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;" >        
                    <div class="col-sm-offset-2 col-sm-10" style="margin-left: 300px;margin-bottom: 50px; margin-left: 4%;">
                        <button type="button" name="submit" id="update" class="btn col-sm-3 save-button-color" style="width: 300px;"><b>Update</b></button>                  
                        <a href="<?php echo base_url('home/payment_list'); ?>" class="btn col-sm-3 close-button-color" style="margin-right: 10px;"><b>Close</b></a>                                                        
                        <a href="<?php echo base_url('#'); ?>" class="btn col-sm-3 close-button-color" style=""><b><?php echo 'Print' ?></b></a>                                                        
                    </div>
                </div>
        </form>

    </div>

</div>

<script>
    $('#update').on('click', function (e) {
        var wizard = {};
        var wo = {};
        var i = 0;
        wo[0] = $('#dist_rcv_id').val();
        wo[1] = $('#pay_id').val();
        wo[2] = $('#payment_mode').val();
        wo[3] = $('#payment_currency').val();
        $('#distribution_wozerd tr td input,#distribution_wozerd tr td select').each(function () {
            wizard[i] = $(this).val();
            i++;
        });
        var d = {
            wizard: wizard,
            wo: wo
        };
        console.log(d);
        var url = '<?php echo base_url('home/update_payment') ?>';
        $.ajax({
            async: false,
            type: 'post',
            url: url,
            data: {myarray: d},
            success: function (result) {
                console.log(result);

                var url_location = '<?php echo base_url('home/payment_list')  ?>';
                window.location.assign(url_location);
            }

        });
    });
    /* delete row */
    function deleteRow(btn) {
        if (confirm("You want to Delete this row")) {
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
            calculateSum();
        }
    }

</script>
