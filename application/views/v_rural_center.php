<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Rural Center</b></h3>
    </div>
    <input type="hidden" id="initilize_bank" value="1"/>
    <input type="hidden" id="initilize_product" value="1"/>
    <div style="margin-top: 5%; margin-left: 15%">
        <form class="form-horizontal" id="rural_center_form" role="form" method="post" action="<?php echo base_url('main/add_rural_center') ?>">
            <?php if (isset($value)) { ?>
            <input type="hidden" id="id"  value="<?php echo $value[0]['id'] ?>" name="id" >
            <?php } ?>
                <?php if (isset($skills)) { 
                $i = count($skills);?>
                <input type="hidden" value="<?php echo $i ?>" id="skill_no" name="skill_id" >
            <?php } ?>
                <?php if (isset($products)) { 
                $j = count($products);?>
                <input type="hidden" value="<?php echo $j ?>" id="product_no" name="product_id" >
            <?php } ?>
            <div class="form-group">
                <label class="control-label col-sm-2" for="center_name">Rural Center Name*</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="center_name" value="<?php echo isset($value) ? $value[0]['center_name'] : '' ?>" id="center_name" placeholder="Rural Center Name">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="address">Address *</label>
                <div class="col-sm-3">
                    <textarea class="form-control" name="address" value="" id=""><?php echo isset($value) ? $value[0]['address'] : '' ?></textarea>

                </div>
            </div>    
            <div class="form-group">
                <label class="control-label col-sm-2" for="artisan_capacity">Artisan Capacity</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" readonly class="form-control" name="artisan_capacity" value="<?php echo isset($value) ? $value[0]['artisan_capacity'] : '' ?>" id="artisan_capacity" placeholder="Enter Artisan Capacity">
                </div>
            </div>    
            <div class="form-group">
                <label class="control-label col-sm-2" for="hour_capacity">Hour Capacity</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" readonly class="form-control" name="hour_capacity" value="<?php echo isset($value) ? $value[0]['hour_capacity'] : '' ?>" id="hour_capacity" placeholder="Enter Hour Capacity">
                </div>
            </div> 
            <div class="form-group">
                <label class="control-label col-sm-2" for="hourly_rate">Hourly Rate</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" readonly class="form-control" name="hourly_rate" value="<?php echo isset($value) ? $value[0]['hourly_rate'] : '' ?>" id="hourly_rate" placeholder="Enter Hourly Rate">
                </div>
            </div>    
            <div class="form-group">
                <label class="control-label col-sm-2" for="remarks">Remarks</label>
                <div class="col-sm-3">          
                    <input type="text" required="required" class="form-control" name="remarks" value="<?php echo isset($value) ? $value[0]['remarks'] : '' ?>" id="" placeholder="Enter Remarks">
                </div>
            </div>
            <div class="form-group">
                <div>

                    <label class="control-label col-sm-2" for="status" style="margin-right: 20px">Status </label>
                </div>
                <div style="margin-left: 13px;">
                    <label class="radio-inline">
                        <input type="radio" name="status" <?php echo!isset($value) ? 'checked' : '' ?> <?php echo isset($value) && ($value[0]['status'] == 1) ? 'checked' : '' ?> id="inlineRadio1" value="1"> Active
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="status" id="inlineRadio2" <?php echo isset($value) && ($value[0]['status'] == 0) ? 'checked' : '' ?> value="0"> Inactive
                    </label>
                </div>

            </div>
        </form>
    </div>
    <h2>Skill Table</h2>
    <div style="float: right;">
        <div class="col-lg-7">          
            <input type="button" id="<?php echo (isset($skills)) ? 'update_skill_row' : 'add_skill' ?>" value="Add Row" class="btn btn-primary"/>
        </div>
    </div>
    <table class="table table-bordered" id="bank_table">
        <tr class="list_header">               
            <th class="hide_this">Skill id</th>              
            <th>Skill Name</th>              
            <th>Supervisor Name</th>              
            <th>Artisan Capacity</th>                
            <th>Hour Capacity</th>                
            <th>Hourly Rate</th>
            <th>Basic Skill</th>
            <th></th>

        </tr>
        <?php
        if (isset($skills)) {
            $i = 0;
            foreach ($skills as $skill) {
                $where['id'] = $skill['skill_id'];
                $this->db->select('*');
                $this->db->where($where);
                $product_name = $this->db->get('conf_skills')->result_array();
                ?>
                <tr>                
                                       
                    <td class="hide_this"><input type="text" name="id" value="<?php echo $skill['skill_id']?>" class="form-control " id="skillid_0" /></td>                   
                    <td><input type="text" name="" value="<?php echo $product_name[0]['description']; ?>" class="form-control " id="name_<?php echo $i?>" onclick="autocom(this)" /></td>                   
                    <td><input type="text" name="" value="<?php echo $skill['supervisor']; ?>" class="form-control " id="supervisor_0"/></td>                   
                    <td><input type="text" name="" value="<?php echo $skill['artisan_capacity']; ?>" class="form-control artisan_capacity" id="artisan_0"  onkeyup="artisan_capacity(this)"/></td>                    
                    <td><input type="text" name="" value="<?php echo $skill['hour_capacity']; ?>" class="form-control hourly_capacity" id="hour_0"  onkeyup="hourly_capacity(this)"/></td>                  
                    <td><input type="text" name="" value="<?php echo $skill['hourly_rate']; ?>" class="form-control hourly_rate" id="hourly_0" onkeyup="hourly_rate(this)"/></td>
                    <td><input type="text" name="" value="<?php echo $skill['basic_skill']; ?>" class="form-control" id="basic_0" /></td>
                    <td class="hide_this"><input type="text" name="" value="<?php echo $skill['status']; ?>" class="form-control price" id="active_0" /></td>
                    <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                    <td class="hide_this"><input type="text" name="" value="<?php echo $skill['id']?>" class="form-control " id="id_0" /></td>
                    <td class="hide_this"><input type="text" name="" value="<?php echo $skill['ruralcenter_id']?>" class="form-control " id="skill_ruralcenter_id_0" /></td>
                </tr>
                
            <?php $i++;}
        } else {
            ?>
            <tr>                
                <td class="hide_this"><input type="text" name="" class="form-control " id="skillid_0" /></td>                   
                <td><input type="text" name="" class="form-control " id="name_0" onclick="autocom(this)" /></td>                   
                <td><input type="text" name="" class="form-control " id="supervisor_0"/></td>                   
                <td><input type="text" name="" class="form-control artisan_capacity" id="artisan_0"  onkeyup="artisan_capacity(this)"/></td>                    
                <td><input type="text" name="" class="form-control hourly_capacity" id="hour_0"  onkeyup="hourly_capacity(this)"/></td>                  
                <td><input type="text" name="" class="form-control hourly_rate" id="hourly_0" onkeyup="hourly_rate(this)"/></td>
                <td><input type="text" name="" class="form-control" id="basic_0" /></td>
                <td class="hide_this"><input type="text" name="" class="form-control price" id="active_0" /></td>
                <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
            </tr>
<?php } ?>
    </table>

    <h2>Product Table</h2>
    <div style="float: right;">
        <div class="col-lg-7">          
            <input type="button" id="<?php echo (isset($products)) ? 'update_product_row' : 'add_product' ?>" value="Add Row" class="btn btn-primary"/>
        </div>
    </div>
    <table class="table table-bordered" id="product_table">
        <tr class="list_header">               
            <th class="hide_this">Product id</th>              
            <th>Product Name</th>              
            <th>Product Code</th>                               
            <th></th>              
        </tr>
        <?php
        if (isset($products)) {
            $j = 0;
            foreach ($products as $product) {
                $where['id'] = $product['product_id'];
                $this->db->select('*');
                $this->db->where($where);
                $product_name = $this->db->get('conf_product')->result_array();
                
                ?>
                <tr>                
                    <td class="hide_this"><input type="text" name="id" class="form-control" id="productid_<?php echo $j?>" value="<?php echo $product['product_id']?>" readonly /></td>                    
                    <td><input type="text" name="" value="<?php echo $product_name[0]['product_name']; ?>" class="form-control " id="pname_<?php echo $j?>" onclick="product_autocom(this)" onblur="product_info(this)"/></td>                   
                    <td><input type="text" name="" value="<?php echo $product['product_code']; ?>" class="form-control" id="pcode_<?php echo $j?>" readonly /></td> 
                    <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow_roduct(this)"/></td>
                    <td class="hide_this"><input type="text" name="" value="<?php echo $product['id']?>" class="form-control" id="id_<?php echo $j?>" readonly /></td>     
                    <td class="hide_this"><input type="text" name="" value="<?php echo $product['ruralcenter_id']?>" class="form-control" id="ruralcenter_id_<?php echo $j?>" readonly /></td>     
            <?php $j++; }
        } else {
            ?>
            <tr>                
                <td class="hide_this"><input type="text" name="" class="form-control" id="productid_0" readonly /></td>                    
                <td><input type="text" name="" class="form-control " id="pname_0" onclick="product_autocom(this)" onblur="product_info(this)"/></td>                   
                <td><input type="text" name="" class="form-control" id="pcode_0" readonly /></td>                    

                <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow_roduct(this)"/></td>
            </tr>
        <?php }
        ?>




    </table>

    <div class="sub_cancel">

      
        <input type="button" id="<?php echo (isset($value[0]['id'])) ? 'update' : 'add_data'; ?>" value="<?php echo (isset($value[0]['id'])) ? 'Update' : 'Submit'; ?>" class="btn btn-primary"/>
      
        <a href="<?php echo base_url('home/invoice') ?>" class="btn btn-success">Cancel</a>
    </div>

</div>


<script>
    $.validator.setDefaults({
        submitHandler: function () {
            alert("submitted!");
        }
    });

//    $().ready(function () {
//
//
//        $("#rural_center_form").validate({
//            rules: {
//                center_name: "required",
//                artisan_capacity: "required",
//                hour_capacity: "required",
//                hourly_rate: "required"
//            },
//            messages: {
//                center_name: "Please enter center name.",
//                artisan_capacity: "Please artisan capacity.",
//                hour_capacity: "Please enter hour capacity.",
//                hourly_rate: "Please enter hourly rate."
//            }
//        });
//    });
</script>


<script>
    $('#submit').on('click', function () {
        if ($('#key_id').val() == '') {
            $('#key_id').css('border', '1px solid red');

        }
        else {
            $('#key_id').css('border', '1px solid #ccc');

        }
        if ($('#keyword_value').val() == '') {
            $('#keyword_value').css('border', '1px solid red');

        }
        else {
            $('#keyword_value').css('border', '1px solid #ccc');

        }
    });
</script>
<script type="text/javascript" src="<?php echo base_url('assets/js/custom/rural_center.js') ?>"></script>
