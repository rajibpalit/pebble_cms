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
        <h3><b>Distribution</b></h3>
    </div>

    <input type="hidden" id="initilize_value1" value="1">

    <div style="margin-top: 5%; margin-left: 15%;">
        <form class="form-horizontal" id="keyword_insert" role="form" method="post" action="<?php echo base_url('home/distribution_list') ?>">

            <?php // print_r($dis);exit;?>

            <input type="hidden" id="distribution_id" value="<?php echo $dis[0]['distribution_id'] ?>"/>
            <div style="float: left; width: 100%">
                <div class="col-lg-5" style="float: left">
                    <div class="form-group">
                        <label class="control-label col-sm-5" for="" style="margin-left: -33px;padding: 7px">Distribution No</label>
                        <div class="col-sm-3">          
                            <input  style="width: 210%; margin-left: 27%" value="<?php echo (isset($dis[0]['distribution_no'])) ? $dis[0]['distribution_no'] : ''; ?>"  type="text" readonly class="form-control" name=""  id="distribution_no">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5" for="" style="margin-left: -33px;padding: 7px">Work order Number</label>
                        <!--<div class="col-sm-2">-->
                        <div class="col-sm-3">          
                            <input  style="width: 210%; margin-left: 27%" value="<?php echo (isset($dis[0]['workorder_no'])) ? $dis[0]['workorder_no'] : ''; ?>"  type="text" readonly class="form-control" name="wo_number"  id="wo_number">
                        </div>

                        <!--</div>-->
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5" for="" style="margin-left: -33px;padding: 7px" >Invoice Number</label>
                        <!--<div class="col-sm-2">-->
                        <div class="col-sm-3">          
                            <input  style="width: 210%; margin-left: 27%"  value="<?php echo (isset($invoice[0]['inv_number'])) ? $invoice[0]['inv_number'] : ''; ?>" type="text" readonly class="form-control" name=""  id="inv_number">
                        </div>
                        <!--</div>-->
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">RC Name</label>
                        <div class="col-sm-3">          
                            <input style="width: 184%"  value="<?php echo (isset($dis[0]['center_name'])) ? $dis[0]['center_name'] : ''; ?>" type="text" readonly required="required" class="form-control" name="" id="rc_name" >
                        </div>
                    </div>

                </div>
                <div class="col-lg-7">
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">Date and Time</label>
                        <div class="col-sm-3">          
                            <input style="width: 184%"  value="<?php echo (isset($dis[0]['created_at'])) ? $dis[0]['created_at'] : ''; ?>" type="text" readonly required="required" class="form-control" name="" value="<?php echo date('d/m/Y h:i:s a', time()); ?>" id="date_time" placeholder="Date and Time">
                        </div>
                    </div>

                </div>
                <div class="col-lg-7">
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
            </div>
            <div style="float: left; width: 115%; margin-left: -15%;">

                <!--<input type="button" value="Add Row" name="distributed_id" id="add_row" style="float: right; width: 86px;padding-bottom: 8px; padding-top: 6px; border-radius:5px;cursor: pointer; " class="btn btn-primary col-sm-2">-->
                <table class="table table-bordered" id="distribution_wozerd">
                    <tr class="list_header">
                        <th>Product<br> Name</th>                       
                        <th>Product<br> Code</th>                      
                        <th>Part Name</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Action Name</th>                        
                        <th>WO<br> Quantity</th>
                        <th>Distributed<br> Quantity</th>
                        <th>Distribution<br> Quantity</th>
                        <th>Action</th>
                    </tr>
                    <?php
//                                    print_r($clientrate[0]['currency_id']);exit;
                    if (isset($all)) {
//                        print_r($all);
//                        exit;
                        $i = 0;
                        foreach ($all as $value) {
//                            print_r($value);exit;
                            if ($value['prod_part_id'] != 0) {
                                $this->db->select('product_name');
                                $this->db->where('id=' . $value['prod_part_id']);
                                $prod_part_name = $this->db->get('conf_product')->result_array();
//                                print_r($prod_part_name [0]['product_name']);exit;
                            } else {
                                $prod_part_name[0]['product_name'] = null;
                            }
//                            print_r($prod_part_name[0]['product_name']);
                            $this->db->select('keyword_value');
                            $this->db->where('keyword_id=' . $value['color']);
                            $color = $this->db->get('conf_keyword')->result_array();
//
                            $this->db->select('keyword_value');
                            $this->db->where('keyword_id=' . $value['size']);
                            $size = $this->db->get('conf_keyword')->result_array();
                            $this->db->select('action_name');
                            $this->db->where('id=' . $value['prod_action_id']);
                            $action_name = $this->db->get('conf_productactions')->result_array();
                            if ($action_name == null) {
                                $action_name[0]['action_name'] = null;
                            }
                            echo ' <tr>
                                 <td><input type="text" name="product_name" readonly  class="form-control" id="product_id_' . $i . '" value="' . $value['product_name'] . '" onclick="autocomproduct(this)" onblur="computproduct(this)"/></td>                        
                        <td class="hide_this"><input type="text" name="product_id" value="' . $value['prod_id'] . '" class="form-control" id="product_id_' . $i . '"/></td>                                              
                        <td class="hide_this"><input type="text" name="dis_prod_id" value="' . $value['distribution_prod_id'] . '" class="form-control" id="dis_prod_id_' . $i . '"/></td>                                              
                        <td class="hide_this"><input type="text" name="wo_prod_id" class="form-control" id="wo_prod_id_' . $i . '"/></td>
                        <td><input type="text" name="product_number" readonly class="form-control" value="' . $value['code'] . '" id="product_number_' . $i . '"/></td>                       
                        <td><input type="text" name="part_name" value="' . $prod_part_name[0]['product_name'] . '" readonly class="form-control" id="part_name_' . $i . '"/></td>
                        <td class="hide_this"><input type="text" name="part_id" value="' . $value['prod_part_id'] . '" readonly class="form-control" id="part_id_' . $i . '"/></td>
                        <td><input type="text" name="color" readonly class="form-control" value="' . $color[0]['keyword_value'] . '" id="color_' . $i . '"/></td>
                        <td><input type="text" name="size" readonly class="form-control" value="' . $size[0]['keyword_value'] . '" id="size_' . $i . '"/></td>
                        <td><input type="text" name="action_name" readonly class="form-control" value="' . $action_name[0]['action_name'] . '"  id="action_name_' . $i . '"/></td>
                        <td class="hide_this"><input type="text" name="action_id" class="form-control" id="action_id_' . $i . '"/></td>
                        <td><input type="text" name="wo_quantity" readonly class="form-control" value="' . $value['wo_qty'] . '" id="wo_quantity_' . $i . '" value="0"/></td>
                        <td><input type="text" name="distributed_quantity" readonly class="form-control" value="' . $value['distributed_qty'] . '" id="distributed_quantity_' . $i . '" value="0"/></td>
                        <td><input type="number" name="distribution_quantity" id="distribution_quantity_' . $i . '" value="' . $value['distribution_qty'] . '" class="form-control" value="0" onblur="check_quantity(this)"/></td>
                        <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                ';
                            $i++;
                        }
                    }
                    ?>

                </table>
            </div>
            <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;">        
                <div class="col-sm-offset-2 col-sm-10" style="margin-left: 300px;margin-bottom: 50px; margin-left: 4%;">
                    <button type="button" name="submit" id="update" class="btn col-sm-3 save-button-color" style="width: 300px;"><b>Update</b></button>                  
                    <a href="<?php echo base_url('home/distribution_list'); ?>" class="btn col-sm-3 close-button-color" style="margin-right: 10px;"><b>Close</b></a>                                                        
                    <a href="<?php echo base_url('#'); ?>" class="btn col-sm-3 close-button-color" style=""><b><?php echo 'Print' ?></b></a>                                                        
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

        var distribution_quantity = $('#distribution_quantity_' + i).val();
        var default_value = distribution_quantity;
//        console.log(default_value);
        var distributed_quantity = $('#distributed_quantity_' + i).val();
        var wo_quantity = $('#wo_quantity_' + i).val();
//        console.log(wo_quantity);
        var line_price = parseInt(distributed_quantity) + parseInt(distribution_quantity);
        if (wo_quantity < line_price) {
            alert("Distributed Quantity Is not more than WO Quantity");
//            console.log(default_value);
            $('#distribution_quantity_' + ppp).val("");
        }
    }

    $('#update').on('click', function (e) {
        var wizard = {};
        var i = 0;
        $('#distribution_wozerd tr td input,#distribution_wozerd tr td select').each(function () {
            wizard[i] = $(this).val();
            i++;
        });
        var d = {
            wizard: wizard
        };
//        console.log(d);
        var url = '<?php echo base_url('home/update_wizard') ?>';
        $.ajax({
            async: false,
            type: 'post',
            url: url,
            data: {myarray: d},
            success: function (result) {
//                console.log(result);

                var url_location = '<?php echo base_url('home/distribution_list') ?>';
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
