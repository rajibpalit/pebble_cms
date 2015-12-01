<script>
    var pathArray = location.pathname.split('/');
    var loc = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';
</script>


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
        <h3><b>Stock Entry</b></h3>
    </div>

    <input type="hidden" id="initilize_value1" value="1">
    <input type="hidden" id="array_size" value="<?php echo sizeof($stock); ?>">
    <div style="margin-top: 5%; margin-left: 15%;">
        <form class="form-horizontal" id="keyword_insert" role="form" method="post" action="<?php echo base_url('main/add_currency') ?>">

            <div style="float: left; width: 115%; margin-left: -15%;">

                <input type="button" value="Add Row" name="distributed_id" id="add_row" style="float: right; width: 86px;padding-bottom: 8px; padding-top: 6px; border-radius:5px;cursor: pointer; " class="btn btn-primary col-sm-2">
                <table class="table table-bordered" id="distribution_wozerd">
                    <tr class="list_header">
                        <th>Product<br> Name</th>                       
                        <th>Product<br> Number</th> 
                        <th>Color</th>
                        <th>Size</th>
                        <th>Existing<br> Quantity</th>
                        <th>Quantity</th>
                        <th>Total Quantity</th>
                        <th>Last<br> update date</th>
                        <th>Remarks</th>
                    </tr>
                    <?php
                    if (isset($stock)) {
                        $i = 0;
                        foreach ($stock as $value) {
                            $this->db->select('id,product_name,color,size,code,default_rate');
                            $this->db->where('id=' . $value['product_id']);
                            $part_name = $this->db->get('conf_product')->result_array();

                            $this->db->select('keyword_value');
                            $this->db->where('keyword_id=' . $part_name[0]['color']);
                            $p_color = $this->db->get('conf_keyword')->result_array();
                            $this->db->select('keyword_value');
                            $this->db->where('keyword_id=' . $part_name[0]['size']);
                            $p_size = $this->db->get('conf_keyword')->result_array();
                            ?>
                            <tr>
                                <td><input type="text" name="pname" readonly class="form-control example" value="<?php echo $part_name[0]['product_name'] ?> " id="pname_<?php echo $i ?>" onclick="autocompart(this)" onblur="computpart(this)"/></td>
                                <td><input type="text" name="pcode" readonly class="form-control" value="<?php echo $part_name[0]['code'] ?>" id="pcode_<?php echo $i ?>"/></td>
                                <td><input type="text" name="pcolor" readonly class="form-control" value="<?php echo $p_color[0]['keyword_value'] ?>" id="pcolor_<?php echo $i ?>"/></td>
                                <td><input type="text" name="psize" readonly class="form-control" value="<?php echo $p_size[0]['keyword_value'] ?>" id="psize_<?php echo $i ?>"/></td>
                                <td><input type="text" name="existing_qty" readonly class="form-control price" value="<?php echo $value['existing_qty'] ?>" id="existing_qty_<?php echo $i ?>"/></td>
                                <td><input type="text" name="quantity" class="form-control" value="0" id="quantity_<?php echo $i ?>" onblur="get_line(this)"/></td>
                                <td><input type="text" name="total_quantity" readonly class="form-control price" value="" id="total_quantity_<?php echo $i ?>"/></td>
                                <td><input type="text" name="last_updated" readonly class="form-control" value="<?php echo $value['last_updated'] ?>" id="last_updated_<?php echo $i ?>"/></td>
                                <td><input type="text" name="remarks" readonly class="form-control" value="<?php echo $value['remarks'] ?>" id="remarks_<?php echo $i ?>"/></td>
                                <td class="hide_this"><input type="text" name="stock_id" class="form-control" value="<?php echo $value['stock_id'] ?>" id="stock_id_<?php echo $i ?>" readonly /></td>
                                <td class="hide_this"><input type="text" name="" class="form-control" id="pid_<?php echo $i ?>" readonly /></td>


                                <?php
                                $i++;
                            }

//                print_r($part_name);exit;
                        }
                        ?>
                    </tr>
                </table>
            </div>
            <div class="form-group" style="alignment-adjust: middle; margin-top: 50px;">        
                <div class="col-sm-offset-2 col-sm-10" style="margin-left: 300px;margin-bottom: 50px; margin-left: 4%;">
                    <button type="button" name="submit" id="submit" class="btn col-sm-3 save-button-color" style="width: 300px;"><b>Save Stock</b></button>                  
                    <a href="<?php echo base_url('home/stock_list'); ?>" class="btn col-sm-3 close-button-color" style="margin-right: 10px;"><b><?php echo 'Back'?></b></a>                                                        
                    <a href="<?php echo base_url('#'); ?>" class="btn col-sm-3 close-button-color" style=""><b><?php echo 'Print' ?></b></a>                                                        
                </div>
            </div>
        </form>

    </div>

</div>

<script>
    $('#submit').on('click', function () {


        var rowsArray = {};
        var i = 0;
        $('#distribution_wozerd tr td input,#distribution_wozerd tr td select').each(function () {
            rowsArray[i] = $(this).val();
            i++;
        });
//        console.log(rowsArray);
//        console.log(value);
//        exit;
        var data_save = loc + 'update_and_insert_stock';
        $.ajax({
            type: 'post',
            url: data_save,
            data: {rowsArray: rowsArray},
            success: function (result) {

                console.log('ok');
//                exit;
                var root = location.protocol + '//' + location.host;
                window.location.href = root + "/pebblescms/home/stock_list";
            }
        });
    });




    function get_line(obj) {
        var id = obj.id;
        var saper_id = id.split("_");
        var i = saper_id[1];
        var quantity = $('#' + id).val();
        var existing_qty = $('#existing_qty_' + i).val();
        var temp = $('#existing_qty_' + i).val();
        var total_qty = parseInt(quantity) + parseInt(existing_qty);
        $('#total_quantity_' + i).val(total_qty);
        var today = new Date();
        var dd = today.getDate();
        var mm = today.getMonth() + 1; //January is 0!
        var yyyy = today.getFullYear();
        var hour = today.getHours();
        var min = today.getMinutes();
        var sec = today.getSeconds();
        var c_date = yyyy + '-' + mm + '-' + dd + ' ' + hour + ':' + min + ':' + sec;
        $('#last_updated_' + i).val(c_date);
        if (isNaN(quantity) && quantity.length == 0)
        {
            $('#existing_qty_' + i).val(temp);
        }
//        console.log(total_qty);
//        exit;
        calculateSum();
    }

    function get_line2(obj) {
        var id = obj.id;
        var saper_id = id.split("_");
        var i = saper_id[1];
        var quantity = $('#' + id).val();
        var price = $('#quantity_' + i).val();
        var line_price = quantity * price;
        $('#line_' + i).val(line_price);
//        calculateSum();
    }
    function calculateSum() {
        var sum = 0;
// iterate through each td based on class and add the values
        $(".price").each(function () {
            var value = $(this).val();
            // add only if the value is number
            if (!isNaN(value) && value.length != 0) {
                sum += parseFloat(value);
            }
        });
        var d_value = $('#discount_value').val();
        var checked = $('input:radio[name=discount]:checked').val();
        if (checked == 1) {
            var d_sum = sum - d_value;
        }
        else {
            var d_sum = (d_value / 100) * sum;
            d_sum = sum - d_sum;
        }
        $('#after_discount').val(d_sum);
        $('#total').val(sum);

    }



    function autocom(obj) {
        var id = obj.id;
        var url = loc + "product_info";
        $('#' + id)
                .autocomplete({
                    source: url,
                    minLength: 0
                })
                .focus(function () {
                    $(this).autocomplete('search', $(this).val());
                });
    }
    function comput(obj) {
        var id = obj.id;
        var value = $('#' + id).val();
        var saper_id = id.split("_");
        var i = saper_id[1];
        var link = loc + 'all_produt_info';
        $.ajax({
            type: "POST",
            url: link, //Relative or absolute path to response.php file
            data: 'name=' + value,
            dataType: 'json',
            success: function (data) {
                $('#pcode_' + i).val(data.code);
                $('#pid_' + i).val(data.id);
                $('#pid1_' + i).val(data.id);
                $('#pcolor_' + i).val(data.keyword_value);
                $('#colorid_' + i).val(data.color);
                $('#sizeid_' + i).val(data.size);
                $('#psize_' + i).val(data.size_name);
                console.log(data);

            }

        });
    }


    $('#add_row').on('click', function () {
        var i = $('#array_size').val();
        $("#distribution_wozerd").each(function () {
            var tds = '<tr>';
            tds += '<td><input type="text" name="" class="form-control " id="pname_' + i + '" onclick="autocom(this)" onblur="comput(this)"/></td>';
            tds += '<td><input type="text" name="pcode" readonly class="form-control" value="" id="pcode_' + i + '"/></td>';
            tds += '<td><input type="text" name="" class="form-control" id="pcolor_' + i + '" readonly /></td>';
            tds += '<td><input type="text" name="" class="form-control" id="psize_' + i + '" readonly /></td>';
            tds += '<td><input type="text" name="existing_qty" readonly class="form-control price" value="0" id="existing_qty_' + i + '"/></td>';
            tds += '<td><input type="text" name="quantity" class="form-control" value="0" id="quantity_' + i + '" onblur="get_line(this)"/></td>';
            tds += '<td><input type="text" name="total_quantity" readonly class="form-control price" value="" id="total_quantity_' + i + '"/></td>';
            tds += '<td><input type="text" name="last_updated" readonly class="form-control" value="" id="last_updated_' + i + '"/></td>';
            tds += '<td><input type="text" name="remarks"  class="form-control" value="" id="remarks_' + i + '"/></td>';
            tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="pid_' + i + '" readonly /></td>';
            tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="pid1_' + i + '" readonly /></td>';


            tds += '</tr>';
            if ($('tbody', this).length > 0) {
                $('tbody', this).append(tds);
            } else {
                $(this).append(tds);
            }
            i++;
            $('#array_size').val(i);
        });

    });

    $('#bank_name').on('change', function () {
        var value = $(this).val();
        $(".check_del").each(function () {
            $(this).remove();
        });
        $.ajax({
            type: 'post',
            url: loc + 'branch',
            data: 'id=' + value,
            dataType: 'json',
            success: function (result) {
                var i = 0;
                var string = '';
                var j = 0;
                string += ' <option class="check_del" value="" >Please Select Branch</option>';
                for (i = 0; i < result.length; i++) {
                    string += '<option class="check_del" value="' + result[j].id + '">' + result[j].branch_name + '</option>';
                    j = j + 1;
                }
                $('#branch_name').append(string);
            }
        });
    });

    function autocomrc(obj) {
        var id = obj.id;
        var url = '<?php echo base_url('home/get_rc') ?>';
        $('#' + id)
                .autocomplete({
                    source: url,
                    minLength: 0
                })
                .focus(function () {
                    $(this).autocomplete('search', $(this).val());
                });
    }
    function autocomproduct(obj) {
        var id = obj.id;
        //        console.log(id);
        var url = '<?php echo base_url('home/get_product') ?>';
        $('#' + id)
                .autocomplete({
                    source: url,
                    minLength: 0,
                    select: function (event, ui)
                    {
                        var p_id = ui.item.id;
                        var name = ui.item.label;
                        $('#' + id).val(name);
                        $("#marialid_" + i).val(p_id);
                        return false;
                    }
                })
                .focus(function () {
                    $(this).autocomplete('search', $(this).val());
                });
    }
    function computrc(obj) {
        var id = obj.id;
        var value = $('#' + id).val();
        var saper_id = id.split("_");
        var i = saper_id[2];
        var url = '<?php echo base_url('home/all_rc') ?>';
        $.ajax({
            type: "POST",
            url: url, //Relative or absolute path to response.php file
            data: 'name=' + value,
            dataType: 'json',
            success: function (data) {
                console.log(data[2][0].keyword_value);

            }
        });
    }
    function computworkorder() {
        var value = $('#wo_number').val();
        var url = '<?php echo base_url('home/get_invoice') ?>';
        $.ajax({
            type: "POST",
            url: url, //Relative or absolute path to response.php file
            data: 'name=' + value,
            dataType: 'json',
            success: function (data) {
                console.log(data.inv_number);
                $('#inv_number').val(data.inv_number);

            }
        });
    }

    function computproduct(obj) {
        var id = obj.id;
        var value = $('#' + id).val();
        var saper_id = id.split("_");
        var i = saper_id[2];
        var url = '<?php echo base_url('home/all_pro') ?>';
        $.ajax({
            type: "POST",
            url: url, //Relative or absolute path to response.php file
            data: 'name=' + value,
            dataType: 'json',
            success: function (data) {
                console.log(data);
//                $('#product_number_' + i).val(data[0].product_code);
//                $('#product_name_' + i).val(data[1][0].product_name);
                $('#wo_quantity_' + i).val(data[2][0].wo_qty);
                $('#color_' + i).val(data[3][0].keyword_value);
                $('#size_' + i).val(data[4][0].keyword_value);
            }
        });
    }


</script>
