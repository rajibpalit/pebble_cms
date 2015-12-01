var pathArray = location.pathname.split('/');
var loc = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';


$(document).ready(function(){
    var selected = $("input[type='radio'][name='discount']:checked");
if (selected.length > 0) {
  var  selectedVal = selected.val();
 if(selectedVal==2){
     $('#discount_value_group').hide();
     $('#after_discount_group').hide();
 }
}
});
$("input[name='discount']").on('click',function(){
    var value=$(this).val();
    if(value==2){
        $('#discount_value_group').hide();
     $('#after_discount_group').hide();
    }
    else{
          $('#discount_value_group').show();
     $('#after_discount_group').show();
    }
});

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

$('#add_row').on('click', function () {
    var i = $('#initilize_value').val();
    var j;
    for(j=0; j<=4; j++)
    {
    $("#bank_table").each(function () {
        var tds = '<tr>';
        tds += '<td><input type="text" name="" class="form-control " id="name_' + i + '" onclick="autocom(this)" onblur="comput(this)"/></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="pid_' + i + '" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="color_' + i + '" readonly /></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="colorid_' + i + '" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="size_' + i + '" readonly /></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="sizeid_' + i + '" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="quantity_' + i + '" onkeyup="get_line(this)"/></td>';
        tds += '<td><input type="text" name="" class="form-control" id="unit_' + i + '" onkeyup="get_line2(this)"/></td>';
        tds += '<td><input type="text" name="" class="form-control price" id="line_' + i + '" readonly/></td>';
        tds += ' <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';

        tds += '</tr>';
        if ($('tbody', this).length > 0) {
            $('tbody', this).append(tds);
        } else {
            $(this).append(tds);
        }
        i++;
        $('#initilize_value').val(i);
    });
}
});

/* add row when update row */
$('#update_row').on('click', function () {
    var invoice = $('#inv_number').val();
    var i = $('#initilize_value').val();
    $("#bank_table").each(function () {
        var tds = '<tr>';
        tds += '<td  class="hide_this"><input class="form-control " type="text" name="" value="' + invoice + '" id="invoice_' + i + '"></td>';
        tds += '<td  class="hide_this"><input class="form-control " type="text" name="" id="invproduct_' + i + '"></td>';
        tds += '<td><input type="text" name="" class="form-control " id="name_' + i + '" onclick="autocom(this)" onblur="comput(this)"/></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="pid_' + i + '" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="color_' + i + '" readonly /></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="colorid_' + i + '" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="size_' + i + '" readonly /></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="sizeid_' + i + '" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="quantity_' + i + '" onkeyup="get_line(this)"/></td>';
        tds += '<td><input type="text" name="" class="form-control" id="unit_' + i + '" onkeyup="get_line2(this)"/></td>';
        tds += '<td><input type="text" name="" class="form-control price" id="line_' + i + '" readonly/></td>';
        tds += ' <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';

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
            $('#pid_' + i).val(data.id);
            $('#color_' + i).val(data.keyword_value);
            $('#colorid_' + i).val(data.color);
            $('#sizeid_' + i).val(data.size);
            $('#size_' + i).val(data.size_name);
            $('#unit_' + i).val(data.default_rate);

        }

    });
}

function get_line(obj) {
    var id = obj.id;
    var saper_id = id.split("_");
    var i = saper_id[1];
    var quantity = $('#' + id).val();
    var price = $('#unit_' + i).val();
    var line_price = quantity * price;
    $('#line_' + i).val(line_price);
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
    calculateSum();
}

/* auto complet of client */
var url = 'get_client';
$('#client_name').autocomplete({
    source: loc + url,
    minLength: 2
});

$('#client_name').on('blur', function () {
    var link = loc + 'get_client_info';
    var value = $(this).val();
    $.ajax({
        type: "POST",
        url: link, //Relative or absolute path to response.php file
        data: 'name=' + value,
        dataType: 'json',
        success: function (data) {
            $('#address').text(data.shipping_address);
            $('#currency_id').val(data.currency);
            $('#currency').val(data.currency_name);
            $('#client_id').val(data.client_id);
            var last_invoice;
            if (data.old_invoice == 0) {
                last_invoice = parseInt(data.last_invoice) + 1;
                var invoice_length = last_invoice.toString().length;
                var prefix_length = (data.invoice_prefix).length;
                var total_digit = invoice_length + prefix_length;
                var j = '';
                for (var i = total_digit; i < 10; i++) {

                    j += '0';
                }
            }
            else {
                var invoice = data.old_invoice;
                var after_repl = invoice.replace(data.invoice_prefix,'');                
                var remvoe_zeros = after_repl.replace(/^0+/, '');
                last_invoice = parseInt(data.last_invoice) + 1;                
                var invoice_length = last_invoice.toString().length;
                var prefix_length = (data.invoice_prefix).length;
                var total_digit = invoice_length + prefix_length;
                var j = '';
                for (var i = total_digit; i < 10; i++) {

                    j += '0';
                }
            }
            var final_invoice = data.invoice_prefix + j + last_invoice;
            $('#last_invoice').val(last_invoice);
            $('#invoice_number').val(final_invoice);
        }

    });

});

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

/* delete row */
function deleteRow(btn) {
    if (confirm("You want to Delete this row")) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
        calculateSum();
    }
}
//$('#submit').on('click',function(){
//    $('#invoice_form').submit();
//});
/* get all data and send to controller */
$('#submit').on('click', function () {
   /* $(function () {
        $('.error').hide();        
        $('.error').hide();
        var name = $("#client_name").val();
        var po_number = $("#po_number").val();
        var discount_value = $("#discount_value").val();
        var radio;
        if (document.getElementById('inlineRadio1').checked) {
            radio = document.getElementById('inlineRadio1').value;
        }
        if (document.getElementById('inlineRadio2').checked) {
            radio = document.getElementById('inlineRadio2').value;
        }
        if (!name) {
            $("#client_name_error").show();
            $("#client_name_error").focus();
//        return false;
        }
        if (!po_number) {
            $("#po_number_error").show();
            $("#po_number_error").focus();
//        return false;
        }
        if (!radio) {
            $("#radio_value_error").show();
            $("#radio_value_error").focus();
//        return false;
        }
        if (!discount_value) {
            $("#discount_value_error").show();
            $("#discount_value_error").focus();
            
        }
    });*/
   $('#invoice_form').submit();   
    var rowsArray = {};
    var i = 0;
    $('#bank_table tr td input,#bank_table tr td select').each(function () {
        rowsArray[i] = $(this).val();
        i++;
    });

    var data_save = loc + 'save_info';
    
    $.ajax({
        type: 'post',
        url: data_save,
        data: {rowsArray: rowsArray},
        success: function (result) {          
                
             window.location.href = loc + "invoice";
        }
    });
});


$('#update').on('click', function () {
    $('#invoice_form').submit();
    var rowsArray = {};
    var i = 0;
    $('#bank_table tr td input,#bank_table tr td select').each(function () {
        rowsArray[i] = $(this).val();
        i++;
    });

    var data_save = loc + 'update_info';
    $.ajax({
        type: 'post',
        url: data_save,
        data: {rowsArray: rowsArray},
        success: function (result) {

           window.location.href = loc + "invoice";

        }
    });
});
/* find branch name based on bank name */
/* function start here */
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
/* function end here */

/* find account name based on bank name */
/* function start here */
$('#branch_name').on('change', function () {
    var value = $(this).val();
    $(".account_del").each(function () {
        $(this).remove();
    });

    $.ajax({
        type: 'post',
        url: loc + 'account',
        data: 'id=' + value,
        dataType: 'json',
        success: function (result) {
            var i = 0;
            var string = '';
            var j = 0;
            string += ' <option class="account_del" value="" >Please Select Account</option>';
            for (i = 0; i < result.length; i++) {
                string += '<option class="account_del" value="' + result[j].account_id + '">' + result[j].account_no + '</option>';
                j = j + 1;
            }
            $('#account_numnber').append(string);
        }
    });
});

$('#add_account_number').on('click', function () {
    $('#b_number').val('');
//    var value = $('#account_numnber').text();
    var value = $("#account_numnber option:selected").text();
//    console.log(value);
    $('#b_number').val(value);
    $('#account_value').text(value);
    $('#myModal').modal('hide');
});

/* remove account and branch on click of search value */
$('#find_account').on('click', function () {
    $(".account_del").each(function () {
        $(this).remove();
    });

    $(".check_del").each(function () {
        $(this).remove();
    });
});

$('.inline_checkbox').on('change', function () {
    if (this.checked) {
        var value = $(this).val();
        calculateSum();
    }
    $('#discount_value').on('keyup', function () {
        calculateSum();
    });
});

/* on click change from action */
$('#work_order').on('click', function () {
    var data_save = window.location.origin + '/' + pathArray[1] + '/workorder/workorder_product';

    var rowsArray = {};
    var i = 0;
    $('#bank_table tr td input,#bank_table tr td select').each(function () {
        rowsArray[i] = $(this).val();
        i++;
    });

    $.ajax({
        type: 'post',
        url: data_save,
        data: {rowsArray: rowsArray},
        success: function (result) {

            console.log('ok');

        }
    });

});

