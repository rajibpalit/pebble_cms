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
        <h3><b>Distribution Receive</b></h3>
    </div>

    <input type="hidden" id="initilize_value1" value="1">
    <?php // print_r($distribution); exit;?>
    <div style="margin-top: 5%; margin-left: 15%;">
        <form class="form-horizontal" id="keyword_insert" role="form" method="post" action="<?php echo base_url('home/distribution') ?>">
            <!--<div class="col-sm-3">-->          
            <input  style="width: 210%; margin-left: 27%" type="text" readonly value="<?php echo $distribution[0]['distribution_id'] ?>" class="form-control hide_this" name="distribution_id"  id="distribution_id">
            <!--</div>-->
            <div style="float: left; width: 100%">
                <div class="col-lg-5" style="float: left">
                    <div class="form-group">
                        <label class="control-label col-sm-5" for="" style="margin-left: -33px;padding: 7px" >Work order Number</label>
                        <div class="col-sm-3">          
                            <input  style="width: 210%; margin-left: 27%" type="text" readonly value="<?php echo $workorder_no[0]['workorder_no'] ?>" class="form-control" name="wo_number"  id="wo_number">

                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5" for="" style="margin-left: -33px;padding: 7px">Invoice Number</label>
                        <div class="col-sm-3">          
                            <input  style="width: 210%; margin-left: 27%" type="text" readonly value="<?php echo $invoice_no[0]['inv_number'] ?>"class="form-control" name=""  id="inv_number">

                        </div>
                    </div>

                    <div class="form-group">
                        <label class="control-label col-sm-5"   style="margin-left: -33px;padding: 7px" for="">Remarks</label>
                        <div class="col-sm-5">     
                            <textarea style="width: 109%; margin-left: 13%" rows="2" cols="20" class="form-control" name="remarks" id="remarks"> Remarks Here...</textarea>
                        </div>
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">Receive Date</label>
                        <div class="col-sm-3">          
                            <input style="width: 184%" type="text" readonly required="required" class="form-control" name="receive_date" value="<?php echo date('Y/m/d'); ?>" id="receive_date" placeholder="Date and Time">
                        </div>
                    </div>  
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">RC Name</label>
                        <div class="col-sm-3">          
                            <input  style="width: 184%;" type="text" readonly value="<?php echo $rc_name[0]['center_name'] ?>" class="form-control" name="rc_name"  id="rc_name">
                            <input  style="width: 184%;" type="text" readonly value="<?php echo $rc_name[0]['id'] ?>" class="form-control hide_this" name="rc_id"  id="rc_id">
                        </div>
                    </div>  
                    <div class="form-group">
                        <div>
                            <label class="control-label col-sm-4" for="status" style="margin-right: 20px">Status </label>
                        </div>
                        <div style="margin-left: 13px;">
                            <label class="radio-inline">
                                <input type="radio" name="status" <?php echo!isset($keywords) ? 'checked' : '' ?> <?php echo isset($keywords) && ($keywords[0]['status'] == 1) ? 'checked' : '' ?> id="inlineRadio1" value="1"> Pending
                            </label>

                        </div>

                    </div>


                </div>
            </div>
            <div style="float: left; width: 115%; margin-left: -15%;">

                <!--<input type="button" value="Add Row" name="distributed_id" id="add_row" style="float: right; width: 86px;padding-bottom: 8px; padding-top: 6px; border-radius:5px;cursor: pointer; " class="btn btn-primary col-sm-2">-->
                <table class="table table-bordered" id="distribution_wozerd">
                    <tr class="list_header">
                        <th>Product<br> Name</th>                       
                        <th>Product<br> Number</th>                      
                        <th>Part Name</th>
                        <th>Time (hr)</th>
                        <th>Action<br> Name</th> 
                        <th>Distributed<br> Quantity</th>
                        <th>Due</th> 
                        <th>Receive Quantity</th>
                        <th>Over Supply Qty</th> 
                        <th>QC Passed</th>
                        <th>QC Failed</th> 
                        <th>Damaged</th>
                        <th>Remarks</th> 
                        <th>Action</th>
                    </tr>
                    <?php
//                                    print_r($clientrate[0]['currency_id']);exit;
                    if (isset($all_dis_product)) {
//                        print_r($all_dis_product);                        exit;
                    $i = 0;
                    foreach ($all_dis_product as $value) {
                    if ($value['prod_part_id'] != 0) {
                    $this->db->select('product_name');
                    $this->db->where('id=' . $value['prod_part_id']);
                    $prod_part_name1 = $this->db->get('conf_product')->result_array();
                     $prod_part_name= $prod_part_name1[0]['product_name'];
                    }
                    else {
                    $prod_part_name= null;
                    }
                    
//                            if ($value['prod_action_id'] != null) {
                    $this->db->select('time_hr');
                    $this->db->where('distribution_id=' . $value['distribution_id']);
                    $time = $this->db->get('distribution_rawmaterial')->result_array();
//                                print_r($time);exit;
//                              } 
                    if ($time == null) {
                    $time[0]['time_hr'] = null;
//                                 print_r($time[0]['time_hr']);exit;
                    }

                    if ($value['prod_action_id'] != null) {
                    $this->db->select('action_name');
                    $this->db->where('id=' . $value['prod_action_id']);
                    $prod_action_name = $this->db->get('conf_productactions')->result_array();
//                                print_r($prod_part_name[0]['product_name']);exit;
                    } else {
                    $prod_action_name[0]['action_name'] = null;
                    }
////                            print_r($prod_part_name[0]['product_name']);
                    $this->db->select('id,product_name,code');
                    $this->db->where('id=' . $value['prod_id']);
                    $product_name = $this->db->get('conf_product')->result_array();
                    echo ' <tr>
                        <td><input type="text" name="product_name"  readonly value="' . $product_name[0]['product_name'] . '" class="form-control" id="product_name_' . $i . '" /></td>                        
                        <td class="hide_this"><input type="text" name="product_id" value="' . $product_name[0]['id'] . '" class="form-control" id="product_id_' . $i . '"/></td>                        
                        <td class="hide_this"><input type="text" name="disprod_id" value="' . $value['distribution_prod_id'] . '"  class="form-control" id="disprod_id_' . $i . '"/></td>
                        <td><input type="text" name="product_number" readonly value="' . $product_name[0]['code'] . '" class="form-control" id="product_number_' . $i . '"/></td>                       
                        <td><input type="text" name="part_name" readonly value="' . $prod_part_name. '" class="form-control" id="part_name_' . $i . '"/></td>
                        <td class="hide_this"><input type="text" name="part_id" value="' . $value['prod_part_id'] . '" readonly class="form-control" id="part_id_' . $i . '"/></td>
                        <td><input type="text" name="time_hr" readonly value="' . $time[0]['time_hr'] . '"class="form-control" id="time_hr_' . $i . '"/></td>
                        <td><input type="text" name="action_name" readonly value="' . $prod_action_name[0]['action_name'] . '" class="form-control" id="action_name_' . $i . '"/></td>
                        <td class="hide_this"><input type="text" name="action_id" readonly class="form-control" id="action_id_' . $i . '"/></td>
                        <td><input type="text" name="d_quantity" readonly class="form-control" value="' . $value['distributed_qty'] . '"id="d_quantity_' . $i . '"/></td>
                        <td><input type="text" name="due_value" readonly class="form-control" value="0" id="due_value_' . $i . '"/></td>
                        <td><input type="text" name="receive_quantity" onchange="check_quantity(this)" class="form-control" id="receive_quantity_' . $i . '"/></td>
                        <td><input type="text" name="over_supply" class="form-control" id="total_quantity_' . $i . '"/></td>                      
                        <td><input type="text" name="qc_passed" class="form-control" id="qc_passed_' . $i . '"/></td>
                        <td><input type="text" name="qc_failed" class="form-control" id="qc_failed_' . $i . '"/></td>
                        <td><input type="text" name="damage_prod" class="form-control" id="damage_prod_' . $i . '"/></td>                                             
                        <td><input type="text" name="remark_text" class="form-control" id="remark_text_' . $i . '"/></td>
                        <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                ';
                    $i++;
                    }
                    }
                    ?>
                </table>
            </div>
            <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;">        
                <div class="col-sm-offset-2 col-sm-10" style="margin-bottom: 50px; margin-left: 3%; width: 100%;">

                    <button type="button" name="submit" id="submit" class="btn col-sm-3 save-button-color" style="width: 180px;"><b>Save</b></button>                  
                    <button type="button" name="complete" id="complete" class="btn col-sm-3 save-button-color" style="width: 180px;"><b>Complete</b></button>              
                    <!--<a href="<?php // echo base_url('home/payment?dis_id='.$distribution[0]['distribution_id']);   ?>" class="btn col-sm-3 close-button-color" style="margin-right: 10px;width: 245px;"><b><?php // echo 'Generate Payment Sheet'   ?></b></a>-->   
                    <a href="<?php echo base_url('#'); ?>" class="btn col-sm-3 close-button-color" style="margin-right: 10px;width: 180px;"><b><?php echo 'Print' ?></b></a>   
                    <a href="<?php echo base_url('home/receivedistribution_list'); ?>" class="btn col-sm-3 close-button-color" style="margin-right: 10px;width: 180px;"><b>Close</b></a>   
                </div>
            </div>
        </form>

    </div>

</div>
<script>
    function check_quantity(obj) {
        var id = obj.id;
        var saper_id = id.split("_");
        var i = saper_id[2];
        var ppp = i;

        var due_value = $('#due_value_' + i).val();
        var receive_quantity = $('#receive_quantity_' + i).val();
        var d_quantity = $('#d_quantity_' + i).val();
        var line_price = parseInt(due_value) + parseInt(receive_quantity);
        console.log(line_price);
        console.log(d_quantity);
        if (d_quantity < line_price) {
            alert("Receive Quantity Is not more than Distributed Quantity");
            $('#receive_quantity_' + ppp).val("");
        }
        else
        {
            var line_price2 = parseInt(d_quantity) - parseInt(receive_quantity);
            $('#due_value_' + ppp).val(line_price2);
        }
    }


    $('#submit').on('click', function (e) {
        var wizard = {};
        var wo = {};
        var i = 0;
        wo[0] = $('#distribution_id').val();
        wo[1] = $('#receive_date').val();
        wo[2] = $('#remarks').val();
        $('#distribution_wozerd tr td input,#distribution_wozerd tr td select').each(function () {
            wizard[i] = $(this).val();
            i++;
        });
        var d = {
            wizard: wizard,
            wo: wo
        };
//        console.log(d);
        var url = '<?php echo base_url('home/save_receive_dis_wizard') ?>';
        $.ajax({
            async: false,
            type: 'post',
            url: url,
            data: {myarray: d},
            success: function (result) {
                var url_location = '<?php echo base_url('home/receivedistribution_list')?>';
                window.location.assign(url_location);
            }

        });
    });

</script>
