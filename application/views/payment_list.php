<style>
    .form-group{
        width: 49%;
        margin-top: 15px;
    }
    .hide_this{
        display: none;
    }
    .form-group label{
        min-width: 100px;
    }
    .ui-autocomplete {
        z-index:2147483647;
    }
</style>
<div class="container list_content">
    <div class="title list_title">
        <h3><b>Payment List</b>
            <a  data-toggle="modal" data-target="#rcModal"  class="btn col-sm-3 " style="background-color: #85C51F; margin-right: 10px; padding: 4px; color: white; font-size: 20px; float: right"><b><span class="glyphicon glyphicon-plus"></span>Add Payment  </b></a>
        </h3>
    </div>
    <div style="background-color: #E5E5E5; min-height: 50px">
        <!--            <a href="">Archive |</a>
                    <a href="">Delete</a>-->
        <button type="submit" class="btn col-sm-1 search" id="click_search"><b><span class="glyphicon glyphicon-search"></span> Search</b></button>
    </div>    
    <div id="search" class="search_div"> <!-- start search div -->
        <form class="form-inline" method="POST" action="<?php echo base_url('main/client') ?>"> <!--start search form -->
            <div class="form-group">
                <label for="keyword_for">Currency Name</label>
                <input type="text" class="form-control" name="currency_name" id="keyword_for" placeholder="Currency Name">
            </div>
            <div class="form-group">
                <label for="keyword_value">Short Form</label>
                <input type="text" class="form-control" id="keyword_value" name="keyword_value" placeholder="Keyword Value">
            </div>
            <div class="form-group">
                <!--                <label for="remarks">Remarks</label>
                                <input type="text" class="form-control" id="remarks" name="remarks" placeholder="Remarks">-->
            </div>
            <div class="form-group" style="width: 100%;text-align: center;margin-top: 20px;margin-bottom: 20px">                
                <button type="submit" name="search" value="search" class="btn btn-default">Search</button>
                <button type="reset" class="btn btn-default">Reset</button>                
            </div>
        </form><!-- end search form -->
    </div><!-- end search div -->

    <div>
        <table class="table table-striped">
            <tr class="list_header">
                <th>RC Name</th>
                <th>Payment Number</th>
                <th>Payment Mode</th>
                <th>Currency</th>
                <th>Pay Date</th>
                <th></th>
            </tr>
            <?php
//            print_r($value);            exit;
            foreach ($value as $key) {
                $where = array('id' => $key['pay_mode_id']);
                $result = $this->um->get_data('conf_paymentmode', $where);
                $workwhere = array('currency_id' => $key['pay_currency_id']);
                $workorder = $this->um->get_data('conf_currency', $workwhere);
                $dist_rec_id = array('distrcv_id' => $key['dist_rcv_id']);
                $rural_center_id = $this->um->get_data('distribution_receive', $dist_rec_id, 'distribution', 'distribution_id', 'distribution_id', '', '', '');
                $rural_center_name = $rural_center_id[0]['ruralcenter_id'];
                $whererc = array('id' => $rural_center_name);
                $resultrc = $this->um->get_data('conf_ruralcenter', $whererc);
                ?>
                <tr>
                    <td><?php echo $resultrc[0]['center_name'] ?></td>
                    <td><?php echo $key['pay_number'] ?></td>
                    <td><?php echo $result[0]['payment_mode'] ?></td> 
                    <td><?php echo $workorder[0]['currency_name'] ?></td>
                    <td><?php echo date_format(date_create($key['pay_date']), 'd-M-Y') ?></td>     
                    <td><a href="<?php echo base_url('home/payment_edit') . '?pay_id=' . $key['pay_id'] ?>">Edit</a></td>
                </tr>
                <?php
            }
            ?> 
        </table>
    </div>
    <div class="col-sm-6">
        <?php echo $page; ?>
    </div>
</div>

<div id="rcModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Select Rural Center</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline" role="form" method="POST" id="search_distribution" action="<?php echo base_url('#'); ?>">
                    <div class="form-group" style="width: 80%">
                        <label class="control-label "style="margin-right:88px;">Select RC Name:</label>

                        <input type="text" class="form-control" name="rc_name" id="rc_name">
                        <input type="hidden" class="form-control" name="rc_id" id="rc_id">                       

                    </div>  

                    <div class="form-group" style="width: 80%">
                        <label class="control-label " >Select Date:</label>
                        <label for="from">From</label>
                        <input type="text" id="from" name="from">
                        <label style="margin-left:104px;" for="to">to</label>
                        <input type="text" id="to" name="to">
                        <button type="button" id="submit_distribution" class="btn btn-primary">Search</button>
                    </div>  
                </form>
            </div>

            <div style="float: left; width: 100%;">
                <table class="table table-bordered" id="product_actiontime" style="width:100%;">
                    <tr class="list_header">
                        <th>Distribution No</th>                       
                        <th>Receive Date</th>    
                        <th>Remarks</th>   
                        <th>action</th>
                    </tr>            
                </table>
            </div>
            <div class="modal-footer">
                <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<script>

    $(function () {
        $("#from").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#to").datepicker("option", "minDate", selectedDate);
            }
        });
        $("#to").datepicker({
            defaultDate: "+1w",
            changeMonth: true,
            numberOfMonths: 1,
            onClose: function (selectedDate) {
                $("#from").datepicker("option", "maxDate", selectedDate);
            }
        });
    });
    $(document).ready(function () {
        $('#click_search').on('click', function () {
            $('#search').toggle("slow");
        });
    });
//     var pathArray = location.pathname.split('/');
//    var rmloc = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';
//    var url = rmloc + 'rc_name';
    var url = '<?php echo base_url('home/get_rcname') ?>';
    $('#rc_name').autocomplete({
        source: url,
        minLength: 0,
        select: function (event, ui)
        {
            var rc_id = ui.item.id;
            var rc_name = ui.item.label;
//                    console.log(name);
            $("#rc_name").val(rc_name);
            $("#rc_id").val(rc_id);
            return false;
        }
    });
    $('#rc_name').on('blur', function () {
        var id = $("#rc_id").val();
        var url = '<?php echo base_url('home/get_dis_no') ?>';
        $.ajax({
            type: "POST",
            url: url, //Relative or absolute path to response.php file
            data: 'id=' + id,
            dataType: 'json',
            success: function (data) {
                console.log(data);
                var i;
                var j = 0;
                var string = '';
                string += ' <option class="check_del" value="" >Please Select Branch</option>';
                var len = data.length;
                for (i = 0; i < len; i++) {
                    string += '<option class="" value="' + data[j].distribution_id + '">' + data[j].distribution_no + '</option>';
                    j = j + 1;
                }
                $('#distribution_no').append(string);
            }

        });
    });

    $('#submit_distribution').on('click', function () {
        var wo = {};
        wo[0] = $('#rc_name').val();
        wo[1] = $('#rc_id').val();
        wo[2] = $('#from').val();
        wo[3] = $('#to').val();
        var eew1 = $('#from').val();
        var eew2 = $('#from').val();
        var url = '<?php echo base_url('home/find_receive') ?>';

        $.ajax({
            async: false,
            type: 'post',
            url: url,
            dataType: "json",
            data: {myarray: wo},
            success: function (data) {
                var l = data['value'].length;
                var milliseconds = Date.parse(data.value[0]['receive_date']);
                var milliseconds1 = Date.parse(eew1);
                var milliseconds2 = Date.parse(eew2);
                var j = 0;
                for (var j = 0; j < l; j++)
                {
                    $('#product_actiontime').each(function () {
                        var tds = '<tr class="del_row">';
                        tds += '<td><input type="text" readonly name="dis_no" value="' + data.value[j]["distribution_no"] + '" class="form-control " id="dis_no_' + j + '"/></td>';
                        tds += '<td class="hide_this"><input type="text" readonly name="distrcv_id" value="' + data.value[j]["distrcv_id"] + '" class="form-control " id="distrcv_id_' + j + '"/></td>';
                        tds += '<td><input type="text" readonly name="receive_date" value="' + data.value[j]["receive_date"] + '" class="form-control " id="receive_date_' + j + '"/></td>';
                        tds += '<td><input type="text" readonly name="remarks_as" value="' + data.value[j]["remarks"] + '" class="form-control"  id="remarks_as_' + j + '"  /></td>';
                        tds += '<td> <button type="button" id="submit_dis_' + j + '" onclick="get_dist_recv(this)" class="btn btn-primary">Pay</button></td>';

                        tds += '</tr>';
                        if ($('tbody', this).length > 0) {
                            $('tbody', this).append(tds);
                        } else {
                            $(this).append(tds);
                        }
                    });
                }
            }

        });

    });

    function get_dist_recv(obj) {
        var id = obj.id;
        var value = $('#' + id).val();
        var saper_id = id.split("_");
        var i = saper_id[2];
        var ty = $('#distrcv_id_' + i).val();
        var url = '<?php echo base_url('home/for_test') ?>';
        $.ajax({
            type: "POST",
            url: url, //Relative or absolute path to response.php file
            data: 'name=' + ty,
            dataType: 'json',
            success: function (data) {
                console.log(data);

                var url_location = '<?php echo base_url('home/payment?dis_id=') ?>' + data;
                window.location.assign(url_location);
            }
        });
    }

</script>

