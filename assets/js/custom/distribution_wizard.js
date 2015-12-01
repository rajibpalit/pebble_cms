var pathArray = location.pathname.split('/');
var root_controller = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';
    $(document).ready(function () {
        $("#add_row").on('click', function () {
            for (var auto_row = 5; auto_row > 0; auto_row--)
            {
                var i = $('#initilize_value1').val();
                $('#distribution_wozerd').each(function () {
                    var tds = '<tr>';
                    tds += '<td><input type="text" name="product_name" class="form-control" id="product_name_' + i + '" onclick="autocomproduct(this)" onblur ="computproduct(this)" /></td>'
                    tds += '<td class="hide_this"><input type="text" name="product_id" class="form-control" id="product_id_' + i + '" /></td>'
                    tds += '<td class="hide_this"><input type="text" name="wo_prod_id" class="form-control" id="wo_prod_id_' + i + '"/></td>'
                    tds += '<td><input type="text" name="product_number" readonly class="form-control" id="product_number_' + i + '"/></td>'
                    tds += '<td><input type="text" name="part_name" value=" " readonly class="form-control" id="part_name_' + i + '"/></td>'
                    tds += '<td class="hide_this"><input type="text" name="part_id" class="form-control" id="part_id_' + i + '"/></td>'
                    tds += '<td><input type="text" name="color" readonly class="form-control" id="color_' + i + '"/></td>'
                    tds += '<td><input type="text" name="size" readonly class="form-control" id="size_' + i + '"/></td>'
                    tds += '<td><input type="text" name="action_name" readonly class="form-control" id="action_name_' + i + '"/></td>'
                    tds += '<td class="hide_this"><input type="text" name="action_id" class="form-control" id="action_id_' + i + '"/></td>'
                    tds += '<td><input type="text" name="rc_name" class="form-control example" id="rc_name_' + i + '" onclick="autocomrc(this)" onblur="computrc(this)" /></td>'
                    tds += '<td class="hide_this"><input type="text" name="rc_id" class="form-control example" id="rc_id_' + i + '"/></td>'
                    tds += '<td><input type="text" name="wo_quantity" readonly class="form-control" value="0" id="wo_quantity_' + i + '"/></td>'
                    tds += '<td><input type="text" name="distributed_quantity" readonly  class="form-control" value="0" id="distributed_quantity_' + i + '" /></td>'
                    tds += '<td><input type="number" name="distribution_quantity" value="0" id="distribution_quantity_' + i + '" class="form-control" onblur="check_quantity(this)"/></td>'
                    tds += ' <td class=""><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>'
                    tds += '</tr>';
                    if ($('tbody', this).length > 0) {
                        $('tbody', this).append(tds);
                    } else {
                        $(this).append(tds);
                    }
                    i++;
                    $('#initilize_value1').val(i);
                });
            }
        });

    });
    function check_quantity(obj) {
        var id = obj.id;
        var saper_id = id.split("_");
        var i = saper_id[2];
        var ppp = i;
        var distribution_quantity = $('#distribution_quantity_' + i).val();
        var distributed_quantity = $('#distributed_quantity_' + i).val();
        var wo_quantity = $('#wo_quantity_' + i).val();
        var line_price = parseInt(distributed_quantity) + parseInt(distribution_quantity);
        if (wo_quantity < line_price) {
            alert("Distributed Quantity Is not more than WO Quantity");
            $('#distribution_quantity_' + ppp).val("");
        }
    }

    function autocomrc(obj) {
        var id = obj.id;
//        var url = '<?php echo base_url('home/get_rc') ?>';
           var url = root_controller +'get_rc';
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
        var inv_number = $("#inv_id").val();
        var id = obj.id;
        var saper_id = id.split("_");
        var i = saper_id[2];
//        var url = '<?php echo base_url('home/get_product_distribution?inv_number=') ?>' + inv_number;
          var url = root_controller +'get_product_distribution?inv_number=' + inv_number;
        $('#' + id)
                .autocomplete({
                    source: url,
                    minLength: 0,
                    select: function (event, ui)
                    {
                        var p_id = ui.item.id;
                        var name = ui.item.label;
                        $('#' + id).val(name);
                        $('#product_id_' + i).val(p_id);
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
//        var url = '<?php echo base_url('home/all_rc') ?>';
         var url = root_controller +'all_rc';
        
        $.ajax({
            type: "POST",
            url: url, //Relative or absolute path to response.php file
            data: 'name=' + value,
            dataType: 'json',
            success: function (data) {
                //                console.log(data[0].id);
                $('#rc_id_' + i).val(data[0].id);
            }
        });
    }
    $(document).ready(function () {
//    function computworkorder() {
        var value = $('#wo_number').val();
//        console.log(value);
//        var url = '<?php echo base_url('home/get_invoice') ?>';
            var url = root_controller +'get_invoice';
        $.ajax({
            type: "POST",
            url: url, //Relative or absolute path to response.php file
            data: 'name=' + value,
            dataType: 'json',
            success: function (data) {
//                console.log(data);
                var l = data.length;
                add_row(l, data);
            }
        });
//    }

        function add_row(l, data)
        {
//                console.log(data[0]['id']);

            for (var auto_row = l; auto_row > 0; auto_row--)
            {
                var i = $('#initilize_value1').val();
//               console.log(i);
                $('#distribution_wozerd').each(function () {
                    var tds = '<tr>';
                    tds += '<td><input type="text" name="product_name" class="form-control" value=' + data[i]['prod_name'] + ' id="product_name_' + i + '" /></td>'
                    tds += '<td class="hide_this"><input type="text" name="product_id"  value=' + data[i]['prod_id'] + ' class="form-control" id="product_id_' + i + '" /></td>'
                    tds += '<td class="hide_this"><input type="text" name="wo_prod_id" value=' + data[i]['id'] + ' class="form-control" id="wo_prod_id_' + i + '"/></td>'
                    tds += '<td><input type="text" name="product_number" readonly class="form-control" id="product_number_' + i + '"/></td>'
                    tds += '<td><input type="text" name="part_name" value=" " readonly class="form-control" id="part_name_' + i + '"/></td>'
                    tds += '<td class="hide_this"><input type="text" name="part_id" class="form-control" id="part_id_' + i + '"/></td>'
                    tds += '<td><input type="text" name="color" readonly class="form-control" id="color_' + i + '"/></td>'
                    tds += '<td><input type="text" name="size" readonly class="form-control" id="size_' + i + '"/></td>'
                    tds += '<td><input type="text" name="action_name" readonly class="form-control" id="action_name_' + i + '"/></td>'
                    tds += '<td class="hide_this"><input type="text" name="action_id" class="form-control" id="action_id_' + i + '"/></td>'
                    tds += '<td><input type="text" name="rc_name" class="form-control example" id="rc_name_' + i + '" onclick="autocomrc(this)" onblur="computrc(this)" /></td>'
                    tds += '<td class="hide_this"><input type="text" name="rc_id" class="form-control example" id="rc_id_' + i + '"/></td>'
                    tds += '<td><input type="text" name="wo_quantity" readonly class="form-control" value="0" id="wo_quantity_' + i + '"/></td>'
                    tds += '<td><input type="text" name="distributed_quantity" readonly  class="form-control" value="0" id="distributed_quantity_' + i + '" /></td>'
                    tds += '<td><input type="number" name="distribution_quantity" value="0" id="distribution_quantity_' + i + '" class="form-control" onblur="check_quantity(this)"/></td>'
                    tds += ' <td class=""><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>'
                    tds += '</tr>';
                    
                    if ($('tbody', this).length > 0) {
                        $('tbody', this).append(tds);
                    } else {
                        $(this).append(tds);
                    }
                    i++;
                    $('#initilize_value1').val(i);
                });
            }
        }
    });
    function computproduct(obj) {
        var id = obj.id;
//        var value = $('#' + id).val();

        var saper_id = id.split("_");
        var i = saper_id[2];
        var value = $('#product_id_' + i).val();
        var ppp = i;
        var k = 0;
        var check = 0;
        for (var k = i; k > 0; k--) {
            var kk = k - 1;
            var x = $('#product_id_' + i).val();
            var x1 = $('#product_id_' + kk).val();
            if (x == x1) {
                i = kk;
                var j = kk;
                var distribution_quantity = $('#distribution_quantity_' + kk).val();
                var distributed_quantity = $('#distributed_quantity_' + kk).val();
                var wo_quantity = $('#wo_quantity_' + kk).val();
                var line_price = parseInt(distributed_quantity) + parseInt(distribution_quantity);
                if (wo_quantity == line_price && line_price != 0) {
                    alert("this fully Distributer product");
                    $('#product_id_' + ppp).val("");
                    $('#product_name_' + ppp).val("");
                    check += 1;
                }
            }

        }
        if (check == 0)
        {
//            var url = '<?php echo base_url('home/all_pro') ?>';
    var url = root_controller +'all_pro';
            

            $.ajax({
                type: "POST",
                url: url, //Relative or absolute path to response.php file
                data: 'name=' + value,
                dataType: 'json',
                success: function (data) {
//                    console.log(data);
                    $('#product_id_' + ppp).val(data[0].prod_id);
                    $('#wo_quantity_' + ppp).val(data[2][0].wo_qty);
                    $('#color_' + ppp).val(data[3][0].keyword_value);
                    $('#size_' + ppp).val(data[4][0].keyword_value);
                    $('#product_number_' + ppp).val(data[5][0].code);
                    $('#action_name_' + ppp).val(data[1][0].action_name);
                    $('#wo_prod_id_' + ppp).val(data[2][0].id);
                    $('#action_id_' + ppp).val(data[1][0].action_id);
                    create_row(data[6], data[8], data[9], data[10], ppp);
                }
            });
            for (var b = ppp - 1; b >= 0; b--) {
                var x = $('#product_id_' + ppp).val();
                var x1 = $('#product_id_' + b).val();
                if (x == x1) {
                    var distribution_quantity = $('#distribution_quantity_' + b).val();
                    var distributed_quantity = $('#distributed_quantity_' + b).val();
                    var line_price = parseInt(distributed_quantity) + parseInt(distribution_quantity);
                    $('#distributed_quantity_' + ppp).val(line_price);
                    break;
                }
                else
                {
                    var j = kk;
                    var distribution_quantity = $('#distribution_quantity_' + j).val();
                    var distributed_quantity = $('#distributed_quantity_' + j).val();
                    var line_price = parseInt(distributed_quantity) + parseInt(distribution_quantity);
                    $('#distributed_quantity_' + ppp).val(0);
                }
            }
        }
    }
    function create_row($row_no, $row_no1, $row_no2, $row_no3, $value)
    {
//        console.log($row_no3);
        var i = parseInt($value) + 1;
//        console.log($row_no.length);
        for (var re = 0; re < $row_no.length - 1; )
        {
            var $newTr = $('#distribution_wozerd tr').last().clone();
            $newTr.find('[id]').each(function () {
                this.id = this.id.replace($value, parseInt($value) + 1);
                $('#part_name_' + $value).val($row_no[re]['product_name']);
                $('#part_id_' + $value).val($row_no[re]['part_name_id']);
                $('#color_' + $value).val($row_no1[re][0]['keyword_value']);
                $('#size_' + $value).val($row_no2[re][0]['keyword_value']);
                $('#action_name_' + $value).val($row_no3[re][0]['action_name']);
                $('#action_id_' + $value).val($row_no3[re][0]['action_id']);
            });
            $('#distribution_wozerd').append($newTr);
            $('#initilize_value1').val($value);
            $value++;
            i++;
            re++;
            if (re == $row_no.length - 1)
            {
                //                 this.id = this.id.replace($value, parseInt($value) + 1);
                $('#part_name_' + $value).val($row_no[re]['product_name']);
                $('#part_id_' + $value).val($row_no[re]['part_name_id']);
                $('#color_' + $value).val($row_no1[re][0]['keyword_value']);
                $('#size_' + $value).val($row_no2[re][0]['keyword_value']);
                $('#action_name_' + $value).val($row_no3[re][0]['action_name']);
                $('#action_id_' + $value).val($row_no3[re][0]['action_id']);
            }
        }
        var y = parseInt($value) + 1;
        $('#initilize_value1').val(y);
    }

    $('#submit').on('click', function (e) {
        var wizard = {};
        var wo = {};
        var i1 = 0;
//        alert("itisis");
//        console.log(i);
        wo[0] = $('#wo_id').val();
//                console.log(wo);
        $('#distribution_wozerd tr td input,#distribution_wozerd tr td select').each(function () {
            wizard[i1] = $(this).val();
            i1++;
        });
//        console.log(wizard);
        var d = {
            wizard: wizard,
            wo: wo
        };
//        console.log(d);
//        var url = '<?php echo base_url('home/save_wizard') ?>';
                   var url = root_controller +'save_wizard';
        $.ajax({
            async: false,
            type: 'post',
            url: url,
            data: {myarray: d},
            success: function (result) {
//                console.log(result);
                var url_location =root_controller +'distribution_list'; 
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
