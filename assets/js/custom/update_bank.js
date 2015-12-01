var pathArray = location.pathname.split('/');
var loc = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';
function get_account(id) {

    $('#account_table tbody').empty();
    var data_save = loc + 'get_account';
    $.ajax({
        type: 'post',
        url: data_save,
        dataType: "json",
        data: 'id=' + id,
        success: function (result) {
            if(result.length==0){
                $('#default_account').val(id);
            }
          else{
            var str = '';
            var i = 0;
            var j = 0;
            for (i = 0; i < result.length; i++) {
                str += '<tr>';
                str += '<td class="hide_this"><input type="text" name="branch_id" value="' + id + '" class="form-control"/></td>';
                str += '<td class="hide_this"><input type="text" name="account_id" value="' + result[j].account_id + '" class="form-control"/></td>';
                str += '<td><input type="text" name="account_name" value="' + result[j].account_name + '" class="form-control"/></td>';
                str += '<td><input type="text" name="account_number" value="' + result[j].account_no + '" class="form-control"/></td>';
                str += '<td><select  name="" class="form-control">';
                if (result[0]['status'] == '1') {
                    str += '<option selected value="1">Active</option>';
                    str += '<option  value="0">Inactive</option>';
                }
                else {
                    str += '<option value="1">Active</option>';
                    str += '<option selected  value="0">Inactive</option>';
                }
                str += '</select></td>';
//                str += '<td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
                str += '</tr>';
                j++;
            }

            $('#account_table').append(str);
          }
        
    }
    });

    $('#rcModal').modal('show');
}

$('#add_account_row').on('click', function () {
var branch_id=$('#default_account').val();
var set_id;
if(branch_id!=''){
    set_id=branch_id;
}
else{
     set_id='';
}
    $("#account_table").each(function () {
        var tds = '<tr>';
        tds += '<td class="hide_this"><input type="text" value="'+set_id+'" name="branch_id" class="form-control"/></td>';
        tds += '<td class="hide_this"><input type="text" name="account_name" class="form-control"/></td>';
        tds += '<td><input type="text" name="account_name" class="form-control"/></td>';
        tds += '<td><input type="text" name="account_number" class="form-control"/></td>';
        tds += '<td><select name="status"  class="form-control"><option value="1">Active</option><option value="0">Inactive</option></select></td>';
//        tds += '<td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
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
    $('#account_table tr td input,#account_table tr td select option:selected').each(function () {
        rowsArray[i] = $(this).val();
        i++;
    });   
    var data_save = loc + 'update_account';

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


$('#submit').on('click', function () {

    var skill = {};
    var i = 0;
    $('#bank_table tr td input,#bank_table tr td select').each(function () {
        skill[i] = $(this).val();
        i++;
    });


    var rowsArray = {skill: skill};

    var data_save = loc + 'branch_info_update';
    $.ajax({
        type: 'post',
        url: data_save,
        asyn: false,
        data: {rowsArray: rowsArray},
        success: function (result) {

            window.location.href = loc;

        }
    });

});


/*
$('#add_account').on('click', function () {

    var account_info = {};
    var i = 0;
    $('#account_table tr td input,#account_table tr td select').each(function () {
        account_info[i] = $(this).val();
        i++;
    });


    var rowsArray = {account_info: account_info};
    console.log(rowsArray);
//    exit;
    var data_save = loc + 'account_info_update';
    $.ajax({
        type: 'post',
        url: data_save,
        asyn: false,
        data: {rowsArray: rowsArray},
        success: function (result) {

            window.location.href = loc;

        }
    });

});*/