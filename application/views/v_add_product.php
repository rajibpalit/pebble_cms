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
        <h3><b>New Product</b></h3>
    </div>
    <?php // print_r($product_part);exit;?>
    <input type="hidden" id="initilize_value" value="0">
    <input type="hidden" id="initilize_value1" value="1">
    <input type="hidden" id="initilize_value2" value="1">
    <input type="hidden" id="initilize_value3" value="1">
    <div style="margin-top: 5%; margin-left: 2%; margin-bottom: 50px">
        <form class="form-horizontal" id="keyword_insert" role="form" method="post" action="<?php echo base_url('main/product_list') ?>">

            <?php if (isset($product[0]['id'])) { ?>
                <input type="hidden" id="product_id" value="<?php echo $product[0]['id'] ?>"/>
            <?php } else {
                ?>
                <input type="hidden" id="product_id" value="0"/>
            <?PHP } ?>
            <div style="float: left; width: 100%">
                <div class="col-lg-5" style="float: left">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="product_name">Product Name<span style="color: red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="product_name" id="product_name" value="<?php echo (isset($product[0]['product_name'])) ? $product[0]['product_name'] : ''; ?>" class="form-control"  placeholder="Enter Product Name"/>
                            <label class="error product_error" for="name" id="product_name_error">Please enter product name.</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" style="float: left">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="code"> Code</label>
                        <div class="col-sm-8">
                            <input type="text" name="code" id="code" value="<?php echo (isset($product[0]['code'])) ? $product[0]['code'] : ''; ?>" class="form-control"  placeholder="Enter Product Code"/>
                            <label class="error product_error" for="name" id="code_error">Please enter product code.</label>
                        </div>
                    </div>
                </div>  
            </div>
            <div style="float: left; width: 100%">
                <div class="col-lg-5" style="float: left">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="color">Color</label>
                        <div class="col-sm-8">
                            <select required="required" class="form-control" id="color" name="color">
                                <option value="">Please Select</option>
                                <?php
                                foreach ($color as $co) {
                                    if ($co['keyword_id'] == $product[0]['color']) {
                                        $checked = 'selected';
                                    } else {
                                        $checked = '';
                                    }
                                    echo '<option ' . $checked . ' value="' . $co['keyword_id'] . '">' . $co['keyword_value'] . '</option>';
                                }
                                ?>

                            </select>
                            <label class="error product_error" for="name" id="color_error">Please select color.</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" style="float: left">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="size">Size</label>
                        <div class="col-sm-8">
                            <select required="required" class="form-control" id="size" name="size">
                                <option value="">Please Select</option>
                                <?php
                                foreach ($size as $co) {
                                    if ($co['keyword_id'] == $product[0]['size']) {
                                        $checked = 'selected';
                                    } else {
                                        $checked = '';
                                    }
                                    echo '<option ' . $checked . ' value="' . $co['keyword_id'] . '">' . $co['keyword_value'] . '</option>';
                                }
                                ?>
                            </select>
                            <label class="error product_error" for="name" id="size_error">Please select size.</label>
                        </div>
                    </div>
                </div>  
            </div>
            <div style="float: left; width: 100%">
                <div class="col-lg-5" style="float: left">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="skill">Skill</label>
                        <div class="col-sm-8">
                            <select required="required" class="form-control" id="skill" name="skill">
                                <option value="">Please Select</option>
                                <?php

                                foreach ($skill as $co) {
                                    if ($co['id'] == $product[0]['skill']) {
                                        $checked = 'selected';
                                    } else {
                                        $checked = '';
                                    }
                                    echo '<option ' . $checked . ' value="' . $co['id'] . '">' . $co['associated_action'] . '</option>';
                                }
                                ?>
                            </select>
                            <label class="error product_error" for="name" id="skill_error">Please select size.</label>
                        </div>
                    </div>
                </div>
                <div class="col-lg-5" style="float: left">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="flow">Flow</label>
                        <div class="col-sm-8">
                            <select required="required" class="form-control" id="flow" name="flow" onchange="autocomaction()">
                                <option value="">Please Select</option>
                                <?php
                                foreach ($flow as $co) {
                                    if ($co['keyword_id'] == $product[0]['flow']) {
                                        $checked = 'selected';
                                    } else {
                                        $checked = '';
                                    }
                                    echo '<option ' . $checked . ' value="' . $co['keyword_id'] . '">' . $co['keyword_value'] . '</option>';
                                }
                                ?>
                            </select>
                            <label class="error product_error" for="name" id="flow_error">Please select flow.</label>
                        </div>
                    </div>
                </div>  
            </div>
            <div style="float: left; width: 100%">
                <div class="col-lg-5" style="float: left">
                    <div class="form-group">
                        <label class="control-label col-sm-3" for="default_rate">Default Rate<span style="color: red">*</span></label>
                        <div class="col-sm-8">
                            <input type="text" name="default_rate" id="default_rate"  value="<?php echo (isset($product[0]['default_rate'])) ? $product[0]['default_rate'] : ''; ?>" class="form-control"  placeholder="Enter Default Rate"/>
                             <label class="error product_error" for="name" id="default_rate_error">Please select flow.</label>
                        </div>
                    </div>
                </div>

                <div class="col-lg-5" style="float: left">
                    <div id="image_preview">
                        <?php
                        if (isset($product[0]['picture'])) {

                            $picture_link1 = $product[0]['picture'];
                            $picture_link = "../../upload/image/" . $picture_link1;
                            if ($picture_link1 != NULL) {
                                ?>
                                <img id="previewing"  src="<?php echo $picture_link ?>"/>
                                <?php
                            } else {
                                ?>
                                <img id="previewing" src="../../assets/images/noimage.png" alt=""/>
                                <?php
                            }
                        } else {
                            ?>
                            <img id="previewing" src="../assets/images/noimage.png"/>
<?php } ?>
                           <label class="error product_error" for="name" id="skill_error">Please select size.</label> 
                    </div>
                    <div class="col-lg-5 form-group" style="margin-top: -16%; margin-left: 6%;">

                        <div id="selectImage" style="">
                            <div><label  style="">Picture</label></div>
                            <div style="margin-left: 48%; margin-top: -16%;">
                                <input type="file" name="file" id="file" value="noimage.png" />
                            </div>

                        </div>

                    </div>  
                    <div class="help-block" style="margin-left: 115px; margin-top: -43px; font-size: 12px;">Format: jpg, png, jpeg (Size 1 MB)</div>
                                  
                </div>
            </div>
    </div>
    <div style="float: left; width: 100%">
        <div class="col-lg-5" style="float: left; margin-left: 3%;">
            <div class="form-group">
                <div>
                    <label class="control-label col-sm-3" for="has_part" style="margin-right: 20px">Has Part </label>
                </div>
                <div style="margin-left: 13px;">
                    <label class="radio-inline">
                        <input type="radio" name="has_part" id="has_part" <?php echo isset($product) && ($product[0]['has_part'] == 1) ? 'checked' : '' ?> value="1"> Yes
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="has_part" id="has_part" <?php echo(!isset($product)) ? 'checked' : '' ?> <?php echo isset($product) && ($product[0]['has_part'] == 0) ? 'checked' : '' ?> value="0"> No
                    </label>
                </div>

            </div>
        </div>
        <div class="col-lg-5" style="float: left">
            <div class="form-group">
                <div>

                    <label class="control-label col-sm-3" for="status" style="margin-right: 20px">Status </label>
                </div>
                <div style="margin-left: 13px;">
                    <label class="radio-inline">
                        <input type="radio" name="status" id="p_status" <?php echo!isset($product) ? 'checked' : '' ?> <?php echo isset($product) && ($product[0]['status'] == 1) ? 'checked' : '' ?>  value="1"> Active
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="status" id="p_status" <?php echo isset($product) && ($product[0]['status'] == 0) ? 'checked' : '' ?> value="0"> Inactive
                    </label>
                </div>

            </div>
        </div>  
    </div>
    <div style="float: left; width: 100%; text-align: center; margin-top: 50px">
        <div>
            <label style="float: left">Action Time</label>
            <input type="button" hidden="hidden" value="Add Row" name="product_actiontime" id="add_row" style="margin-left: -14px; background-color: #6BCACE; width: 100px;padding-bottom: 8px; border-radius:5px;cursor: pointer; float: right" class="control-label col-sm-2">
        </div>
        <table class="table table-bordered" id="product_actiontime">
            <tr class="list_header">
                <th>Action </th>
                <th>Action Time</th>
                <th>Dist. Req?</th>
                <th></th>
            </tr>
<!--            <tr>
                <td><input type="text" name="" class="form-control" id="aname_0"/></td>
                <td><input type="text" name="" class="form-control" id ="atime_0"/></td>
                <td><input type="checkbox" checked value="1" style="margin-left: -77px" id="acheck_0" name="" class="form-control" onblur="autocomputaction()"/></td>
                <td class="hide_this"><input type="text" name="" class="form-control" id="acheckhide_0" /></td>
                <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
            </tr>-->
        </table>
    </div>
    <div style="float: left; width: 100%; text-align: center; margin-top: 50px; display: none;" id="p_part">
        <div>
            <label style="float: left">Product Part</label>

            <input type="button" value="Add Row" name="product_parts" id="add_row1" style="margin-left: -14px; width: 86px;padding-bottom: 8px; padding-top: 6px; border-radius:5px;cursor: pointer; float: right" class="btn btn-primary col-sm-2">
        </div>
        <table class="table table-bordered" id="product_parts">
            <tr class="list_header">
                <th>Part Name </th>
                <th>Code</th>
                <th>Qty</th>
                <th>Default Rate</th>
                <th>Color</th>
                <th>Size</th>
                <th></th>
            </tr>
            <?php
//                                    print_r($product_part[0]['part_name_id']);exit;
            if (isset($product_part)) {
                $i = 0;
                foreach ($product_part as $value) {
                    $this->db->select('id,product_name,color,size,code,default_rate');
                    $this->db->where('id=' . $value['part_name_id']);
                    $part_name = $this->db->get('conf_product')->result_array();

                    $this->db->select('keyword_value');
                    $this->db->where('keyword_id=' . $part_name[$i]['color']);
                    $p_color = $this->db->get('conf_keyword')->result_array();
                    $this->db->select('keyword_value');
                    $this->db->where('keyword_id=' . $part_name[$i]['size']);
                    $p_size = $this->db->get('conf_keyword')->result_array();

                    echo ' <tr>
                <td><input type="text" name="" class="form-control example" value="' . $part_name[0]['product_name'] . '" id="pname_0" onclick="autocompart(this)" onblur="computpart(this)"/></td>
                <td><input type="text" name="" readonly class="form-control" value="' . $part_name[0]['code'] . '" id="pcode_0"/></td>
                <td><input type="text" name="" class="form-control" value="' . $value['quantity'] . '" id="pquantity_0"/></td>
                <td><input type="text" name="" readonly class="form-control" value="' . $part_name[0]['default_rate'] . '" id="pdefault_rate_0"/></td>
                <td><input type="text" name="" readonly class="form-control" value="' . $p_color[$i]['keyword_value'] . '" id="pcolor_0"/></td>
                <td><input type="text" name="" readonly class="form-control" value="' . $p_size[$i]['keyword_value'] . '" id="psize_0"/></td>
                <td class="hide_this"><input type="text" name="" class="form-control" value="' . $value['id'] . '" id="part_name_id_0" readonly /></td>
                <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
                }
                $i++;
//                print_r($part_name);exit;
            } else {
//                
                ?>
                <tr>
                    <td><input type="text" name="" class="form-control example" id="pname_0" onclick="autocompart(this)" onblur="computpart(this)"/></td>
                    <td><input type="text" name="" readonly class="form-control" id="pcode_0"/></td>
                    <td><input type="text" name=""  class="form-control" id="pquantity_0"/></td>
                    <td><input type="text" name="" readonly class="form-control" id="pdefault_rate_0"/></td>
                    <td><input type="text" name="" readonly class="form-control" id="pcolor_0"/></td>
                    <td><input type="text" name="" readonly class="form-control" id="psize_0"/></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="part_name_id_0" readonly /></td>
                    <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>

                </tr>
<?php } ?>
        </table>
    </div>
    <div style="float: left; width: 100%; text-align: center; margin-top: 50px">
        <div>
            <label style="float: left">Raw Material</label>
            <input type="button" value="Add Row" name="product_rawmaterials" id="add_row2" style="margin-left: -14px; width: 86px;padding-bottom: 8px; padding-top: 6px; border-radius:5px;cursor: pointer; float: right" class="btn btn-primary col-sm-2">
        </div>
        <table class="table table-bordered" id="product_rawmaterials">
            <tr class="list_header">
                <th>Material Name</th>
                <th>MU</th>
                <th>Color</th>
                <th>Size</th>  
                <th>Material Code</th>
                <th>Quantity</th>
                <th></th>
            </tr>
            <?php
//                                    print_r($rawmaterial);exit;
            if (isset($rawmaterial)) {
                $i = 0;
                foreach ($rawmaterial as $value) {
                    $this->db->select('material_name');
                    $this->db->where('id=' . $value['raw_material_id']);
                    $material_name = $this->db->get('conf_rawmaterial')->result_array();
//                    print_r($mu_name[0]['keyword_value']);exit;
                    $this->db->select('keyword_value');
                    $this->db->where('keyword_id=' . $value['m_unit_id']);
                    $mu_name = $this->db->get('conf_keyword')->result_array();
//                    print_r($mu_name[0]['keyword_value']);exit;
                    $this->db->select('keyword_value');
                    $this->db->where('keyword_id=' . $value['size_id']);
                    $size_name = $this->db->get('conf_keyword')->result_array();
                    echo ' <tr>

                <td><input type="text" name="" class="form-control" id="mname_0" value="' . $material_name[$i]['material_name'] . '" onclick="autocommaterial(this)" onblur="computmaterial(this)"/></td>
                <td><input type="text" name="" class="form-control" id="mmu_0" value="' . $mu_name[$i]['keyword_value'] . '" readonly/></td>
                <td><input type="text" name="" class="form-control" id="mcolor_0" value="' . $value['keyword_value'] . '" readonly/></td>
                <td><input type="text" name="" class="form-control" id="msize_0" value="' . $size_name[$i]['keyword_value'] . '" readonly/></td>
                <td><input type="text" name="" class="form-control"id="mcode_0" value="' . $value['id'] . '" readonly/></td>  
                <td><input type="text" name="" class="form-control" id="mquantity_0" value="' . $value['quantity'] . '"/></td>
                <td class="hide_this"><input type="text" name="" class="form-control" id="mnameid_0" value="' . $value['raw_material_id'] . '" readonly /></td>
                <td class="hide_this"><input type="text" name="" class="form-control" id="mmuid_0" value="' . $value['m_unit_id'] . '" readonly /></td>
                <td class="hide_this"><input type="text" name="" class="form-control" id="mcolorid_0" value="' . $value['color_id'] . '" readonly /></td>
                <td class="hide_this"><input type="text" name="" class="form-control" id="msizeid_0" value="' . $value['size_id'] . '" readonly /></td>
                <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
                }
                $i++;
            } else {
                ?>
                <tr>

                    <td><input type="text" name="" class="form-control" id="mname_0" onclick="autocommaterial(this)" onblur="computmaterial(this)"/></td>
                    <td><input type="text" name="" class="form-control" id="mmu_0" readonly/></td>
                    <td><input type="text" name="" class="form-control" id="mcolor_0" readonly/></td>
                    <td><input type="text" name="" class="form-control" id="msize_0" readonly/></td>
                    <td><input type="text" name="" class="form-control"id="mcode_0" readonly/></td>  
                    <td><input type="text" name="" class="form-control" id="mquantity_0"/></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="mnameid_0" readonly /></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="mmuid_0" readonly /></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="mcolorid_0" readonly /></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="msizeid_0" readonly /></td>
                    <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                </tr>
<?php } ?>
        </table>
    </div>
    <div style="float: left; width: 100%; text-align: center; margin-top: 50px">
        <div>
            <label style="float: left">Client Product Rate</label>
            <input type="button" value="Add Row" name="product_clientrate" id="add_row3" style="margin-left: -14px; width: 86px;padding-bottom: 8px; padding-top: 6px; border-radius:5px;cursor: pointer; float: right" class="btn btn-primary col-sm-2">
        </div>
        <table class="table table-bordered" id="product_clientrate">
            <tr class="list_header">
                <th>Client Name</th>
                <th>Current Rate</th>
                <th>Currency</th>
                <th>Rate Date</th>
                <th>Client P Code</th>
                <th></th>
            </tr>
            <?php
//                                    print_r($clientrate[0]['currency_id']);exit;
            if (isset($clientrate)) {
                $i = 0;
                foreach ($clientrate as $value) {
                    $this->db->select('client_name');
                    $this->db->where('client_id=' . $value['client_id']);
                    $client_name = $this->db->get('conf_client')->result_array();

                    $this->db->select('short_form');
                    $this->db->where('country=' . $value['currency_id']);
                    $currency_name = $this->db->get('conf_currency')->result_array();
//                    print_r($currency_name);exit;

                    echo ' <tr>
                <td><input type="text" name="" id="client_name_0" class="form-control" value="' . $client_name[0]['client_name'] . '" onclick="autocomrate(this)" onblur="autocomputrate(this)"/>                </td>
                <td><input type="text" name="" id="current_rate_0" value="' . $value['current_rate'] . '" class="form-control"/></td>
                <td><input type="text" name="" id="currency_name_0" value="' . $currency_name[$i]['short_form'] . '" class="form-control"/></td>
                <td class="hide_this"><input type="text" name="" value="' . $value['id'] . '" class="form-control" id="currency_id_0" readonly /></td>
                <td><input type="text" name="" id="rate_date_0" value="' . $value['rate_date'] . '" class="form-control"/></td>
                <td><input type="text" name="" id="client_p_code_0" value="' . $value['client_p_code'] . '" class="form-control"/></td>
                <td class="hide_this"><input type="text" name="" value="' . $value['client_id'] . '" class="form-control" id="client_id_0" readonly /></td>
                <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
                    $i++;
                }
            } else {
                ?>
                <tr>
                    <td><input type="text" name="" id="client_name_0" class="form-control" onclick="autocomrate(this)" onblur="autocomputrate(this)"/></td>
                    <td><input type="text" name="" id="current_rate_0" class="form-control"/></td>
                    <td><input type="text" name="" id="currency_name_0" class="form-control" readonly/></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="currency_id_0" readonly /></td>
                    <td><input type="text" name="" onfocus="datepick(this)" id="rate_date_0" class="form-control" readonly/></td>
                    <td><input type="text" name="" id="client_p_code_0" class="form-control"/></td>
                    <td class="hide_this"><input type="text" name="" class="form-control" id="client_id_0" readonly /></td>
                    <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                </tr>
<?php } ?>
        </table>
    </div>

    <div class="col-lg-5" style="float: right; margin-right: -131px;">
        <div class="form-group">
            <label class="control-label col-sm-3" style="margin-left: 0px; margin-top: 3px;" for="size"><h4><b>Attachment</b></h4></label>
            <div class="col-sm-8">
                <input type="file" id="attachment" style="padding-bottom: 40px; border: none;" name="attachment" class="form-control"/>
            </div>
            <div class="help-block" style="margin-left: 140px; margin-top: 3px; font-size: 12px;">Format: pdf, doc, txt</div>
            <div id="file_message"></div>
        </div>

    </div>

    <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;">        
        <div class="col-sm-offset-2 col-sm-10" style="margin-left: 300px;margin-bottom: 50px;">
            <button type="button" name="submit" id="submit" class="btn col-sm-3 save-button-color" style=""><b>Save</b></button>                  
            <a href="<?php echo base_url('main/product_list'); ?>" class="btn col-sm-3 close-button-color" style=""><b><?php echo (isset($product)) ? 'Back' : 'Close' ?></b></a>                                                        
        </div>
    </div>
</form>
</div>
<script type="text/javascript">
    $(document).ready(function(){
        $("#product_name").keyup(function(){
            $('#product_name_error').hide();
        });
        $("#code").keyup(function(){
            $('#code_error').hide();
        });
        $("#color").on('change',function(){
            $('#color_error').hide();
        });
        $("#size").on('change',function(){
            $('#size_error').hide();
        });
        $("#skill").on('change',function(){
            $('#skill_error').hide();
        });
        $("#flow").on('change',function(){
            $('#flow_error').hide();
        });
        $("#default_rate").keyup(function(){
            $('#default_rate_error').hide();
        });
        $("#product_name").keyup(function(){
            $('#product_name_error').hide();
        });
        
    })
</script>

<script>
    
    $('.error').hide();
</script>
<script type="text/javascript" src="<?php echo base_url("assets/js/custom/add_product.js"); ?>"></script>
