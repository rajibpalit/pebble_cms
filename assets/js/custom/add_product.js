var pathArray = location.pathname.split('/');
var loc = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';
function autocommaterial(obj) {
    var id = obj.id;
    var url = loc + 'get_material';
    $('#' + id)
            .autocomplete({
                source: url,
                minLength: 0
            })
            .focus(function () {
                $(this).autocomplete('search', $(this).val());
            });
}
function autocomaction() {
    var value = $('#flow').val();
    var url = loc + 'get_action';
    $.ajax({
        type: "POST",
        url: url, //Relative or absolute path to response.php file
        data: 'name=' + value,
        dataType: 'json',
        success: function (data) {
            action(data);
        }
    });
}
$(document).ready(function () {
    var value = $('#flow :selected').val();
    var product_id = $('#product_id').val();
    if (product_id != 0)
    {
        var url = loc + 'get_action1?product_id=' + product_id;
        $.ajax({
            type: "POST",
            url: url, //Relative or absolute path to response.php file
            data: 'name=' + value,
            dataType: 'json',
            success: function (data) {
                action1(data);

            }
        });
    }

});
function autocomrate(obj) {
    var id = obj.id;
    var url = loc + 'client_get_info';
    $('#' + id)
            .autocomplete({
                source: url,
                minLength: 0
            })
            .focus(function () {
                $(this).autocomplete('search', $(this).val());
            });
}
function autocomputrate(obj) {
    var id = obj.id;
    var value = $('#' + id).val();
    var saper_id = id.split("_");
    var i = saper_id[2];
    var url = loc + 'client_rate_info';
    $.ajax({
        type: "POST",
        url: url, //Relative or absolute path to response.php file
        data: 'name=' + value,
        dataType: 'json',
        success: function (data) {
            $('#currency_name_' + i).val(data.short_form);
            $('#currency_id_' + i).val(data.currency);
            $('#client_id_' + i).val(data.client_id);
        }
    });
}
function autocompart(obj) {
    var id = obj.id;
    var url = loc + 'get_product_part';
    $('#' + id)
            .autocomplete({
                source: url,
                minLength: 0
            })
            .focus(function () {
                $(this).autocomplete('search', $(this).val());
            });
}
function computpart(obj) {
    var id = obj.id;
    var value = $('#' + id).val();
    var saper_id = id.split("_");
    var i = saper_id[1];
    var url = loc + 'all_product_part';
    $.ajax({
        type: "POST",
        url: url, //Relative or absolute path to response.php file
        data: 'name=' + value,
        dataType: 'json',
        success: function (data) {
            $('#part_name_id_' + i).val(data.id);
            $('#pcode_' + i).val(data.code);
            $('#pdefault_rate_' + i).val(data.default_rate);
            $('#pcolor_' + i).val(data.color_name);
            $('#psize_' + i).val(data.size_name);
        }
    });
}
function computmaterial(obj) {
    var id = obj.id;
    var value = $('#' + id).val();
    var saper_id = id.split("_");
    var i = saper_id[1];
    var url = loc + 'all_material_info';
    $.ajax({
        async: false,
        type: "POST",
        url: url, //Relative or absolute path to response.php file
        data: 'name=' + value,
        dataType: 'json',
        success: function (data) {
            $('#mnameid_' + i).val(data.id);
            $('#mcode_' + i).val(data.material_code);
            $('#mmu_' + i).val(data.m_unit_name);
            $('#mmuid_' + i).val(data.m_unit_id);
            $('#mcolor_' + i).val(data.color_name);
            $('#mcolorid_' + i).val(data.color_id);
            $('#msize_' + i).val(data.size_name);
            $('#msizeid_' + i).val(data.size_id);
        }
    });
}
$('#submit').on('click', function (e) {
//    
//    $(function () {
//        $('.error').hide();
//        // validate and process form here
//
//        $('.error').hide();
//        var product_name = $("#product_name").val();
//        var code = $("#code").val();
//        var color = $("#color").val();
//        var size = $("#size").val();
//        var skill = $("#skill").val();
//        var flow = $("#flow").val();
//        var default_rate = $("#default_rate").val();
//        var previewing = $("#previewing").val();
//        
//        
//        
////          var ename = $("input#client_name").val();
//        console.log(name);
////          return false;
//        if (!product_name) {
//            $("#product_name_error").show();
//            $("#product_name_error").focus();
////        return false;
//        }
//        else
//        {
//            $('.error').hide();
//        }
//        if (!code) {
//            $("#code_error").show();
//            $("#code_error").focus();
////        return false;
//        }
//        if (!color) {
//            $("#color_error").show();
//            $("#color_error").focus();
////        return false;
//        }
//        if (!size) {
//            $("#size_error").show();
//            $("#size_error").focus();
////        return false;
//        }
//        if (!skill) {
//            $("#skill_error").show();
//            $("#skill_error").focus();
////        return false;
//        }
//        if (!flow) {
//            $("#flow_error").show();
//            $("#flow_error").focus();
////        return false;
//        }
//        if (!default_rate) {
//            $("#default_rate_error").show();
//            $("#default_rate_error").focus();
////        return false;
//        }
//        
//        if (!previewing) {
//            $("#previewing_error").show();
//            $("#previewing_error").focus();
//           
//            return false;
//        }
//
//    });
//    
//    
//    
//    
//    
//    
    
    
    e.preventDefault();
    $("#message").empty();
    $('#loading').show();
    var formData = new FormData();
    formData.append('file', $('input[type=file]')[0].files[0]);
    var data_save = loc + 'image_upload';
    $.ajax({
        async: false,
        url: data_save, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: formData, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        processData: false, // To send DOMDocument or non processed data file it is set to false
        success: function (data)   // A function to be called if request succeeds
        {
            $('#loading').hide();
            $("#message").html(data);
        }
    });
    var test = {};
    var docsArray = {};
    var product = {};
    var actiontimeArray = {};
    var partArray = {};
    var rawmaterialsArray = {};
    var clientrateArray = {};
    var formData1 = new FormData();
    formData1.append('file', $('input[name=attachment]')[0].files[0]);
    var data_save = loc + 'file_upload';
    $.ajax({
        async: false,
        url: data_save, // Url to which the request is send
        type: "POST", // Type of request to be send, called as method
        data: formData1, // Data sent to server, a set of key/value pairs (i.e. form fields and values)
        contentType: false, // The content type used when sending data to the server.
        cache: false, // To unable request pages to be cached
        dataType: "json",
        processData: false, // To send DOMDocument or non processed data file it is set to false
        success: function (data)   // A function to be called if request succeeds
        {
            docsArray[0] = data.doc_name;
            docsArray[1] = data.doc_extension;
            docsArray[2] = data.doc_size;
            docsArray[3] = data.doc_location;
            $('#loading').hide();
            $("#message").html(data);
        }
    });
    var i = 0;
    var j = 0;
    test[0] = $('#product_id').val();
    product[0] = $('#product_name').val();
    product[1] = $('#code').val();
    product[2] = $('#color').val();
    product[3] = $('#size').val();
    product[4] = $('#skill').val();
    product[5] = $('#flow').val();
    product[6] = $('#default_rate').val();
    product[7] = $('#file').val();
    product[8] = $(' input:radio[name=has_part]:checked').val();
    product[9] = $('#p_status').val();

    $('#product_actiontime tr td input,#product_actiontime tr td select').each(function () {
        actiontimeArray[i] = $(this).val();
        i++;
    });
    $('#p_part tr td input,#p_part tr td select').each(function () {
        partArray[i] = $(this).val();
        i++;
    });
    $('#product_rawmaterials tr td input,#product_rawmaterials tr td select').each(function () {
        rawmaterialsArray[j] = $(this).val();
        j++;
    });
    $('#product_clientrate tr td input,#product_clientrate tr td select').each(function () {
        clientrateArray[i] = $(this).val();
        i++;
    });
    var d = {
        test: test,
        docsArray: docsArray,
        product: product,
        actiontimeArray: actiontimeArray,
        partArray: partArray,
        rawmaterialsArray: rawmaterialsArray,
        clientrateArray: clientrateArray
    };
    console.log(d);
    var data_save = loc + 'save_product';
    $.ajax({
        async: false,
        type: 'post',
        url: data_save,
        data: {myarray: d},
        success: function (result) {
                     var url_location =loc +'product_list'; 
                window.location.assign(url_location);
        }
    });
});

// Function to preview image after validation

$(function () {
    $("#file").change(function () {
        $("#message").empty(); // To remove the previous error message
        var file = this.files[0];
        var imagefile = file.type;
        var match = ["image/jpeg", "image/png", "image/jpg"];
        if (!((imagefile == match[0]) || (imagefile == match[1]) || (imagefile == match[2])))
        {
            $('#previewing').attr('src', '../assets/images/noimage.png');
            $("#message").html("<p id='error' style=" + "color:red" + ">Please Select A valid Image File</p>" + "<h4>Note</h4>" + "<span id='error_message' style=" + "color:green" + ">Only jpg, png and jpeg Images type allowed</span>");
            return false;
        }
        else
        {
            var reader = new FileReader();
            reader.onload = imageIsLoaded;
            reader.readAsDataURL(this.files[0]);
        }
    });
});


$(function () {
    $("#attachment").change(function () {
        $("#message").empty(); // To remove the previous error message
        var file = $("#attachment").val();
        var ext = file.split('.').pop();
        var match = ["pdf", "doc", "txt"];
        if (!((ext == match[0]) || (ext == match[1]) || (ext == match[2])))
        {
//            $('#previewing').attr('src', 'noimage.png');
            $("#file_message").html("<p id='error' style=" + "color:red" + ">Please Select A valid format File</p>" + "<h4>Note</h4>" + "<span id='error_message' style=" + "color:green" + ">Only pdf, doc and txt Images type allowed</span>");
            return false;
        }
    });
});


function imageIsLoaded(e) {
    $("#file").css("color", "green");
    $('#image_preview').css("display", "block");
    $('#previewing').attr('src', e.target.result);
    $('#previewing').attr('width', '250px');
    $('#previewing').attr('height', '230px');
}
;

function action1(data)
{

    $(".del_row").each(function () {
        $(this).remove();
    });
    var l = data['value'].length;
    var j = 0;
    if (l != 0)
    {

        for (var j = 0; j < l; )
        {
            var i = $('#initilize_value').val();
            $('#product_actiontime').each(function () {
                var val_checked = data['value'][j]['dist_req'];
                if (val_checked == 1)
                {
                    var str = 'checked';
                }
                else {
                    var str = '';
                }
                var tds = '<tr class="del_row">';
                tds += '<td><input type="text" name="" value="' + data['value'][j]['action_name'] + '" class="form-control " id="aname_' + i + '"/></td>';
                tds += '<td class="hide_this"><input type="text" name="action_id" value="' + data['value'][j].flow_action_id + '" class="form-control " id="action_id_' + i + '"/></td>';
                tds += '<td><input type="text" name="" class="form-control" value="' + data['value'][j]['action_time'] + '" id="atime_' + i + '"  /></td>';
//                tds += '<td class="hide_this"><input type="text" name="" class="form-control" value="' + data['value'][j]['dist_req'] + '" id="acheckhide_' + i + '" readonly /></td>';
                tds += '<td><input type="checkbox"' + str + 'style="margin-left: -77px" value="' + data['value'][j]['dist_req'] + '" name="" class="form-control" id="acheck_' + i + '" /></td>';
                tds += ' <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
                tds += '</tr>';
                tds += '</tr>';
                if ($('tbody', this).length > 0) {
                    $('tbody', this).append(tds);
                } else {
                    $(this).append(tds);
                }
            });
            j++;
        }


    }
}

function action(data)
{
    $(".del_row").each(function () {
        $(this).remove();
    });
    var l = data.length;
    var j = 0;
    if (l != 0)
    {
        for (var j = 0; j <= l; j++)
        {
            var i = $('#initilize_value').val();
            $('#product_actiontime').each(function () {
                var tds = '<tr class="del_row">';
                tds += '<td><input type="text" name="" value="' + data[j]['action_name'] + '" class="form-control " id="aname_' + j + '"/></td>';
                tds += '<td class="hide_this"><input type="text" name="action_id" value="' + data[j].flow_action_id + '" class="form-control " id="action_id_' + j + '"/></td>';
                tds += '<td><input type="text" name="" class="form-control"  id="atime_' + j + '"  /></td>';
                tds += '<td><input type="checkbox" value="0" style="margin-left: -77px"  name="" class="form-control" onclick="change_value(this)" id="acheck_' + j + '" /></td>';
                tds += ' <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
                tds += '</tr>';
                tds += '</tr>';
                if ($('tbody', this).length > 0) {
                    $('tbody', this).append(tds);
                } else {
                    $(this).append(tds);
                }
            });
        }
    }
}


$(document).ready(function () {
    $("#add_row1").on('click', function () {
        var i = $('#initilize_value1').val();
        $('#product_parts').each(function () {
            var tds = '<tr>';
            tds += '<td><input type="text" name="" class="form-control " id="pname_' + i + '" onclick="autocompart(this)" onblur="computpart(this)"/></td>';
            tds += '<td><input type="text" name="" class="form-control" id="pcode_' + i + '" readonly /></td>';
            tds += '<td><input type="text" name="" class="form-control" id="pquantity_' + i + '"/></td>';
            tds += '<td><input type="text" name="" class="form-control" id="pdefault_rate_' + i + '" readonly /></td>';
            tds += '<td><input type="text" name="" class="form-control" id="pcolor_' + i + '" readonly /></td>';
            tds += '<td><input type="text" name="" class="form-control" id="psize_' + i + '" readonly /></td>';
            tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="part_name_id_' + i + '"  /></td>';
            tds += ' <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
            tds += '</tr>';
            if ($('tbody', this).length > 0) {
                $('tbody', this).append(tds);
            } else {
                $(this).append(tds);
            }
            i++;
            $('#initilize_value1').val(i);
        });
    });
    $("#add_row2").on('click', function () {
        var i = $('#initilize_value2').val();
        $('#product_rawmaterials').each(function () {
            var tds = '<tr>';
            tds += '<td><input type="text" name="" class="form-control " id="mname_' + i + '" onclick="autocommaterial(this)" onblur="computmaterial(this)"/></td>';
            tds += '<td><input type="text" name="" class="form-control" id="mmu_' + i + '" readonly /></td>';
            tds += '<td><input type="text" name="" class="form-control" id="mcolor_' + i + '" readonly /></td>';
            tds += '<td><input type="text" name="" class="form-control" id="msize_' + i + '" readonly /></td>';
            tds += '<td><input type="text" name="" class="form-control" id="mcode_' + i + '" readonly /></td>';
            tds += '<td><input type="text" name="" class="form-control" id="mquantity_' + i + '"/></td>';
            tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="mnameid_' + i + '" readonly /></td>';
            tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="mmuid_' + i + '" readonly /></td>';
            tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="mcolorid_' + i + '" readonly /></td>';
            tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="msizeid_' + i + '" readonly /></td>';
            tds += ' <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
            tds += '</tr>';
            if ($('tbody', this).length > 0) {
                $('tbody', this).append(tds);
            } else {
                $(this).append(tds);
            }
            i++;
            $('#initilize_value2').val(i);
        });
    });
    $("#add_row3").on('click', function () {

        var i = $('#initilize_value3').val();
        $('#product_clientrate').each(function () {

            var tds = '<tr>';
            tds += '<td><input type="text" name="" class="form-control" id="client_name_' + i + '" onclick="autocomrate(this)" onblur="autocomputrate(this)"/></td>';
            tds += '<td><input type="text" name="" class="form-control" id="current_rate_' + i + '"  /></td>';
            tds += '<td><input type="text" name="" class="form-control" id="currency_name_' + i + '" readonly/></td>';
            tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="pcurrency_id_' + i + '" /></td>';
            tds += '<td><input type="text" name="" onfocus="datepick(this)" readonly class="form-control" id="rate_date_' + i + '"  /></td>';
            tds += '<td><input type="text" name="" class="form-control" id="client_p_code_' + i + '"  /></td>';
            tds += '<td class="hide_this"><input type="text" name="" class="form-control" id="client_id_' + i + '" readonly /></td>';
            tds += ' <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>';
            tds += '</tr>';
            if ($('tbody', this).length > 0) {
                $('tbody', this).append(tds);
            } else {
                $(this).append(tds);
            }
            i++;
            $('#initilize_value3').val(i);
        });
    });
    $('#has_part').ready(function () {
        var td = $(' input:radio[name=has_part]:checked').val();
        if (td == 1) {
            $('#p_part').show('fast');
        }
        else {
            $('#p_part').hide('fast');
        }


    });
    $('input:radio[name=has_part]').click(function () {
        var has_value = $(' input:radio[name=has_part]:checked').val();
        if (has_value == 1)
        {
            $('#p_part').show('fast');
        }
        else
        {
            $('#p_part').hide('fast');
        }
    });

});
// Function to preview image after validation
/* delete row */
function deleteRow(btn) {
    if (confirm("You want to Delete this row")) {
        var row = btn.parentNode.parentNode;
        row.parentNode.removeChild(row);
    }
}

function datepick(obj) {
    var id = obj.id;
    $('#' + id).datepicker();
}

function change_value(obj) {
    var value = obj.value;
    var id = obj.id;
    if (value == 0) {
        $('#' + id).val(1);
    }
    else {
        $('#' + id).val(0);
    }
}

