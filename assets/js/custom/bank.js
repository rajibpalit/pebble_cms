var pathArray = location.pathname.split('/');
var loc = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';

function autocom() {
    var url = '<?php echo base_url("main/get_info") ?>';
    $('.example')
            .autocomplete({
                source: url,
                minLength: 0
            })
            .focus(function () {
                $(this).autocomplete('search', $(this).val());
            });
}

var url = '<?php echo base_url("main/get_info") ?>';



$('#add_row2').on('click', function () {
    $("#bank_table").each(function () {
        var tds = '<tr>';
        tds += '<td style="display:none"><input  type="text" value="0"></td>';
        tds += '<td><input type="text" name="branch_name" class="form-control example" onclick="autocom()"/></td>';
        tds += '<td><input type="text" name="address" class="form-control"/></td>';
        tds += '<td><input type="text" name="account_name" class="form-control"/></td>';
        tds += '<td><input type="text" name="account_number" class="form-control"/></td>';
        tds += '<td><input type="text" name="contact_number" class="form-control"/></td>';
        tds += '<td><input type="text" name="short_code" class="form-control"/></td>';
        tds += '<td><select name="" class="form-control"><option value="1">Active</option><option value="0">Inactive</option></select></td>';
        tds += '</tr>';
        if ($('tbody', this).length > 0) {
            $('tbody', this).append(tds);
        } else {
            $(this).append(tds);
        }
    });
});
/* funciton for add data into database */
$('#submit').on('click', function () {

    var rowsArray = {};
    var i = 0;
    $('#bank_table tr td input,#bank_table tr td select').each(function () {
        rowsArray[i] = $(this).val();
        i++;
    });
    var address = $('#bank_address').val();
    var bank_name = $('#bank_name').val();
    if (!bank_name)
    {
        alert('Please Enter Bank Name');
        return false;
    }
    var index = Object.keys(rowsArray).length;
    rowsArray[index] = bank_name;
    rowsArray[index + 1] = address;
    var data_save = '<?php echo base_url("main/save_info") ?>';
    $.ajax({
        type: 'post',
        url: data_save,
        data: {myarray: rowsArray},
        success: function (result) {
            var root = location.protocol + '//' + location.host;
            window.location.href = root + "/main/bank_list";
        }
    });
});

/*function for update data */
$('#update').on('click', function () {
    var rowsArray = {};
    var i = 0;
    $('#bank_table tr td input,#bank_table tr td select').each(function () {
        rowsArray[i] = $(this).val();
        i++;
    });
    var address = $('#bank_address').val();
    var bank_name = $('#bank_name').val();
    var bank_id = $('#bank_id').val();
    var index = Object.keys(rowsArray).length;
    rowsArray[index] = bank_name;
    rowsArray[index + 1] = address;
    rowsArray[index + 2] = bank_id;

    var data_save = '<?php echo base_url("main/update_bank_info") ?>';
    $.ajax({
        type: 'post',
        url: data_save,
        data: {myarray: rowsArray},
        success: function (result) {
            var root = location.protocol + '//' + location.host;
            window.location.href = root + "/main/bank_list";
        }
    });
});

function check_branch(value) {
    $('#account_table tbody').empty();
    var data_save = loc + 'get_branch';
    $.ajax({
        type: 'post',
        url: data_save,
        dataType: "json",
        data: 'id=' + value,
        success: function (result) {
            var str = '';
            str += '<tr>';
            str += '<td class="hide_this"><input type="text" value="' + result[0]['id'] + '" name="account_name" class="form-control"/></td>';
            str += '<td><input type="text" name="account_name" class="form-control"/></td>';
            str += '<td><input type="text" name="account_number" class="form-control"/></td>';
            str += '<td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
            str += '</tr>';
            $('#account_table').append(str);
        }
    });
    $('#account_' + value).attr('disabled', 'disabled');
    $('#rcModal').modal('show');

}
function add_branch() {

    $('#branch_name').val('');
    $('#branch_address').val('');
    $('#branch_contact').val('');
    $('#branch_short_code').val('');
    $('#branch_status option').prop('selected', function () {
        return this.defaultSelected;
    });
    $('#bModal').modal('show');
}

$('#add_account_row').on('click', function () {
//    colsole.log('test');
    $("#account_table").each(function () {
        var tds = '<tr>';
        
        tds += '<td class="hide_this"><input type="text" value="" name="account_name" class="form-control"/></td>';
        tds += '<td><input type="text" name="account_name" class="form-control"/></td>';
        tds += '<td><input type="text" name="account_number" class="form-control"/></td>';
        tds += '<td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
        tds += '</tr>';
        if ($('tbody', this).length > 0) {
            $('tbody', this).append(tds);
        } else {
            $(this).append(tds);
        }
    });
});

/* delete row */
function deleteRow(btn) {
    if (confirm("You want to Delete this row")) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);

    }
}

// add account info into account table

$('#add_account').on('click', function () {
    var rowsArray = {};
    var i = 0;
    $('#account_table tr td input').each(function () {
        rowsArray[i] = $(this).val();
        i++;
    });

    var data_save = loc + 'save_account';

    $.ajax({
        type: 'post',
        url: data_save,
        dataType: "json",
        data: {rowsArray: rowsArray},
        success: function (result) {
            $('#rcModal').modal('hide');

        }
    });
    $('#rcModal').modal('hide');
});

$('#add_row').on('click', function () {
    $('#rModal').modal('show');
});

$('#add_branch').on('click', function () {
    var rowsArray = {};
    var i = 0;
    $('#branch_table tr td input,#branch_table tr td select').each(function () {
        rowsArray[i] = $(this).val();
        i++;
    });
    var data_save = loc + 'save_branch';
    $.ajax({
        type: 'post',
        url: data_save,
        dataType: "json",
        data: {rowsArray: rowsArray},
        success: function (result) {
            var string = '<tbody>';
            string += '<td><input readonly type="text" class="form-control" id="" name="branch_name" value="' + result[0]['branch_name'] + '" class="form-control example" /></td>';
            string += '<td><input readonly type="text" class="form-control" name="address" value="' + result[0]['address'] + '" class="form-control"/></td>',
                    string += '<td><input readonly class="form-control" type="text" name="contact_number" value="' + result[0]['contact_number'] + '" class="form-control"/></td>';
            string += '<td><input readonly type="text" class="form-control" name="short_code" value="' + result[0]['short_code'] + '" class="form-control"/></td>';
            string += '<td><select readonly name="" class="form-control">';
            if (result[0]['status'] == '1') {
                string += '<option selected value="1">Active</option>';
            }
            else {
                string += '<option  selected  value="0">Inactive</option>';
            }
            string += '</select></td>';
            string += '<td><input type="button" onclick="check_branch(' + result[0]['id'] + ')" id="account_' + result[0]['id'] + '"  class="btn btn-primary" value="Add Account"></td></tbody>';
            $('#bModal').modal('hide');
            $('#bank_table').append(string);

        }
    });

});