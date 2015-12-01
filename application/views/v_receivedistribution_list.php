<style>
    .form-group{
        width: 49%;
        margin-top: 15px;
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
        <h3><b>Distribution  Receive List</b>
            <a  data-toggle="modal" data-target="#rcModal"  class="btn col-sm-3 " style="background-color: #85C51F; margin-right: 10px; padding: 4px; color: white; font-size: 20px; float: right"><b><span class="glyphicon glyphicon-plus"></span>Add Distribution Receive</b></a>
        </h3>
    </div>
    <div style="background-color: #E5E5E5; min-height: 50px">
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
                <th>Distribution Number</th>
                <th>Receive Date</th>
                <th></th>
            </tr>
            <?php
//            print_r($value);exit;
            foreach ($value as $key) {
                $dist_rec_id = array('distrcv_id' => $key['distrcv_id']);
                $dis_no = $this->um->get_data('distribution_receive', $dist_rec_id, 'distribution', 'distribution_id', 'distribution_id', '', '', '');
                $rural_center_name = $dis_no[0]['ruralcenter_id'];
                $whererc = array('id' => $rural_center_name);
                $resultrc = $this->um->get_data('conf_ruralcenter', $whererc);
                ?>
                <tr>                    
                    <td><?php echo $resultrc[0]['center_name'] ?></td>
                    <td><?php echo $dis_no[0]['distribution_no'] ?></td>
                    <td><?php echo date_format(date_create($key['receive_date']), 'd-M-Y') ?></td>                    
                    <td><a href="<?php echo base_url('home/receivedistribution') . '?distrcv_id=' . $key['distrcv_id'] ?>">Edit</a></td>
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
                <form class="form-inline" role="form" method="POST" id="search_distribution" action="<?php echo base_url('home/receivedistribution_wizard'); ?>">
                    <div class="form-group required" style="width: 80%">
                        <label>Select RC Name :</label>
                        <input type="text"  style=" margin-left: 73px;" class="form-control" name="rc_name" id="rc_name">
                        <input type="hidden" class="form-control" name="rc_id" id="rc_id">                     
                    </div>  
                    <div class="form-group" style="width: 80%">
                        <label class="control-label ">Select Invoice:</label>
                        <input type="text"  style=" margin-left: 86px;" class="form-control" name="inv_no" id="inv_no">
                        <input type="hidden" class="form-control" name="inv_id" id="inv_id">                       

                    </div>  
                    <div class="form-group" style="width: 80%">
                        <label class="control-label ">Select Product Code:</label>
                        <input type="text"  style=" margin-left: 47px;" class="form-control" name="prod_no" id="prod_no">
                        <input type="hidden" class="form-control" name="prod_id" id="prod_id">                       

                    </div> 
                    <div class="form-group" style="width: 80%">
                        <label class="control-label ">Select Distribution Code:</label>
                        <input type="text"  style=" margin-left: 23px;" class="form-control" name="distribution_no" id="distribution_no">
                        <input type="hidden" class="form-control" name="distribution_id" id="distribution_id">                       
                        <button type="button" id="submit_distribution" class="btn btn-primary">Submit</button>
                    </div> 
                </form>
            </div>
            <div style="float: left; width: 100%;">
                <table class="table table-bordered" id="product_actiontime" style="width:100%;">
                    <tr class="list_header">
                        <th>Distribution No</th>                       
                        <th>Create Date</th>    
                        <th>Status</th>   
                        <th>action</th>
                    </tr>            
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>


        </div>

    </div>
</div>
<script>
    $(document).ready(function () {
        $('#click_search').on('click', function () {
            $('#search').toggle("slow");
        });
    });
    var url = '<?php echo base_url('home/get_rcname') ?>';
    $('#rc_name').autocomplete({
        source: url,
        minLength: 0,
        select: function (event, ui)
        {
            var rc_id = ui.item.id;
            var rc_name = ui.item.label;
            $("#rc_name").val(rc_name);
            $("#rc_id").val(rc_id);
            return false;
        }
    });
    var url1 = '<?php echo base_url('home/get_inv_no') ?>';
    $('#inv_no').autocomplete({
        source: url1,
        minLength: 0,
        select: function (event, ui)
        {
            var inv_id = ui.item.id;
            var inv_no = ui.item.label;
            $("#inv_no").val(inv_no);
            $("#inv_id").val(inv_id);
            return false;
        }
    });
    var url1 = '<?php echo base_url('home/get_product_no') ?>';
    $('#prod_no').autocomplete({
        source: url1,
        minLength: 0,
        select: function (event, ui)
        {
            var prod_id = ui.item.id;
            var prod_no = ui.item.label;
            $("#prod_no").val(prod_no);
            $("#prod_id").val(prod_id);
            return false;
        }
    });
    var url1 = '<?php echo base_url('home/get_distribution_no') ?>';
    $('#distribution_no').autocomplete({
        source: url1,
        minLength: 0,
        select: function (event, ui)
        {
            var distribution_id = ui.item.id;
            var distribution_no = ui.item.label;
            $("#distribution_no").val(distribution_no);
            $("#distribution_id").val(distribution_id);
            return false;
        }
    });

    $('#submit_distribution').on('click', function () {
        var wo = {};
        wo[0] = $('#rc_name').val();
        wo[1] = $('#rc_id').val();
        wo[2] = $('#inv_no').val();
        wo[3] = $('#inv_id').val();
        wo[4] = $('#prod_no').val();
        wo[5] = $('#prod_id').val();
        wo[6] = $('#distribution_no').val();
        wo[7] = $('#distribution_id').val();
        console.log(wo);
        var url = '<?php echo base_url('home/find_receive_list') ?>';

        $.ajax({
            async: false,
            type: 'post',
            url: url,
            dataType: "json",
            data: {myarray: wo},
            success: function (data) {
                console.log(data);
                var l = data['value'].length;
                console.log(l);
                var j = 0;
                for (var j = 0; j < l; j++)
                {
                    $('#product_actiontime').each(function () {
                        var tds = '<tr class="del_row">';
                        tds += '<td><input type="text" readonly name="dis_no" value="' + data.value[j]["distribution_no"] + '" class="form-control " id="dis_no_' + j + '"/></td>';
                        tds += '<td class="hide_this"><input type="text" readonly name="distrcv_id" value="' + data.value[j]["created_at"] + '" class="form-control " id="distrcv_id_' + j + '"/></td>';
                        tds += '<td><input type="text" readonly name="create_date" value="' + data.value[j]["created_at"] + '" class="form-control " id="create_date_' + j + '"/></td>';
                        tds += '<td><input type="text" readonly name="remarks_as" value="' + 'test' + '" class="form-control"  id="remarks_as_' + j + '"  /></td>';
                        tds += '<td> <button type="button" id="submit_dis_' + j + '" onclick="get_dist_recv(this)" class="btn btn-primary">View</button></td>';

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


    $('#rcModal').on('hidden.bs.modal', function (e) {
        $(this)
                .find("input,textarea,select")
                .val('')
                .end();
        $('#rcModal td').remove();
    });
    
    
    function get_dist_recv(obj) {
        var id = obj.id;
        var saper_id = id.split("_");
        var i = saper_id[2];
        console.log(i);
        var ty = $('#dis_no_' + i).val();
        var url = '<?php echo base_url('home/for_test') ?>';
        $.ajax({
            type: "POST",
            url: url, //Relative or absolute path to response.php file
            data: 'name=' + ty,
            dataType: 'json',
            success: function (data) {
                console.log(data);

                var url_location = '<?php echo base_url('home/receivedistribution_wizard?distribution_no=') ?>' + data;
                window.location.assign(url_location);
            }
        });
    }
</script>

