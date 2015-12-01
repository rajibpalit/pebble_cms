var pathArray = location.pathname.split('/');
var loc = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';

function calculate_remain(obj) {
    var remain;
    var id = obj.id;
    var saper_id = id.split("_");
    var i = saper_id[1];
    var packing_value = $('#' + id).val();
    if (packing_value != '') {
        var order_quty = $('#orquat_' + i).val();
        var remain_quty = $('#remaining_'+ i).val();        
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

    $('#packing_info').submit();
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