/* define location */

var pathArray = location.pathname.split('/');
var loc = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';

/* datepicker in add Expected Delivery Date field */
$('#delivery_date').datepicker({minDate: "+1D", maxDate: "+1M +10D"});

/* on blur supplier auto field address email and contact number */
$('#supplier').on('change', function () {
    var supplier_id = $(this).val();
    $.ajax({
        type: 'post',
        url: loc + 'get_supplier',
        data: 'id=' + supplier_id,
        dataType: 'json',
        success: function (result) {
            $('#address').val(result.address);
            $('#email').val(result.email);
            $('#contact_no').val(result.phone_no);
            var rmpo = result.last_rmpo;
            var last_value = parseInt(rmpo) + 1;
            var len = last_value.toString().length;            
            var j = '';
            var i;
            for (i = len; i < 7; i++) {
                j += '0';
            }            
            var final_work_order = 'RPO' + j + last_value;
            $('#invoice_number').val(final_work_order);            
        }
    });
});

/* autocom functon for product name */
function autocom(obj) {
    var id = obj.id;
    var saper_id = id.split("_");/* sprit id get integer value */
    var i = saper_id[1];
    var supplier=$('#supplier option:selected').val();
    var url = loc + "product_info?id="+supplier;
    
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
            });

}

/* fill require fill based on product name*/
function compute_field(obj) {
    var id = obj.id;
    var saper_id = id.split("_");
    var i = saper_id[1];
    var value = $('#marialid_' + i).val();
    var link = loc + 'all_produt_info';
    $.ajax({
        type: "POST",
        url: link, //Relative or absolute path to response.php file
        data: 'name=' + value,
        dataType: 'json',
        success: function (data) {

            $('#pid_' + i).val(data.id);
            $('#color_' + i).val(data.keyword_value);
            $('#stockq_' + i).val(data.stock);
            $('#colorid_' + i).val(data.color);
            $('#sizeid_' + i).val(data.size);
            $('#size_' + i).val(data.size_name);
            $('#muname_' + i).val(data.mu_name);

        }

    });
}
/* calculate the value of matarial */
function get_line(obj) {
    var id = obj.id;
    var quen = $('#' + id).val();
    var saper_id = id.split("_");
    var unit_price = saper_id[1];
    var check = saper_id[0];
    if (check == 'orderq') {
        var unit = $('#unit_' + unit_price).val();
    }
    else {
        var unit = $('#orderq_' + unit_price).val();
    }
    put_value(quen, unit, unit_price);
}

/* function for put total line price*/
function put_value(quan, unit, i) {
    var total = quan * unit;
    $('#line_' + i).val(total);
}

/* cn click add row button add row at the end of the table */
$('#add_row').on('click', function () {
    var i = $('#initilize_value').val();
    $("#bank_table").each(function () {
        var tds = '<tr>';
        tds += '<td><input type="text" name="" class="form-control " id="name_' + i + '" onclick="autocom(this)" onblur="compute_field(this)"/></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="marialid_' + i + '" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="color_' + i + '" readonly /></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="colorid_' + i + '" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="size_' + i + '" readonly /></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="sizeid_' + i + '" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="muname_' + i + '" /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="origin_' + i + '" /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="stockq_' + i + '" /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="orderq_' + i + '"  onkeyup="get_line(this)"/></td>';
        tds += '<td><input type="text" name="" class="form-control" id="unit_' + i + '" onkeyup="get_line(this)"/></td>';
        tds += '<td><input type="text" name="" class="form-control price" id="line_' + i + '" readonly/></td>';
        tds += '<td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';

        tds += '</tr>';
        if ($('tbody', this).length > 0) {
            $('tbody', this).append(tds);
        } else {
            $(this).append(tds);
        }
        i++;
        $('#initilize_value').val(i);
    });

});

/* function for delete current row from table */

function deleteRow(btn) {
    if (confirm("You want to Delete this row")) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
//        calculateSum();
    }
}

$('#submit').on('click', function () {
    $('#invoice_info').submit();
    var rowsArray = {};
    var i = 0;
    $('#bank_table tr td input,#bank_table tr td select').each(function () {
        rowsArray[i] = $(this).val();
        i++;
    });

    var data_save = loc + 'packing_product';
    $.ajax({
        type: 'post',
        url: data_save,
        data: {rowsArray: rowsArray},
        success: function (result) {

            console.log('ok');
        }
    });

});
$('#update').on('click', function () {

    $('#invoice_info').submit();
    var rowsArray = {};
    var i = 0;
    $('#bank_table tr td input,#bank_table tr td select').each(function () {
        rowsArray[i] = $(this).val();
        i++;
    });

    var data_save = loc + 'packing_product_update';
    $.ajax({
        type: 'post',
        url: data_save,
        data: {rowsArray: rowsArray},
        success: function (result) {

            console.log('ok');
        }
    });

});