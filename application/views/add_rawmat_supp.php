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
                <?php echo (isset($suppliers)) ? 'Update Supplier' : 'New Supplier' ?></b></h3>
    </div> 
    <input type="hidden" id="initilize_value" value="<?php echo (isset($sup_prod)) ? count($sup_prod) : 1 ?>"/>
    <div style="margin-top: 5%; margin-left: 2%;">
        <form class="form-inline" id="rawmat_form" method="POST" action="<?php echo base_url('rawmatsupp/supplier_from') ?>">
            <?php if (isset($suppliers)) { ?>
                <input type="hidden" name="supplier_id" id="supplier_id" value="<?php echo $suppliers[0]['id'] ?>"/>
            <?php } ?>

            <div class="form-group">
                <label for="supplier_name">Supplier Name*</label>
                <input type="text" name="supplier_name" id="supplier_name" value="<?php echo (isset($suppliers)) ? $suppliers[0]['supplier_name'] : '' ?>" class="form-control"/>
            </div>
            <div class="form-group">
                <label for="exampleInputName2">Address</label>
                <textarea class="form-control" name="address" id="address" cols="10" rows="2" ><?php echo (isset($suppliers)) ? $suppliers[0]['address'] : '' ?></textarea>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <!--<input type="text" class="form-control" id="email" placeholder="Email" name="email" value="<?php echo (isset($suppliers)) ? $suppliers[0]['email'] : '' ?>" >-->
                <input type="email" id="email" class="form-control" name="email" value="<?php echo (isset($suppliers)) ? $suppliers[0]['email'] : '' ?>" id="mail" placeholder="Enter Email" data-rule-required="true" data-rule-email="true" data-msg-required="Please enter your email address" data-msg-email="Please enter a valid email address">
            </div>
            <div class="form-group">
                <label for="contact_no">Phone</label>
                <input type="text" class="form-control" id="contact_no" name="contact_no" value="<?php echo (isset($suppliers)) ? $suppliers[0]['phone_no'] : '' ?>"  placeholder="Contact Number" >
            </div>
            <div class="form-group">
                <label for="fax">Fax</label>
                <input type="text" class="form-control" id="fax" value="<?php echo (isset($suppliers)) ? $suppliers[0]['fax'] : '' ?>" name="fax" placeholder="Supplier Fax number">
            </div>

            <div class="form-group">
                <label for="web">Web</label>
                <input type="text" class="form-control" id="web" name="web" placeholder="Web address" value="<?php echo (isset($suppliers)) ? $suppliers[0]['webaddress'] : "" ?>">
            </div>                           
            <div class="form-group">
                <label for="web">Status</label>
                <label class="radio-inline">
                    <input type="radio" name="status" <?php echo(isset($suppliers[0]['status']) && $suppliers[0]['status'] == 1) ? 'Checked' : '' ?> id="inlineRadio1" class="inline_checkbox" value="1">Active
                </label>
                <label class="radio-inline">
                    <input type="radio" name="status" id="inlineRadio2" <?php echo(isset($suppliers[0]['status']) && $suppliers[0]['status'] == 0) ? 'Checked' : '' ?> class="inline_checkbox" value="0">Inactive
                </label>
            </div>                           

        </form>     
        <div style="margin-top: 50px "></div>
        <div style="float: right;">
            <div class="col-lg-7">              
                <input type="button" id="<?php echo (isset($sup_prod)) ? 'update_row' : 'add_row' ?>" value="Add Row" class="btn btn-primary"/>
            </div>
        </div>
        <table class="table table-bordered" id="bank_table">
            <tr class="list_header">
                <?php
                if (isset($sup_prod)) {
                    echo '<th class="hide_this">supplier product id</th>';
                }
                ?>                
                <th>Material code</th>
                <th class="hide_this">Matarial_id</th>
                <th>Material Name</th>
                <th>Unit Price</th>
                <th>Lead Time</th>
                <th>MU Name</th>
                <th class="hide_this">MU id</th>
                <th>Color</th> 
                <th class="hide_this">Color id</th>
                <th>Size</th>                
                <th class="hide_this">size id</th>
                <th></th>
            </tr>
            <?php
            if (isset($sup_prod)) {
                $i = count($sup_prod) - 1;
                foreach ($sup_prod as $product) {
                    $this->db->select('keyword_value');
                    $this->db->where('keyword_id', $product['color_id']);
                    $coror_name = $this->db->get('conf_keyword')->result_array();

                    $this->db->select('keyword_value');
                    $this->db->where('keyword_id', $product['size_id']);
                    $size_name = $this->db->get('conf_keyword')->result_array();

                    $this->db->select('keyword_value');
                    $this->db->where('keyword_id', $product['m_unit_id']);
                    $mu_name = $this->db->get('conf_keyword')->result_array();
                  
                    $this->db->select('*');
                    $this->db->where('id', $product['material_id']);
                    $matarial = $this->db->get('conf_rawmaterial')->result_array();
                    ?>
                    <tr>                                      
                        <td class="hide_this"><input type="text" name="" class="form-control" value="<?php echo $product['id']; ?>" id="matid_<?php echo $i; ?>"/></td>                                                                                              
                        <td><input type="text" name="" class="form-control " id="name_<?php echo $i; ?>" onclick="autocom(this)" onblur="compute_field(this)" value="<?php echo $matarial[0]['material_code']?>"/></td>
                        <td class="hide_this"><input type="text" name=""   value="<?php echo $matarial[0]['id']?>" class="form-control" id="marialid_<?php echo $i; ?>" readonly /></td>                  
                        <td><input type="text" name="" class="form-control" id="matname_<?php echo $i; ?>"  value="<?php echo $matarial[0]['material_name']?>" readonly /></td>
                        <td><input type="text" name="" class="form-control" id="price_<?php echo $i; ?>" value="<?php echo $product['unit_price']?>"/></td>
                        <td><input type="text" name="" class="form-control" id="leadtime_<?php echo $i; ?>" value="<?php echo $product['lead_time']?>"/></td>
                        <td><input type="text" name="" class="form-control" id="muname_<?php echo $i; ?>" readonly value="<?php echo $mu_name[0]['keyword_value']?>"/></td>                    
                        <td class="hide_this"><input type="text" name="" class="form-control" id="muid_<?php echo $i; ?>" value="<?php echo $matarial[0]['m_unit_id']?>"/></td>                    
                        <td><input type="text" name="" class="form-control" id="color_<?php echo $i; ?>" readonly value="<?php echo $coror_name[0]['keyword_value']?>"/></td>
                        <td class="hide_this"><input type="text" name="" class="form-control" id="colorid_<?php echo $i; ?>"  value="<?php echo $matarial[0]['color_id']?>"/></td>
                        <td><input type="text" name="" class="form-control" id="size_<?php echo $i; ?>" readonly value="<?php echo $size_name[0]['keyword_value']?>"/></td>
                        <td class="hide_this"><input type="text" name="" class="form-control" id="sizeid_<?php echo $i; ?>"   value="<?php echo $matarial[0]['size_id']?>"/></td> 
                        <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                    </tr>
                    <?php
                }
            } else {
                ?>
                <tr>                          
                    <td><input type="text" name="" class="form-control " id="name_0" onclick="autocom(this)" onblur="compute_field(this)"/></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="marialid_0" readonly /></td>                  
                    <td><input type="text" name="" class="form-control" id="matname_0" readonly /></td>
                    <td><input type="text" name="" class="form-control" id="price_0" /></td>
                    <td><input type="text" name="" class="form-control" id="leadtime_0" /></td>
                    <td><input type="text" name="" class="form-control" id="muname_0" readonly/></td>                    
                    <td class="hide_this"><input type="text" name="" class="form-control" id="muid_0" readonly/></td>                    
                    <td><input type="text" name="" class="form-control" id="color_0" readonly /></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="colorid_0" readonly /></td>
                    <td><input type="text" name="" class="form-control" id="size_0" readonly /></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="sizeid_0" readonly /></td>                    
                    <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                </tr>
            <?php } ?>
        </table>



        <div class="sub_cancel">
            <input type="button" id="<?php echo (isset($sup_prod)) ? 'update' : 'submit'; ?>" value="<?php echo (isset($inv_product)) ? 'Update' : 'Submit'; ?>" class="btn btn-primary"/>
            <a href="<?php echo base_url('rawmat_pur') ?>" class="btn btn-success">Cancel</a>
        </div>
    </div>
</div>
<!-- Button trigger modal -->


<script src="<?php echo base_url('assets/js/custom/add_rawmat_supp.js') ?>"></script> 
<script>
    $.validator.setDefaults({
        submitHandler: function () {
            alert("submitted!");
        }
    });

    $().ready(function () {

        // validate signup form on keyup and submit
        $("#rawmat_form").validate({
            rules: {
                material_name: "required",
                country: "required",
                contact_no: "required",
                mobile_no: "required",
                interval_days: "required",
            },
            messages: {
                material_name: "Please enter material name.",
                country: "Please enter country.",
                contact_no: "Please enter contact no.",
                mobile_no: "Please enter mobile no.",
                interval_days: "Please enter interval days.",
            }
        });
    });

    $(document).ready(function () {
        $("#rawmat_form").validate({
            messages: {
                email: {
                    required: 'Enter this!'
                }
            }
        });
    });
</script>