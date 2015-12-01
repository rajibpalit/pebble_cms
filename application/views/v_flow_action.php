<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Flow Action</b></h3>
    </div>
    <input type="hidden" id="initilize_bank" value="1"/>
    <input type="hidden" id="initilize_product" value="1"/>
    <div style="margin-top: 5%; margin-left: 15%">
        <input type="hidden" id="initilize_value" value="<?php echo (isset($conf_flowaction_actions)) ? count($conf_flowaction_actions) : 1 ?>"/>
        <form class="form-horizontal" id="flow_action_form" role="form" method="post" action="<?php echo base_url('main/save_flow_action') ?>">
            <div class="form-group">
                <input type="hidden" name="f_action_id" class="form-control" id="f_action_id" value=" <?php echo isset($value) ? $value[0]['id'] : "" ?>" />
                <label class="control-label col-sm-2" for="flow_name">Flow Name</label>
                <div class="col-sm-3">
                    <select class="form-control" id="flow_name" name="flow_name">

                        <?php
                        foreach ($flow_names as $flow_name) {
                            if ($flow_name['keyword_id'] == $value[0]['flow_name']) {
                                $checked = 'selected';
                            } else {
                                $checked = '';
                            }
                            echo '<option ' . $checked . ' value="' . $flow_name['keyword_id'] . '">' . $flow_name['keyword_value'] . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-sm-2" for="remarks">Remarks</label>
                <div class="col-sm-3">
                    <input type="text" required="required" class="form-control" name="remarks" value="<?php echo isset($value) ? $value[0]['remarks'] : '' ?>" id="remarks" placeholder="Remarks">
                </div>
            </div>
            <div class="form-group">
                <div>

                    <label class="control-label col-sm-2" for="status" style="margin-right: 20px">Status </label>
                </div>
                <div style="margin-left: 13px;">
                    <label class="radio-inline">
                        <input type="radio" name="status" <?php echo!isset($value) ? 'checked' : '' ?> <?php echo isset($value) && ($value[0]['status'] == 1) ? 'checked' : '' ?> id="inlineRadio1" value="1"> Active
                    </label>
                    <label class="radio-inline">
                        <input type="radio" name="status" id="inlineRadio2" <?php echo isset($value) && ($value[0]['status'] == 0) ? 'checked' : '' ?> value="0"> Inactive
                    </label>
                </div>
            </div>


        </form>
        <div style="float: left; width: 115%; margin-left: -15%;">

            <input type="button" value="Add Row" name="distributed_id" id="add_row" style="float: right; width: 86px;padding-bottom: 8px; padding-top: 6px; border-radius:5px;cursor: pointer; " class="btn btn-primary col-sm-2">
            <table class="table table-bordered" id="flow_action_table">
                <tr class="list_header">
                    <th>Action Name</th>                       
                    <th>Order</th>                      
                    <th>Quality Control</th>
                    <th>Remarks</th>
                    <th>Action</th>
                </tr>
                <?php
                if (isset($conf_flowaction_actions)) {
                    $i = 0;
                    foreach ($conf_flowaction_actions as $f_action_action) {

                        $where['id'] = $f_action_action['action_name'];
                        $this->db->select('*');
                        $this->db->where($where);
                        $action_name = $this->db->get('conf_productactions')->result_array();
                        ?>
                        <tr>
                            <td><input type="text" name="action_name"  class="form-control" id="action_name_<?php echo $i ?>" value="<?php echo $action_name[0]['action_name'] ?>" onclick="autocom(this)"/></td> 
                            <td class="hide_this"><input type="text" name="f_action_action" class="form-control" id="f_action_action_<?php echo $i ?>" value="<?php echo $action_name[0]['id'] ?>" /></td>
                            <td><input type="text" name="order"  class="form-control" id="order_0" value="<?php echo $f_action_action['order'] ?>"/></td>                       
                            <td><input type="text" name="qc" class="form-control" id="qc_0" value="<?php echo $f_action_action['qc'] ?>"/></td>
                            <td><input type="text" name="remarks" class="form-control" id="remarks_0" value="<?php echo $f_action_action['remarks'] ?>"/></td>
                            <td class="hide_this"><input type="text" name="f_actions_action_id" class="form-control" id="f_actions_action_id_<?php echo $i ?>" value="<?php echo $f_action_action['id'] ?>" /></td>
                            <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                        </tr>

                        <?php
                        $i++;
                    }
                } else {
                    ?>
                    <tr>
                        <td><input type="text" name="action_name"  class="form-control" id="action_name_0" onclick="autocom(this)"/></td>
                        <td class="hide_this"><input type="text" name="f_action_action" class="form-control" id="f_action_action_0"/></td>
                        <td><input type="text" name="order"  class="form-control" id="order_0"/></td>                       
                        <td><input type="text" name="qc" value=" "  class="form-control" id="qc_0"/></td>
                        <td><input type="text" name="remarks" value=" "  class="form-control" id="remarks_0"/></td>
                        <td class="hide_this"><input type="text" name="f_action_action" class="form-control" id="f_action_action_0" value="" /></td>
                        <td><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>
                    </tr>
                <?php } ?>
            </table>
        </div>
        <div class="sub_cancel">


            <input type="button" id="<?php echo (isset($value[0]['id'])) ? 'update' : 'submit'; ?>" value="<?php echo (isset($value[0]['id'])) ? 'Update' : 'Submit'; ?>" class="btn btn-primary"/>

            <a href="<?php echo base_url('main/flow_action_list') ?>" class="btn btn-success">Cancel</a>
        </div>
    </div>
</div>
<script>


    var pathArray = location.pathname.split('/');
    var loc = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';
    console.log(loc);
    $(document).ready(function () {
        $("#distribution_quantity").on('change', function () {
//                var increased = parseInt($("#distribution_quantity").text());
            var increased = parseInt($("#distribution_quantity").val());
            ;
//            console.log(increased);
            if (isNaN(increased) || increased <= 0) {
                $("#distribution_quantity").val('1');
            }
        });
        $("#add_row").on('click', function () {
            var i = $('#initilize_value').val();
            $('#flow_action_table').each(function () {
                var tds = '<tr>';
                tds += '<td><input type="text" name="action_name"  class="form-control" id="action_name_' + i + '" onclick="autocom(this)"/></td>'
                tds += '<td class="hide_this"><input type="text" name="f_action_action" class="form-control" id="f_action_action_' + i + '" /></td>'
                tds += '<td><input type="text" name="order"  class="form-control" id="order_' + i + '"/></td>'
                tds += '<td><input type="text" name="qc" value=" "  class="form-control" id="qc_' + i + '"/></td>'
                tds += '<td><input type="text" name="remarks" value=" "  class="form-control" id="remarks_' + i + '"/></td>'
                tds += '<td class="hide_this"><input type="text" name="f_actions_action_id_" class="form-control" id="f_actions_action_id_' + i + '" /></td>'
                tds += ' <td class=""><input type="button" class="btn btn-danger" value="Delete" onclick="deleteRow(this)"/></td>'
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
    });

    $('#submit').on('click', function () {
        $('#flow_action_form').submit();
        var rowsArray = {};
        var i = 0;
        $('#flow_action_table tr td input,#bank_table tr td select').each(function () {
            rowsArray[i] = $(this).val();
            i++;
        });
//    console.log(rowsArray); exit;
        var data_save = loc + 'save_flow_info';
        $.ajax({
            type: 'post',
            url: data_save,
            data: {rowsArray: rowsArray},
            success: function (result) {

//            console.log('ok');
                var root = location.protocol + '//' + location.host;
                window.location.href = root + "/pebblescms/main/flow_action_list";
            }
        });
    });


    $('#update').on('click', function () {
       $('#flow_action_form').submit();
        var product_action = {};
        var product_action_id = $('#f_action_id').val();
        product_action['product_action_id'] = product_action_id;
        var flow_actions = {};
        var i = 0;
        $('#flow_action_table tr td input,#bank_table tr td select').each(function () {
            flow_actions[i] = $(this).val();
            i++;
        });
        var rowsArray = {flow_actions: flow_actions, product_action: product_action};
    console.log(rowsArray); //exit;
        var data_save = loc + 'save_and_update_flow_info';
        $.ajax({
            type: 'post',
            url: data_save,
            data: {rowsArray: rowsArray},
            success: function (result) {

//            console.log('ok');
                var root = location.protocol + '//' + location.host;
                window.location.href = root + "/pebblescms/main/flow_action_list";
            }
        });
    });

    function autocom(obj) {
        var id = obj.id;
        var saper_id = id.split("_");
        var i = saper_id[2];
        var url = loc + "action_info";
        console.log(i);
        $('#' + id)
                .autocomplete({
                    source: url,
                    minLength: 0,
                    select: function (event, ui)
                    {
                        var p_id = ui.item.id;
                        var name = ui.item.label;
                        $('#' + id).val(name);
//                        console.log(p_id); exit;
                        $("#f_action_action_" + i).val(p_id);
                        return false;
                    }
                })

                .focus(function () {
                    $(this).autocomplete('search', $(this).val());
                });
    }
    function deleteRow(btn) {
        if (confirm("You want to Delete this row")) {
            var row = btn.parentNode.parentNode;
            row.parentNode.removeChild(row);
            calculateSum();
        }
    }


    $().ready(function () {

        $("#flow_action_form").validate({
            rules: {
                description: "required",
                associated_action: "required",
            },
            messages: {
                description: "Please Enter Description Field",
                associated_action: "Please select associated action",
            }
        });
    });
</script>

