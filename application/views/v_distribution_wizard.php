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
    .ui-autocomplete {
        z-index:2147483647;
    }
</style>
<div class="container" style="background-color: white;min-height: 600px">

    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Distribution Wizard</b></h3>
    </div>
    <?php //  $i = 0; ?>
    <!--
        <input type="hidden" id="initilize_value1" value=" <?php // echo $i;     ?>">-->
    <div style="margin-top: 5%; margin-left: 15%;">
        <form class="form-horizontal" id="keyword_insert" role="form" method="post" action="<?php echo base_url('home/distribution') ?>">
            <div style="float: left; width: 100%">
                <div class="col-lg-5" style="float: left">
                    <div class="form-group">
                        <label class="control-label col-sm-5" for="" style="margin-left: -33px;padding: 7px">Workorder Number</label>
                        <div class="col-sm-3">          
                            <input  style="width: 210%; margin-left: 27%" type="text" value="<?php echo $wo_no[0]['workorder_no'] ?>"  readonly class="form-control" name=""  id="wo_number">
                            <input  style="width: 210%; margin-left: 27%" value="<?php echo $wo_no[0]['workorder_id'] ?>"  type="hidden"   name=""  id="wo_id">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-5" for="" style="margin-left: -33px;padding: 7px">Invoice Number</label>
                        <div class="col-sm-3">          
                            <input  style="width: 210%; margin-left: 27%" value="<?php echo $inv_no[0]['inv_number'] ?>"  type="text" readonly class="form-control" name=""  id="inv_number">
                            <input  style="width: 210%; margin-left: 27%" value="<?php echo $inv_id ?>"  type="hidden"   name=""  id="inv_id">
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
                        <label class="control-label col-sm-4" for="">Date and Time</label>
                        <div class="col-sm-3">          
                            <input style="width: 184%" type="text" readonly required="required" class="form-control" name="" value="<?php echo date('d-M-Y'); ?>" id="date_time" placeholder="Date and Time">
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="control-label col-sm-4" for="">Remarks</label>
                        <div class="col-sm-5">     
                            <textarea rows="2" cols="20" class="form-control" name="remarks" id="remarks"> Remarks Here...</textarea>
<!--                            <input style="width: 150%" type="text" class="form-control" name="" value="<?php // echo isset($value) ? $value[0]['short_form'] : ''       ?>" id="" placeholder="Remarks">-->
                        </div>
                    </div>

                </div>
            </div>
            <div style="float: left; width: 115%; margin-left: -15%;">

                <input type="button" value="Add Row" name="distributed_id" id="add_row" style="float: right; width: 86px;padding-bottom: 8px; padding-top: 6px; border-radius:5px;cursor: pointer; " class="btn btn-primary col-sm-2">
                <table class="table table-bordered" id="distribution_wozerd">
                    <tr class="list_header">
                        <th>Product<br> Name</th>                       
                        <th>Product<br> Code</th>                      
                        <th>Part Name</th>
                        <th>Color</th>
                        <th>Size</th>
                        <th>Action Name</th>
                        <th style="width: 10%;">RC Name</th>
                        <th>WO<br> Quantity</th>
                        <th>Distributed<br> Quantity</th>
                        <th>Distribution<br> Quantity</th>
                        <th>Action</th>
                    </tr>
                    <?php
                    $i = 0;
//                    print_r($invoice_id[0]['inv_prod_id']);exit;
                    foreach ($invoice_id as $value) {
//                        print_r($value['inv_prod_id']);exit;
                        $this->db->select('id');
                        $this->db->where('inv_prod_id=' . $value['inv_prod_id']);
                        $wo_prod_id1 = $this->db->get('workorder_product')->result_array();
                        $wo_prod_id =$wo_prod_id1[0]['id'];
                        $this->db->select('code');
                        $this->db->where('id=' . $value['prod_id']);
                        $prod_code = $this->db->get('conf_product')->result_array();

                        $this->db->select('keyword_value');
                        $this->db->where('keyword_id=' . $value['color_id']);
                        $color = $this->db->get('conf_keyword')->result_array();

                        $this->db->select('keyword_value');
                        $this->db->where('keyword_id=' . $value['size_id']);
                        $size = $this->db->get('conf_keyword')->result_array();

                        $this->db->select('conf_productactions.id,action_name');
                        $this->db->join('conf_product_actiontime', 'conf_productactions.id = conf_product_actiontime.action_id');
                        $this->db->where('product_id=' . $value['prod_id']);
                        $action_name = $this->db->get('conf_productactions')->result_array();
                        if ($action_name == null) {
                            $action_name[0]['action_name'] = null;
                            $action_name[0]['id'] = null;
                        }

                        $this->db->select('part_name_id');
                        $this->db->where('product_id=' . $value['prod_id']);
                        $part = $this->db->get('conf_product_parts')->result_array();
                        $part_length = sizeof($part);
//                        print_r($part_length);exit;
                        if ($part_length > 1) {

                            for ($j = 0; $j < $part_length; $j++) {
                                $this->db->select('id,product_name');
                                $this->db->where('id=' . $part[$j]['part_name_id']);
                                $prod_name = $this->db->get('conf_product')->result_array();
                                if ($prod_name == NULL) {
                                    $prod_name[0][' product_name'] = null;
                                }
//                                print_r($part_length . "test");                                exit;
                                echo ' <tr>
                                 <td><input type="text" name="product_name" readonly  class="form-control" id="product_id_' . $i . '" value="' . $value['prod_name'] . '" /></td>                        
                                 <td class="hide_this"><input type="text" name="product_id" value="' . $value['prod_id'] . '" class="form-control" id="product_id_' . $i . '"/></td>                                              
                                 <td class="hide_this"><input type="text" name="wo_prod_id" value="' . $wo_prod_id . '" class="form-control" id="wo_prod_id_' . $i . '"/></td>
                                 <td><input type="text" name="product_number" readonly class="form-control" value="' . $prod_code[0]['code'] . '" id="product_number_' . $i . '"/></td>                       
                                 <td><input type="text" name="part_name" value="' . $prod_name[0]['product_name'] . '" readonly class="form-control" id="part_name_' . $i . '"/></td>
                                 <td class="hide_this"><input type="text" name="part_id" value="' . $prod_name[0]['id'] . '" readonly class="form-control" id="part_id_' . $i . '"/></td>                                 
                                 <td><input type="text" name="color" readonly class="form-control" value="' . $color[0]['keyword_value'] . '" id="color_' . $i . '"/></td>
                                 <td><input type="text" name="size" readonly class="form-control" value="' . $size[0]['keyword_value'] . '" id="size_' . $i . '"/></td>
                                 <td><input type="text" name="action_name" readonly class="form-control" value="' . $action_name[0]['action_name'] . '"  id="action_name_' . $i . '"/></td>
                                 <td class="hide_this"><input type="text" name="action_id" readonly class="form-control" value="' . $action_name[0]['id'] . '"  id="action_id_' . $i . '"/></td>                                 
                                 <td><input type="text" name="rc_name" class="form-control" id="rc_name_' . $i . '" onclick="autocomrc(this)"/></td>
                                 <td class="hide_this"><input type="text" name="rc_id" class="form-control example" id="rc_id_' . $i . '"/></td>
                                 <td><input type="text" name="wo_quantity" readonly class="form-control" value="' . $value['quantity'] . '" id="wo_quantity_' . $i . '" value="0"/></td>
                                 <td><input type="text" name="distributed_quantity" readonly class="form-control"  id="distributed_quantity_' . $i . '" value="0"/></td>                       
                                 <td><input type="number" name="distribution_quantity" id="distribution_quantity_' . $i . '"  class="form-control" value="0" onblur="check_quantity(this)"/></td>
                                 <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                ';
                                $i++;
                            }
                        } else {
                            if ($part != null) {
                                $this->db->select('id,product_name');
                                $this->db->where('id=' . $part[0]['part_name_id']);
                                $prod_name = $this->db->get('conf_product')->result_array();
                            } else {
                                $prod_name[0]['product_name'] = null;
                                $prod_name[0]['id'] = NULL;
                            }
                            echo ' <tr>
                                 <td><input type="text" name="product_name" readonly  class="form-control" id="product_id_' . $i . '" value="' . $value['prod_name'] . '"/></td>                        
                        <td class="hide_this"><input type="text" name="product_id" value="' . $value['prod_id'] . '" class="form-control" id="product_id_' . $i . '"/></td>                                              
                        <td class="hide_this"><input type="text" name="wo_prod_id" value="' . $wo_prod_id . '" class="form-control" id="wo_prod_id_' . $i . '"/></td>
                        <td><input type="text" name="product_number" readonly class="form-control" value="' . $prod_code[0]['code'] . '" id="product_number_' . $i . '"/></td>                       
                        <td><input type="text" name="part_name" value="' . $prod_name[0]['product_name'] . '" readonly class="form-control" id="part_name_' . $i . '"/></td>
                        <td class="hide_this"><input type="text" name="part_id" value="' . $prod_name[0]['id'] . '" readonly class="form-control" id="part_id_' . $i . '"/></td>
                        <td><input type="text" name="color" readonly class="form-control" value="' . $color[0]['keyword_value'] . '" id="color_' . $i . '"/></td>
                        <td><input type="text" name="size" readonly class="form-control" value="' . $size[0]['keyword_value'] . '" id="size_' . $i . '"/></td>
                        <td><input type="text" name="action_name" readonly class="form-control" value="' . $action_name[0]['action_name'] . '"  id="action_name_' . $i . '"/></td>
                        <td class="hide_this"><input type="text" name="action_id" readonly class="form-control" value="' . $action_name[0]['id'] . '"  id="action_id_' . $i . '"/></td>  
                        <td><input type="text" name="rc_name" class="form-control" id="rc_name_' . $i . '" onclick="autocomrc(this)" onblur="computrc(this)" /></td>
                        <td class="hide_this"><input type="text" name="rc_id" class="form-control example" id="rc_id_' . $i . '"/></td>
                        <td><input type="text" name="wo_quantity" readonly class="form-control" value="' . $value['quantity'] . '" id="wo_quantity_' . $i . '" value="0"/></td>
                        <td><input type="text" name="distributed_quantity" readonly class="form-control"  id="distributed_quantity_' . $i . '" value="0"/></td>                       
                        <td><input type="number" name="distribution_quantity" id="distribution_quantity_' . $i . '"  class="form-control" value="0" onblur="check_quantity(this)"/></td>
                        <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                ';
                            $i++;
                        }
                    }
                    ?>
                    <input type="hidden" id="initilize_value1" value="<?php echo $i ?>">
                </table>


            </div>
            <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;">        
                <div class="col-sm-offset-2 col-sm-10" style="margin-left: 300px;margin-bottom: 50px; margin-left: 4%;">
                    <button type="button" name="submit" id="submit" class="btn col-sm-3 save-button-color" style="width: 300px;"><b>Generate Distribution Sheet</b></button>                  
                    <a href="<?php echo base_url('home/pending_distribution_list'); ?>" class="btn col-sm-3 close-button-color" style="margin-right: 10px;"><b><?php echo (isset($product)) ? 'Back' : 'Close' ?></b></a>                                                        
                    <!--<a href="<?php // echo base_url('#');                                                 ?>" class="btn col-sm-3 close-button-color" style=""><b><?php // echo 'Print'                                                 ?></b></a>-->                                                        
                </div>
            </div>
        </form>

    </div>

</div>

<script type="text/javascript" src="<?php echo base_url("assets/js/custom/distribution_wizard.js"); ?>"></script>
