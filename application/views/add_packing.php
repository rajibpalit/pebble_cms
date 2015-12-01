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
        margin-left: 45%;
        margin-bottom: 20px

    }
</style>
<div class="container" style="background-color: white;min-height: 600px">
    <?php  
    ?>
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>
                <?php echo (isset($packing)) ? 'Update Packing' : 'New Packing' ?></b>        
        </h3>
    </div> 
    <div style="margin-top: 5%; margin-left: 2%;">
        <form class="form-inline" id="packing_info" name="myform" method="POST" action="<?php echo base_url('packing/save_packing') ?>">


            <?php if (isset($packing)) { ?>
            <input type="hidden" name="packing_id" id="packing_id" value="<?php echo $packing[0]['pack_id'] ?>"/>
            <?php } ?>                           

            <div class="form-group">
                <label for="inv_number">Invoice Number</label>
                <input type="text" readonly="" id="inv_number" value="<?php echo $invoices[0]['inv_number'] ?>" class="form-control"/>          
                <input type="hidden" readonly="" name="inv_id" id="inv_id" value="<?php echo $invoices[0]['inv_id'] ?>" class="form-control"/>          

            </div>

            <div class="form-group">
                <label for="client_name">Client Name</label>
                <input type="text" class="form-control" id="client_name" placeholder="Client_name" name="client_name" value="<?php echo (isset($invoices)) ? $invoices[0]['client_name'] : '' ?>" readonly>                     
                <input type="hidden" class="form-control" id="client_name" name="client_id" value="<?php echo (isset($invoices)) ? $invoices[0]['client_id'] : '' ?>" readonly>                     
            </div>
            <div class="form-group">
                <label for="inv_number">Size</label>
                <select class="form-control" name="packing_size" id="packing_size">
                    <option value="">Please Select Size</option>
                    <?php
                    foreach ($sizes as $value) {
                    if (isset($packing) && $value['keyword_id'] == $packing[0]['pack_size']) {
                    $selected = 'selected';
                    } else {
                    $selected = '';
                    }
                    echo '<option ' . $selected . ' value="' . $value['keyword_id'] . '">' . $value['keyword_value'] . '</option> ';
                    }
                    ?>     
                </select>             

            </div>

            <div class="form-group">
                <label for="remarks">Box Number</label>
                <input type="text" class="form-control" id="box_number"  name="box_number" value="<?php echo (isset($packing)) ? $packing[0]['box_number'] : '' ?>" placeholder="Box Number">
            </div>
            <div class="form-group">
                <label for="remarks">Remarks</label>
                <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks"><?php echo (isset($packing)) ? $packing[0]['remarks'] : '' ?></textarea>
            </div>


        </form>     
        <div style="margin-top: 50px "></div>
   
        <table class="table table-bordered" id="bank_table">
            <tr class="list_header">
<?php if(isset($packing)){
     echo '<th class="hide_this">packing product</th>';
}?>
                <th class="hide_this">invoice product id</th>               
                <th>Product Number</th>               
                <th class="hide_this">product id</th>               
                <th>Product Name</th> 
                <th class="hide_this">Color_id</th>               
                <th>Color</th>               
                <th class="hide_this">Size_id</th>                
                <th>Size</th>                
                <th>Ordered Quantity</th>
                <th class="hide_this">Stock Quantity</th>
                <th>Remaining Quantity</th>               
                <th>Packing Quantity</th>                             
            </tr>
            <?php
            if(isset($packing)){
            $i = 0;
            foreach ($invoi_pro as $value) {
            $this->db->select('*');
            $this->db->where('id', $value['prod_id']);
            $code = $this->db->get('conf_product')->result_array();

            $this->db->select('keyword_value');
            $this->db->where('keyword_id', $code[0]['color']);
            $color_name = $this->db->get('conf_keyword')->result_array();

            $this->db->select('keyword_value');
            $this->db->where('keyword_id', $code[0]['size']);
            $size_name = $this->db->get('conf_keyword')->result_array();
            ?>
            <tr>                
                <td class="hide_this"><input type="text" name="" class="form-control " value="<?php echo $value['inv_prod_id'] ?>" id="invproid_<?php echo $i ?>" /></td>                 
                <td><input type="text" name="" class="form-control " value="<?php echo $code[0]['code'] ?>" id="pcode_<?php echo $i ?>" /></td>                 
                <td class="hide_this"><input type="text" name="" class="form-control" value="<?php echo $value['prod_id'] ?>" id="pid_<?php echo $i ?>" readonly /></td>                 
                <td><input type="text" name="" class="form-control" value="<?php echo $code[0]['product_name'] ?>" id="pname_<?php echo $i ?>" readonly /></td>                 
                <td class="hide_this"><input type="text" name="" class="form-control" value="<?php echo $value['color_id'] ?>" id="colorid_<?php echo $i ?>" readonly /></td>
                <td><input type="text" name="" class="form-control" value="<?php echo $color_name[0]['keyword_value'] ?>" id="color_<?php echo $i ?>" readonly /></td>
                <td class="hide_this"><input type="text" name="" class="form-control" value="<?php echo $value['size_id'] ?>" id="sizeid_<?php echo $i ?>" readonly /></td>
                <td><input type="text" name="" class="form-control" value="<?php echo $size_name[0]['keyword_value'] ?>" id="size_<?php echo $i ?>" readonly /></td>
                <td><input type="text" name="" class="form-control" value="<?php echo (isset($value['order_qty'])) ? $value['order_qty'] : ''?>" id="orquat_<?php echo $i ?>" readonly /></td>                                   
                <td class="hide_this"><input type="text" name="" class="form-control" value="<?php echo $value['existing_qty'] ?>" id="exitqut_<?php echo $i ?>" readonly onkeyup="get_line(this)"/></td>
                <td><input type="text" name="" class="form-control" value="<?php echo (isset($value['remain_qty'])) ? $value['remain_qty'] : '' ?>" id="remain_<?php echo $i ?>" readonly /></td>
                <td><input type="text" name="" class="form-control price" value="<?php echo (isset($value['pack_qty'])) ? $value['pack_qty'] : '' ?>" id="packing_<?php echo $i ?>" onkeyup="calculate_remain(this)"/></td>
                <td class="hide_this"><input type="text" name="" class="form-control price" value="<?php echo (isset($value['pack_prod_id'])) ? $value['pack_prod_id'] : '' ?>" id="packpro_<?php echo $i ?>" /></td>
            </tr>
 
            <?php
            $i++;

            }

            }
            else {
            $i = 0;
            foreach ($invoi_pro as $value) {
            $this->db->select('code');
            $this->db->where('id', $value['prod_id']);
            $code = $this->db->get('conf_product')->result_array();

            $this->db->select('keyword_value');
            $this->db->where('keyword_id', $value['color_id']);
            $color_name = $this->db->get('conf_keyword')->result_array();

            $this->db->select('keyword_value');
            $this->db->where('keyword_id', $value['size_id']);
            $size_name = $this->db->get('conf_keyword')->result_array();
            
            
             $quantity=array(                
                'packingnote.inv_id'=>$invoices[0]['inv_id'],
                'packingnote_product.prod_id'=>$value['prod_id']
            );
            $total=$this->um->get_data('packingnote',$quantity,'packingnote_product','pack_id','pack_id');
            $net=0;
            foreach ($total as $quty) {
                $net+=$quty['pack_qty'];
            }
            $remaining=$value['quantity']-$net;
            
            ?>
            <tr>                
                <td class="hide_this"><input type="text" name="" class="form-control " value="<?php echo $value['inv_prod_id'] ?>" id="invproid_<?php echo $i ?>" /></td>                 
                <td><input type="text" name="" class="form-control " value="<?php echo $code[0]['code'] ?>" id="pcode_<?php echo $i ?>" /></td>                 
                <td class="hide_this"><input type="text" name="" class="form-control" value="<?php echo $value['prod_id'] ?>" id="pid_<?php echo $i ?>" readonly /></td>                 
                <td><input type="text" name="" class="form-control" value="<?php echo $value['prod_name'] ?>" id="pname_<?php echo $i ?>" readonly /></td>                 
                <td class="hide_this"><input type="text" name="" class="form-control" value="<?php echo $value['color_id'] ?>" id="colorid_<?php echo $i ?>" readonly /></td>
                <td><input type="text" name="" class="form-control" value="<?php echo $color_name[0]['keyword_value'] ?>" id="color_<?php echo $i ?>" readonly /></td>
                <td class="hide_this"><input type="text" name="" class="form-control" value="<?php echo $value['size_id'] ?>" id="sizeid_<?php echo $i ?>" readonly /></td>
                <td><input type="text" name="" class="form-control" value="<?php echo $size_name[0]['keyword_value'] ?>" id="size_<?php echo $i ?>" readonly /></td>
                <td><input type="text" name="" class="form-control" value="<?php echo $value['quantity'] ?>" id="orquat_<?php echo $i ?>" readonly /></td>                                   
                <td class="hide_this"><input type="text" name="" class="form-control" value="<?php echo $value['existing_qty'] ?>" id="exitqut_<?php echo $i ?>" readonly onkeyup="get_line(this)"/></td>
                <td><input type="text" name="" class="form-control" value="<?php echo $remaining ?>" id="remain_<?php echo $i ?>" readonly /></td>
                <td><input type="text" name="" class="form-control price" value="<?php echo (isset($value['pack_qty'])) ? $value['pack_qty'] : '' ?>" id="packing_<?php echo $i ?>" onkeyup="calculate_remain(this)"/></td>
            </tr>
            <input type="hidden" value="<?php echo $remaining; ?>" id="remaining_<?php echo $i?>"/>
            <?php
            $i++;

            }
             }
            ?>
        </table>

        <div class="sub_cancel">

            <input type="button" id="<?php echo (isset($packing)) ? 'update' : 'submit'; ?>" value="<?php echo (isset($packing)) ? 'Update' : 'Submit'; ?>" class="btn btn-primary"/>
            <a href="<?php echo base_url('packing') ?>" class="btn btn-success">Cancel</a>
        </div>
    </div>
</div>


<script src="<?php echo base_url('assets/js/custom/add_packing.js') ?>"></script> 
