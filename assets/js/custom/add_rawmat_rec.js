/* define location */

var pathArray = location.pathname.split('/');
var loc = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';

/* datepicker in add Expected Delivery Date field */
$('#challan_date').datepicker({minDate: "+1D", maxDate: "+1M +10D"});


function get_date(obj){
    var id=obj.id;
    $('#'+id).datepicker({minDate: "+1D", maxDate: "+1M +10D"});
}


/* function for delete current row from table */

function deleteRow(btn) {
    if (confirm("You want to Delete this row")) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
//        calculateSum();
    }
}

$('#submit').on('click', function () {
    if(confirm('Confirm to save information')){
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
    }
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