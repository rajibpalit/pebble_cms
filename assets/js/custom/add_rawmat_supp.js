/* define location */

var pathArray = location.pathname.split('/');
var loc = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';

/* autocom functon for product name */
function autocom(obj) {
    var id = obj.id;
    var saper_id = id.split("_");/* sprit id get integer value */
    var i = saper_id[1];
    var url = loc + "product_info";
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


/* get all data and send to controller */
$('#submit').on('click', function () {
    $('#invoice_info').submit();
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
            console.log('ok');
        }
    });
});


/* get all data and send to controller */
$('#update').on('click', function () {
    $('#invoice_info').submit();
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
            console.log('ok');
        }
    });
});

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
        data: 'id=' + value,
        dataType: 'json',
        success: function (data) {
            $('#matname_' + i).val(data.material_name);
            $('#muname_' + i).val(data.mu_name);
            $('#muid_' + i).val(data.m_unit_id);            
            $('#color_' + i).val(data.keyword_value);
            $('#colorid_' + i).val(data.color_id);
            $('#sizeid_' + i).val(data.size_id);
            $('#size_' + i).val(data.size_name);
        }

    });
}
/* cn click add row button add row at the end of the table */
$('#add_row').on('click', function () {
    var i = $('#initilize_value').val();
    $("#bank_table").each(function () {
        var tds = '<tr>';       
        tds += '<td><input type="text" name="" class="form-control " id="name_'+i+'" onclick="autocom(this)" onblur="compute_field(this)"/></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="marialid_'+i+'" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="matname_'+i+'" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="price_'+i+'" /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="leadtime_'+i+'" /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="muname_'+i+'" readonly/></td>';
        tds += '<td class="hide_this"> <input type="text" name="" class="form-control" id="muid'+i+'" readonly/></td>';
        tds += '<td><input type="text" name="" class="form-control" id="color_'+i+'" readonly /></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="colorid_'+i+'" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="size_'+i+'" readonly /></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="sizeid_'+i+'" readonly /></td>';
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

/* cn click add row button add row at the end of the table */
$('#update_row').on('click', function () {
    var i = $('#initilize_value').val();
    $("#bank_table").each(function () {
        var tds = '<tr>';        
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" ?>" id="matid_'+i+'"/></td> ';
        tds += '<td><input type="text" name="" class="form-control " id="name_'+i+'" onclick="autocom(this)" onblur="compute_field(this)"/></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="marialid_'+i+'" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="matname_'+i+'" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="price_'+i+'" /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="leadtime_'+i+'" /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="muname_'+i+'" readonly/></td>';
        tds += '<td class="hide_this"> <input type="text" name="" class="form-control" id="muid'+i+'" readonly/></td>';
        tds += '<td><input type="text" name="" class="form-control" id="color_'+i+'" readonly /></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="colorid_'+i+'" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control" id="size_'+i+'" readonly /></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="sizeid_'+i+'" readonly /></td>';
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