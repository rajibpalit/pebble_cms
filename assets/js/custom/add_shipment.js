var pathArray = location.pathname.split('/');
var loc = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';

$('#exportdate').datepicker();


function get_date(obj) {
    var id = obj.id;
    $('#' + id).datepicker();
}
$('#inv_number').on('blur', function () {
    var inv_id = $("#invoice_id").val();
    create_row(inv_id);
    var link = loc + 'inv_detail';
    $.ajax({
        type: "POST",
        url: link, //Relative or absolute path to response.php file
        data: 'id=' + inv_id,
        dataType: 'json',
        success: function (data) {
            $('#inv_date').val(data.invoice_date);
            $('#client_name').val(data.contact_name);
        }

    });
});
function create_row(id) {
    console.log(id);
}

//$('#add_row').on('click', function () {
//    var i = $('#initilize_value').val();
//    $("#bank_table").each(function () {
//        var tds = '<tr>';
//          tds += '<td><input type="text" name="" class="form-control "  id="hscode_'+i+'" /></td>';
//                    tds += '<td><input type="text" name="" class="form-control"id="boxnum_'+i+'"  /></td>';
//                    tds += '<td><input type="text" name="" class="form-control"  id="agent_'+i+'"  /></td>';
//                    tds += '<td><input type="text" name="" class="form-control"  id="shipping_'+i+'"  /></td>';
//                    tds += '<td><input type="text" name="" class="form-control"  id="track_'+i+'"  /></td>';
//                    tds += '<td><input type="text" name="" class="form-control" id="length_'+i+'" /></td>';
//                    tds += '<td><input type="text" name="" class="form-control"  id="width_'+i+'"  /></td>';
//                    tds += '<td><input type="text" name="" class="form-control "  id="height_'+i+'"/></td>';
//                    tds += '<td><input type="text" name="" class="form-control " id="unit_'+i+'" /></td>';
//                    tds += '<td><input type="text" name="" class="form-control " id="gross_'+i+'" /></td>';
//                    tds += '<td><input type="text" name="" class="form-control "  id="net_'+i+'" /></td>';
//                    tds += '<td><input type="text" name="" class="form-control "  id="unit_'+i+'" /></td>';
//                    tds += '<td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
//
//        tds += '</tr>';
//        if ($('tbody', this).length > 0) {
//            $('tbody', this).append(tds);
//        } else {
//            $(this).append(tds);
//        }
//        i++;
//        $('#initilize_value').val(i);
//    });
//
//});


function calculate_remain(obj) {
    var remain;
    var id = obj.id;
    var saper_id = id.split("_");
    var i = saper_id[1];
    var packing_value = $('#' + id).val();
    if (packing_value != '') {
        var order_quty = $('#orquat_' + i).val();
        var remain_quty = $('#remaining_' + i).val();
        console.log(remain_quty);
        if (parseInt(remain_quty) == parseInt(order_quty)) {

            remain = parseInt(order_quty) - parseInt(packing_value);
        }
        else {
            remain = parseInt(order_quty) - (parseInt(remain_quty) + parseInt(packing_value));
        }

        if (parseInt(remain) < 0) {
            alert('Please enter Packing Quantity less than ' + remain_quty);
        }
        else {
            $('#remain_' + i).val(remain);
        }
    }
    else {
        return false;
    }
}
$('#submit').on('click', function () {
    $('#packing_info').submit();
    var rowsArray = {};
    var i = 0;
    $('#bank_table tr td input,#bank_table tr td select').each(function () {
        rowsArray[i] = $(this).val();
        i++;
    });

    var data_save = loc + 'box_info';
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

//    $('#packing_info').submit();
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

/* delete row */
function deleteRow(btn) {
    if (confirm("You want to Delete this row")) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
        calculateSum();
    }
}

function get_gross(){
    var sum=0;
    $(".gross").each(function () {
        var value = $(this).val();
        // add only if the value is number
        if (!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);
        }

    });
    $('#total_gross').val(sum);
}

function get_net(){
    var sum=0;
    $(".net").each(function () {
        var value = $(this).val();
        // add only if the value is number
        if (!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);
        }

    });
    $('#total_net').val(sum);
}
