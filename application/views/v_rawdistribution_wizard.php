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
        <h3><b>Raw Material Distribution</b></h3>
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
                            <input  style="width: 210%; margin-left: 27%" type="text" readonly value="<?php echo $workorder_no[0]['workorder_id'] ?>" class="form-control hide_this" name="wo_id"  id="wo_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5" for="" style="margin-left: -33px;padding: 7px">Invoice Number</label>
                        <div class="col-sm-3">          
                            <input  style="width: 210%; margin-left: 27%" type="text" readonly value="<?php echo $invoice_no[0]['inv_number'] ?>"class="form-control" name=""  id="inv_number">
                            <input  style="width: 210%; margin-left: 27%" type="text" readonly value="<?php echo $invoice_no[0]['inv_id'] ?>"class="form-control hide_this" name="inv_id"  id="inv_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5" for="" style="margin-left: -33px;padding: 7px">RC Name</label>
                        <div class="col-sm-3">          
                            <input  style="width: 210%; margin-left: 27%" type="text" readonly value="<?php echo $rc_name[0]['center_name'] ?>" class="form-control" name="rc_name"  id="rc_name">
                            <input  style="width: 210%; margin-left: 27%" type="text" readonly value="<?php echo $rc_name[0]['id'] ?>" class="form-control hide_this" name="rc_id"  id="rc_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5" for="" style="margin-left: -33px;padding: 7px">Time(hr)</label>
                        <div class="col-sm-3">          
                            <input  style="width: 210%; margin-left: 27%" type="text" readonly value="<?php echo $time ?>"  class="form-control" name="time"  id="time">
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
                        <label class="control-label col-sm-4" for="">Issue Date</label>
                        <div class="col-sm-3">          
                            <input style="width: 184%" type="text" readonly required="required" class="form-control" name="issue_date" value="<?php echo date('Y/m/d'); ?>" id="issue_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">Preparation Start Date</label>
                        <div class="col-sm-3">          
                            <input style="width: 184%" type="text" readonly required="required" onfocus="datepick(this)" class="form-control" name="pstart_date"  id="pstart_date" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">Preparation End Date</label>
                        <div class="col-sm-3">          
                            <input style="width: 184%" type="text" readonly required="required" onfocus="datepick(this)"  class="form-control" name="pend_date"  id="pend_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">Sending Date</label>
                        <div class="col-sm-3">          
                            <input style="width: 184%" type="text" readonly required="required"  onfocus="datepick(this)" onchange="expected_date()" class="form-control" name="sending_date" id="sending_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">Expected Return Date</label>
                        <div class="col-sm-3">          
                            <input style="width: 184%" type="text" readonly required="required" class="form-control" name="return_date" id="return_date">
                        </div>
                    </div>
                    <div class="form-group">
                        <div>

                            <label class="control-label col-sm-4" for="status" style="margin-right: 20px">Status </label>
                        </div>
                        <div style="margin-left: 13px;">
                            
                            <label class="radio-inline">
                                <?php echo isset($distribution) && ($distribution[0]['status'] == 1) ? 'Complete' : 'Pending' ?>
                                <!--<input style="width: 184%" type="text" value="  <?php // echo isset($keywords) && ($keywords[0]['status'] == 1) ? 'checked' : '' ?> " readonly required="required" class="form-control" name="return_date" id="return_date">-->
                                <!--<input type="text" name="status" <?php // echo!isset($keywords) ? 'checked' : '' ?> <?php // echo isset($keywords) && ($keywords[0]['status'] == 1) ? 'checked' : '' ?> id="inlineRadio1" value="0">-->
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
                        <th>Distributed<br> Quantity</th>
                        <th>Material Name</th>
                        <th>Distributed Raw Material Quantity</th>                       
                        <th>Total<br> Quantity</th>
                        <th>Stock<br> Quantity</th>
                        <th>Action</th>
                    </tr>
                    <?php
//                                    print_r($clientrate[0]['currency_id']);exit;
                    if (isset($all_dis_product)) {
//                        print_r($all_dis_product[0]['distribution_prod_id']);                        exit;
                        $i = 0;
                        foreach ($all_dis_product as $value) {
//                            print_r($value['distribution_prod_id']);exit;
                            if ($value['prod_part_id'] != 0) {
                                $this->db->select('product_name');
                                $this->db->where('id=' . $value['prod_part_id']);
                                $prod_part_name = $this->db->get('conf_product')->result_array();
//                                print_r($prod_part_name[0]['product_name']);exit;
                            } else {
                                $prod_part_name[0]['product_name'] = null;
                            }
////                            print_r($prod_part_name[0]['product_name']);
                            $this->db->select('id,product_name,code');
                            $this->db->where('id=' . $value['prod_id']);
                            $product_name = $this->db->get('conf_product')->result_array();

                            $this->db->select('raw_material_id,material_name');
                            $this->db->join('conf_rawmaterial', 'conf_product_rawmaterials.raw_material_id = conf_rawmaterial.id');
//                            $this->db->join('stockrm', 'conf_product_rawmaterials.raw_material_id = stockrm.rawmaterial_id');
                            $this->db->where('product_id=' . $value['prod_id']);
                            $raw_material_name = $this->db->get('conf_product_rawmaterials')->result_array();
//                            print_r($raw_material_name[0]['raw_material_id']);                           exit;
                            $raw_array_length = sizeof($raw_material_name);
//                            exit;
                            if ($raw_array_length > 1) {

                                for ($k = 0; $k < $raw_array_length; $k++) {
                                    if ($raw_material_name != null) {
                                        $this->db->select('existing_qty');
                                        $this->db->where('rawmaterial_id=' . $raw_material_name[0]['raw_material_id']);
                                        $existing_qty = $this->db->get('stockrm')->result_array();
                                    } else {
                                        $raw_material_name[$k]['material_name'] = null;
                                        $raw_material_name[$k]['raw_material_id'] = NULL;
                                    }
                                    echo ' <tr>
                                         <td class="hide_this"><input type="text" name="disprod_id" value="' . $value['distribution_prod_id'] . '" class="form-control" id="disprod_id_' . $i . '"/></td>                                                    
                        <td><input type="text" name="product_name"  readonly value="' . $product_name[0]['product_name'] . '" class="form-control" id="product_name_' . $i . '" onclick="autocomproduct(this)" onblur="computproduct(this)"/></td>                        
                        <td class="hide_this"><input type="text" name="product_id" value="' . $product_name[0]['id'] . '" class="form-control" id="product_id_' . $i . '"/></td>                                                    
                        <td><input type="text" name="product_number" readonly value="' . $product_name[0]['code'] . '" class="form-control" id="product_number_' . $i . '"/></td>                       
                        <td><input type="text" name="part_name" readonly value="' . $prod_part_name[0]['product_name'] . '" class="form-control" id="part_name_' . $i . '"/></td>
                        <td><input type="text" name="dquantity" readonly class="form-control" value="' . $value['distributed_qty'] . '"id="d_quantity_' . $i . '"/></td>
                        <td><input type="text" name="material_name" readonly value="' . $raw_material_name[$k]['material_name'] . '" class="form-control" id="material_name_' . $i . '"/></td>
                        <td class="hide_this"><input type="text" name="material_id" value="' . $raw_material_name[$k]['raw_material_id'] . '" class="form-control" id="material_id_' . $i . '"/></td>
                        <td><input type="text" name="rm_quantity" readonly class="form-control" id="rm_quantity_' . $i . '" value="0"/></td> 
                        <td><input type="text" name="total_quantity"  class="form-control" id="total_quantity_' . $i . '" onchange="check_quantity(this)"/></td> 
                        <td><input type="text" name="stock_quantity" readonly value="' . $existing_qty[$k]['existing_qty'] . '" class="form-control" id="stock_quantity_' . $i . '"/></td>                       
                        <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                ';
                                    $i++;
                                }
                            } else {
                                if ($raw_material_name != null) {
                                    $this->db->select('existing_qty');
                                    $this->db->where('rawmaterial_id=' . $raw_material_name[0]['raw_material_id']);
                                    $existing_qty = $this->db->get('stockrm')->result_array();
//                                print_r($existing_qty);exit;
                                } else {
                                    $raw_material_name[0]['material_name'] = null;
                                    $raw_material_name[0]['raw_material_id'] = null;
                                    $existing_qty[0]['existing_qty'] = null;
                                }
                                echo ' <tr>
                                         <td class="hide_this"><input type="text" name="disprod_id" value="' . $value['distribution_prod_id'] . '" class="form-control" id="disprod_id_' . $i . '"/></td>                                                    
                        <td><input type="text" name="product_name"  readonly value="' . $product_name[0]['product_name'] . '" class="form-control" id="product_name_' . $i . '" onclick="autocomproduct(this)" onblur="computproduct(this)"/></td>                        
                        <td class="hide_this"><input type="text" name="product_id" value="' . $product_name[0]['id'] . '" class="form-control" id="product_id_' . $i . '"/></td>                                                    
                        <td><input type="text" name="product_number" readonly value="' . $product_name[0]['code'] . '" class="form-control" id="product_number_' . $i . '"/></td>                       
                        <td><input type="text" name="part_name" readonly value="' . $prod_part_name[0]['product_name'] . '" class="form-control" id="part_name_' . $i . '"/></td>
                        <td><input type="text" name="d_quantity" readonly class="form-control" value="' . $value['distributed_qty'] . '"id="d_quantity_' . $i . '"/></td>
                        <td><input type="text" name="material_name" readonly value="' . $raw_material_name[0]['material_name'] . '" class="form-control" id="material_name_' . $i . '"/></td>
                        <td class="hide_this"><input type="text" name="material_id" value="' . $raw_material_name[0]['raw_material_id'] . '" class="form-control" id="material_id_' . $i . '"/></td>
                        <td><input type="text" name="rm_quantity" readonly class="form-control" id="rm_quantity_' . $i . '" value="0"/></td> 
                        <td><input type="text" name="total_quantity"  class="form-control" id="total_quantity_' . $i . '" onchange="check_quantity(this)"/></td> 
                        <td><input type="text" name="stock_quantity" readonly value="' . $existing_qty[0]['existing_qty'] . '" class="form-control" id="stock_quantity_' . $i . '"/></td>                       
                        <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                ';
                                $i++;
                            }
                        }
                    }
                    ?>
                </table>
            </div>
            <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;">        
                <div class="col-sm-offset-2 col-sm-10" style="margin-left: 300px;margin-bottom: 50px; margin-left: -4%; width: 100%;">

                    <button type="button" name="submit" id="submit" class="btn col-sm-3 save-button-color" style="width: 200px;"><b>Save</b></button>                  
                    <button type="button" name="complete" id="complete" class="btn col-sm-3 save-button-color" style="width: 200px;"><b>Complete</b></button>    
                    <a href="<?php echo base_url('#'); ?>" class="btn col-sm-3 close-button-color" style="margin-right: 10px; width: 200px;"><b><?php echo 'Print' ?></b></a>                                                        
                    <a href="<?php echo base_url('home/pending_rawdistribution_list'); ?>" class="btn col-sm-3 close-button-color" style="margin-right: 10px; width: 200px;"><b><?php echo (isset($product)) ? 'Back' : 'Close' ?></b></a>                                                                                                         

                </div>
            </div>
        </form>

    </div>

</div>
<script>
    function datepick(obj) {
        var id = obj.id;
        $('#' + id).datepicker({dateFormat: 'yy/mm/dd'});
    }

    function expected_date()
    {
        var total_time = $('#time').val();
        var tt = Math.ceil(parseInt(total_time) / 8);
        var date_str = $('#sending_date').val();
        var tw = incr_date(date_str, tt);
        $('#return_date').val(tw);
    }

    function incr_date(date_str, day) {
        var parts = date_str.split("/");
        var dt = new Date(
                parseInt(parts[0], 10), // year
                parseInt(parts[1], 10) - 1, // month (starts with 0)
                parseInt(parts[2], 10)       // date
                );
        dt.setDate(dt.getDate() + day);
        parts[0] = "" + dt.getFullYear();
        parts[1] = "" + (dt.getMonth() + 1);
        if (parts[1].length < 2) {
            parts[1] = "0" + parts[1];
        }
        parts[2] = "" + dt.getDate();
        if (parts[2].length < 2) {
            parts[2] = "0" + parts[2];
        }
        return parts.join("/");
    }

    function check_quantity(obj) {
        var id = obj.id;
        var saper_id = id.split("_");
        var i = saper_id[2];
        var ppp = i;

        var rm_quantity = $('#rm_quantity_' + i).val();
        var total_quantity = $('#total_quantity_' + i).val();
        var d_quantity = $('#d_quantity_' + i).val();
        var line_price = parseInt(rm_quantity) + parseInt(total_quantity);
        console.log(line_price);
        console.log(d_quantity);
        if (d_quantity < line_price) {
            alert("Total Quantity Is not more than Distributed Quantity");
            $('#total_quantity_' + ppp).val("");
        }
        else
        {
            $('#rm_quantity_' + ppp).val(line_price);
        }
    }

    $('#submit').on('click', function (e) {
        var wizard = {};
        var wo = {};
        var i = 0;
        wo[0] = $('#distribution_id').val();
        wo[1] = $('#wo_id').val();
        wo[2] = $('#inv_id').val();
        wo[3] = $('#rc_id').val();
        wo[4] = $('#time').val();
        wo[5] = $('#remarks').val();
        wo[6] = $('#issue_date').val();
        wo[7] = $('#pstart_date').val();
        wo[8] = $('#pend_date').val();
        wo[9] = $('#sending_date').val();
        wo[10] = $('#return_date').val();
        $('#distribution_wozerd tr td input,#distribution_wozerd tr td select').each(function () {
            wizard[i] = $(this).val();
            i++;
        });
        var d = {
            wizard: wizard,
            wo: wo
        };
//        console.log(d);
        var url = '<?php echo base_url('home/save_raw_dis_wizard') ?>';
        $.ajax({
            async: false,
            type: 'post',
            url: url,
            data: {myarray: d},
            success: function (result) {
                console.log(result);
//
                var url_location = '<?php echo base_url('home/rawdistribution_list')                   ?>';
                window.location.assign(url_location);
            }

        });
    });

</script>
