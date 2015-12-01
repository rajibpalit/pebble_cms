/* define location */

var pathArray = location.pathname.split('/');
var loc = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';

function autocom(obj) {
    var id = obj.id;
    var saper_id = id.split("_");/* sprit id get integer value */
    var i = saper_id[1];
    var url = loc + "skill_info";

    $('#' + id)
            .autocomplete({
                source: url,
                minLength: 0,
                select: function (event, ui)
                {
                    var p_id = ui.item.id;
                    var name = ui.item.label;
                    $('#' + id).val(name);
                    $("#skillid_" + i).val(p_id);
                    return false;
                }
            })
            .focus(function () {
                    $(this).autocomplete('search', $(this).val());
                });

}
function product_autocom(obj) {
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
                    $("#productid_" + i).val(p_id);
                    console.log(p_id);
//                    exit;
                    return false;
                }
            })
            .focus(function () {
                    $(this).autocomplete('search', $(this).val());
                });

}

function product_info(obj) {
    var id = obj.id;
    var saper_id = id.split("_");
    var i = saper_id[1];
    var value = $('#productid_' + i).val();

    var link = loc + 'all_produt_info';
    $.ajax({
        type: "POST",
        url: link, //Relative or absolute path to response.php file
        asyn: false,
        data: 'id=' + value,
        dataType: 'json',
        success: function (data) {
            $('#pcode_' + i).val(data.code);

        }

    });
}

$('#add_skill').on('click', function () {
    var i = $('#initilize_bank').val();
    $("#bank_table").each(function () {
        var tds = '<tr>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control " id="skillid_' + i + '" /></td>';
        tds += '<td><input type="text" name="" class="form-control " id="name_' + i + '" onclick="autocom(this)" /></td>';
        tds += '<td><input type="text" name="" class="form-control " id="supervisor_' + i + '"/></td>';
        tds += '<td><input type="text" name="" class="form-control artisan_capacity" id="artisan_' + i + '"  onkeyup="artisan_capacity(this)"/></td>';
        tds += '<td><input type="text" name="" class="form-control hourly_capacity" id="hour_' + i + '"  onkeyup="hourly_capacity(this)"/></td>';
        tds += '<td><input type="text" name="" class="form-control hourly_rate" id="hourly_' + i + '" onkeyup="hourly_rate(this)"/></td>';
        tds += '<td><input type="text" name="" class="form-control" id="basic_' + i + '" /></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control price" id="active_' + i + '" /></td>';
        tds += '<td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
        tds += '</tr>';
        if ($('tbody', this).length > 0) {
            $('tbody', this).append(tds);
        } else {
            $(this).append(tds);
        }
        i++;
        $('#initilize_bank').val(i);
    });

});
$('#update_skill_row').on('click', function () {
    var i = $('#skill_no').val();
    var ruralcenter = $('#skill_ruralcenter_id_0').val();
    $("#bank_table").each(function () {
        var tds = '<tr>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control " id="skillid_' + i + '" /></td>';
        tds += '<td><input type="text" name="" class="form-control " id="name_' + i + '" onclick="autocom(this)" /></td>';
        tds += '<td><input type="text" name="" class="form-control " id="supervisor_' + i + '"/></td>';
        tds += '<td><input type="text" name="" class="form-control artisan_capacity" id="artisan_' + i + '"  onkeyup="artisan_capacity(this)"/></td>';
        tds += '<td><input type="text" name="" class="form-control hourly_capacity" id="hour_' + i + '"  onkeyup="hourly_capacity(this)"/></td>';
        tds += '<td><input type="text" name="" class="form-control hourly_rate" id="hourly_' + i + '" onkeyup="hourly_rate(this)"/></td>';
        tds += '<td><input type="text" name="" class="form-control" id="basic_' + i + '" /></td>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control price" id="active_' + i + '" /></td>';
        tds += '<td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
        tds += '<td class="hide_this"><input type="text" name="" value="" class="form-control " id="id_' + i + '" /></td>';
        tds += '<td class="hide_this"><input type="text" name="" value="' + ruralcenter + '" class="form-control " id="skill_ruralcenter_id_' + i + '" /></td>';
        tds += '</tr>';
        if ($('tbody', this).length > 0) {
            $('tbody', this).append(tds);
        } else {
            $(this).append(tds);
        }
        i++;
        $('#skill_no').val(i);
    });

});
$('#add_product').on('click', function () {
    var i = $('#initilize_product').val();
    $("#product_table").each(function () {
        var tds = '<tr>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="productid_' + i + '" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control " id="pname_' + i + '" onclick="product_autocom(this)" onblur="product_info(this)"/></td>';
        tds += '<td><input type="text" name="" class="form-control" id="pcode_' + i + '" readonly /></td>';
        tds += '<td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
        tds += '<td class="hide_this"><input type="text" name="" value="" class="form-control" id="id_' + i + '" readonly /></td>';
        tds += '</tr>';
        if ($('tbody', this).length > 0) {
            $('tbody', this).append(tds);
        } else {
            $(this).append(tds);
        }
        i++;
        $('#initilize_product').val(i);
    });

});
$('#update_product_row').on('click', function () {
    var i = $('#product_no').val();
    var value = $('#ruralcenter_id_0').val();
    $("#product_table").each(function () {
        var tds = '<tr>';
        tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="productid_' + i + '" readonly /></td>';
        tds += '<td><input type="text" name="" class="form-control " id="pname_' + i + '" onclick="product_autocom(this)" onblur="product_info(this)"/></td>';
        tds += '<td><input type="text" name="" class="form-control" id="pcode_' + i + '" readonly /></td>';
        tds += '<td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
        tds += '<td class="hide_this"><input type="text" name="" value="" class="form-control" id="id_' + i + '" readonly /></td>';
        tds += '<td class="hide_this"><input type="text" name="" value="' + value + '" class="form-control" id="ruralcenter_id_' + i + '" readonly /></td>';
        tds += '</tr>';
        if ($('tbody', this).length > 0) {
            $('tbody', this).append(tds);
        } else {
            $(this).append(tds);
        }
        i++;
        $('#product_no').val(i);
    });

});

$('#add_data').on('click', function () {
    $('#rural_center_form').submit();
    var skill = {};
    var i = 0;
    $('#bank_table tr td input,#bank_table tr td select').each(function () {
        skill[i] = $(this).val();
        i++;
    });

    var product = {};
    var j = 0;
    $('#product_table tr td input,#product_table tr td select').each(function () {
        product[j] = $(this).val();
        j++;
    });

    var rowsArray = {'skill': skill, 'product': product};
    console.log(rowsArray); 

    var data_save = loc + 'rural_info';


    $.ajax({
        type: 'post',
        url: data_save,
        data: {rowsArray: rowsArray},
        success: function (result) {
            var root = location.protocol + '//' + location.host;
            window.location.href = root + "/pebblescms/main/rural_center_list";
            alert('Success');
            console.log('ok');
        }
    });

});
/* delete row */
function deleteRow(btn) {
    if (confirm("You want to Delete this row")) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
        artisan_capacity('test');
        hourly_capacity('test');
        hourly_rate('test');

    }
}
$('#update').on('click', function () {

    $('#rural_center_form').submit();
    var product_no = $('#product_no').val();
    var skill_no = $('#skill_no').val();
    var id = $('#id').val();
    var check = {};
    check['product_no'] = product_no;
    check['skill_no'] = skill_no;
    check['id'] = id;
    var skill = {};
    var i = 0;
    $('#bank_table tr td input,#bank_table tr td select').each(function () {
        skill[i] = $(this).val();
        i++;
    });

    var product = {};
    var j = 0;
    $('#product_table tr td input,#product_table tr td select').each(function () {
        product[j] = $(this).val();
        j++;
    });
    var rowsArray = {skill: skill, product: product , check: check};
    console.log(rowsArray);
//    exit;
    var data_save = loc + 'rural_info_update';
    $.ajax({
        type: 'post',
        url: data_save,
        asyn: false,
        data: {rowsArray: rowsArray},
        success: function (result) {
            var root = location.protocol + '//' + location.host;
            window.location.href = root + "/pebblescms/main/rural_center_list";
            alert('Success');
            console.log('ok');
        }
    });

});

function artisan_capacity(obj) {
    var sum = 0;
    $(".artisan_capacity").each(function () {
        var value = $(this).val();
        // add only if the value is number
        if (!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);
        }

    });

    $('#artisan_capacity').val(sum);
}

function hourly_capacity(obj) {
    var sum = 0;
    $(".hourly_capacity").each(function () {
        var value = $(this).val();
        // add only if the value is number
        if (!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);
        }

    });

    $('#hour_capacity').val(sum);
}

function hourly_rate(obj) {
    var sum = 0;
    $(".hourly_rate").each(function () {
        var value = $(this).val();
        // add only if the value is number
        if (!isNaN(value) && value.length != 0) {
            sum += parseFloat(value);
        }

    });

    $('#hourly_rate').val(sum);
}