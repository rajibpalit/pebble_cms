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
        <h3><b>Pending Distribution  List</b>
            <a  data-toggle="modal" data-target="#rcModal"  class="btn col-sm-3 " style="background-color: #85C51F; margin-right: 10px; padding: 4px; color: white; font-size: 20px; float: right"><b><span class="glyphicon glyphicon-plus"></span>Add Distribution </b></a>
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
            <!--            <div class="form-group">
                            <label for="status">Status</label>
                            <input type="text" class="form-control" name="status" id="status" placeholder="Status">
                        </div>-->
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
                <th>Work Order No</th>
                <th>Invoice ID</th>
                <th>Created Date</th>               
                <th></th>
            </tr>
            <?php
            foreach ($workorder as $key) {
//                print_r($workorder);                exit;
                $this->db->select('*');
                $this->db->where('workworder_id', $key['workorder_id']);
                $dis_value = $this->db->get('distribution')->result_array();
                if (!$dis_value) {
                    ?>
                    <tr>
                        <td><?php echo $key['workorder_no'] ?></td>
                        <td><?php echo $key['inv_number'] ?></a></td>                 
                        <td><?php echo date('Y-m-d', $key['created_at']) ?></td>
                        <td><a href="<?php echo base_url('home/distribution_wizard') . '/' . $key['workorder_id'] ?>">Create</a></td>
                    </tr>
                    <?php
                }
            }
            ?> 
        </table>
    </div>
    <div class="col-ms-3 pull-right"> <a href="<?php echo base_url('home/distribution_list') ?>" class="btn btn-primary">Complete Distribution</a>
        <a href="<?php echo base_url('home/pending_distribution_list') ?>" class="btn btn-primary">Pending Distribution</a>

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
                <h4 class="modal-title"> Workorder Number</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline" role="form" method="POST" id="search_wo" action="<?php echo base_url('home/distribution_wizard'); ?>">
                    <div class="form-group" style="width: 80%">
                        <label class="control-label required ">Select Workorder Number:</label>

                        <input type="text"  style="margin-left:21px;" class="form-control" name="wo_no" id="wo_no">
                        <input type="hidden" class="form-control" name="wo_id" id="wo_id">                       

                    </div>  
                    <div class="form-group" style="width: 80%">
                        <label class="control-label " > Invoice Number:</label>
                        <input type="text" style="margin-left:86px;" readonly class="form-control" name="inv_no" id="inv_no">
                        <input type="hidden" class="form-control" name="inv_id" id="inv_id">    
                        <button type="button" id="submit_wo" class="btn btn-primary">Submit</button>
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

    var url = '<?php echo base_url('home/get_wo_no') ?>';
    $('#wo_no').autocomplete({
        source: url,
        minLength: 0,
        select: function (event, ui)
        {
            var wo_id = ui.item.id;
            var wo_no = ui.item.label;
            $("#wo_no").val(wo_no);
            $("#wo_id").val(wo_id);
            return false;
        }
    });
    $('#wo_no').on('blur', function () {
        var id = $("#wo_id").val();
        var url = '<?php echo base_url('home/get_invoice_no') ?>';
        $.ajax({
            type: "POST",
            url: url, //Relative or absolute path to response.php file
            data: 'id=' + id,
            dataType: 'json',
            success: function (data) {
                console.log(data[0]['inv_number']);
                $('#inv_no').val(data[0]['inv_number']);
                $('#inv_id').val(data[0]['inv_id']);
            }

        });
    });

    $('#submit_wo').on('click', function () {
        var invoice = $('#wo_id').val();

        if (invoice == 0) {
            return false;
        }
        else {
            $('#search_wo').submit();
            return true;
        }
    });
</script>

