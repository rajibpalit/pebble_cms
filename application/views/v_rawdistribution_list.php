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
        <h3><b>Raw Material Distribution List</b>
            <a  data-toggle="modal" data-target="#rcModal"  class="btn col-sm-3 " style="background-color: #85C51F; margin-right: 10px; padding: 4px; color: white; font-size: 20px; float: right"><b><span class="glyphicon glyphicon-plus"></span>Add raw material Distribution</b></a>
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
            <div class="form-group">            </div>
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
                <th>Created Date</th>
                <th>Preparation Start Date</th>
                <th>Preparation End Date</th>
                <th>Sending Date</th>
                <th>Expected Return Date</th>

                <th></th>
            </tr>
            <?php
//            print_r($value);            exit;
            foreach ($value as $key) {
                $dist_rec_id = array('disrm_id' => $key['disrm_id']);
                $dis_no = $this->um->get_data('distribution_rawmaterial', $dist_rec_id, 'distribution', 'distribution_id', 'distribution_id', '', '', '');
                $rural_center_name = $dis_no[0]['ruralcenter_id'];
                $whererc = array('id' => $rural_center_name);
                $resultrc = $this->um->get_data('conf_ruralcenter', $whererc);
                ?>
                <tr>

                    <td><?php echo $resultrc[0]['center_name'] ?></td>
                    <td><?php echo $dis_no[0]['distribution_no'] ?></td>            
                    <td><?php echo date_format(date_create($key['created_at']), 'd-M-Y') ?></td>    
                    <td><?php echo date_format(date_create($key['prep_start_dt']), 'd-M-Y') ?></td>    
                    <td><?php echo date_format(date_create($key['prep_end_dt']), 'd-M-Y') ?></td>    
                    <td><?php echo date_format(date_create($key['send_date']), 'd-M-Y') ?></td>    
                    <td><?php echo date_format(date_create($key['exp_return_dt']), 'd-M-Y') ?></td>    

                    <td><a href="<?php echo base_url('home/rawdistribution') . '?disrm_id=' . $key['disrm_id'] ?>">Edit</a></td>
                </tr>
                <?php
            }
            ?> 
        </table>
    </div>
       <div class="col-ms-3 pull-right"> <a href="<?php echo base_url('home/rawdistribution_list') ?>" class="btn btn-primary">Complete Raw Distribution</a>
        <a href="<?php echo base_url('home/pending_rawdistribution_list') ?>" class="btn btn-primary">Pending Raw Distribution</a>

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
                <form class="form-inline" role="form" method="POST" id="search_distribution" action="<?php echo base_url('home/rawdistribution_wizard'); ?>">
                    <div class="form-group" style="width: 80%">
                        <label class="control-label ">Select RC Name:</label>

                        <input type="text" class="form-control" name="rc_name" id="rc_name">
                        <input type="hidden" class="form-control" name="rc_id" id="rc_id">                       

                    </div>  
                    <div class="form-group" style="width: 80%">
                        <label class="control-label " >Choose Distribution No:</label>

                        <select name="distribution_no" class="form-control" id="distribution_no" ></select>
<!--                        <input type="text" class="form-control" name="purchase_order" id="purchase_order" placeholder="Enter purchase order ">
                        <input type="hidden" class="form-control" name="purchase_order_id" id="purchase_order_id" placeholder="Enter invoice number">-->


                        <button type="button" id="submit_distribution" class="btn btn-primary">Submit</button>
                    </div>  
                </form>
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
                string += ' <option class="check_del" value="" >Please Select Distribution</option>';
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
        var invoice = $('#rc_id').val();

        if (invoice == 0) {
            return false;
        }
        else {
            $('#search_distribution').submit();
            return true;
        }
    });

</script>

