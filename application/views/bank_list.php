<style>
    .form-group{
        width: 49%;
        margin-top: 15px;
    }
    .form-group label{
        min-width: 100px;
    }
</style>
<div class="container list_content">
    <div class="title list_title">
        <h3><b>Bank List</b>
            <a  data-toggle="modal" data-target="#rcModal"  class="btn col-sm-2 " id="add_new_btn" style=""><b><span class="glyphicon glyphicon-plus"></span> New Bank</b></a>
        </h3>
    </div>
    <div style="background-color: #E5E5E5; min-height: 50px">
        <!--            <a href="">Archive |</a>
                    <a href="">Delete</a>-->
        <button type="submit" class="btn col-sm-1 search" id="click_search"><b><span class="glyphicon glyphicon-search"></span> Search</b></button>
    </div>    
    <div id="search" class="search_div"> <!-- start search div -->
        <form class="form-inline" method="POST" action="<?php echo base_url('main/bank') ?>"> <!--start search form -->
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
                <th>Bank Name</th>
                <th>Address</th>
                <th>Status</th>
                <th></th>
            </tr>
            <?php
            foreach ($value as $key) {
                ?>
                <tr>
                    <td><?php echo $key['bank_name'] ?></td>
                    <td><?php echo $key['address'] ?></td>                 
                    <td><?php
                        if ($key['status'] == 1) {
                            echo "Active";
                        } else {
                            echo "Inactive";
                        }
                        ?></td>
                    <td><a href="javascript:void(0)" onclick="get_bank(<?php echo $key['id'] ?>)" >Edit</a></td>
                </tr>
                <?php
            }
            ?> 
        </table>
    </div>
    <div class="col-sm-6">
        <?php echo $page; ?>
    </div>
    <!--    <div style="float: right;">
            <a href="">Active |</a>
            <a href="">Archive |</a>
            <a href="">Delete</a>
        </div>-->
</div>


<div id="rcModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Bank Name and Address</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline" role="form" method="POST" id="bank_info" action="<?php echo base_url('bank/add_bank'); ?>">
                    <div class="form-group" style="width: 80%">
                        <label class="control-label ">Bank Name:</label>

                        <input type="text" class="form-control" name="bank_name" id="bank_name">


                    </div>

                    <div class="form-group" style="width: 80%">
                        <label class="control-label " >Address:</label>
                        <textarea  name="address" id="address"></textarea>
                    </div>
                </form>
            </div>
            <center> 
                <button type="button" id="submit" class="btn btn-primary">Save</button>
                <input type="reset" value="Reset" class="btn btn-default"/>
            </center>
            <div class="modal-footer">
                <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
        </div>

    </div>
</div>
<div id="edit_bank" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Add Bank Name and Address</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline" role="form" method="POST" id="update_bank_info" action="<?php echo base_url('bank/update_bank'); ?>">
                    <div class="form-group" style="width: 80%">
                        <input type="hidden" class="form-control" name="bank_id" id="bank_id">
                        <label class="control-label ">Bank Name:</label>

                        <input type="text" class="form-control" name="bank_name" id="bank_name">


                    </div>

                    <div class="form-group" style="width: 80%">
                        <label class="control-label " >Address:</label>
                        <textarea  name="address" id="address"></textarea>
                    </div>
                </form>
            </div>
            <center> 
                <button type="button" id="update_bank" class="btn btn-primary">Save</button>
                <input type="reset" value="Reset" class="btn btn-default"/>
            </center>
            <div class="modal-footer">
                <button type="button"  class="btn btn-default" data-dismiss="modal">Close</button>
            </div>
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

    $('#submit').on('click', function () {
        $('#bank_info').submit();
    });

    function get_bank(value) {
        var pathArray = location.pathname.split('/');
        var loc = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';

        var data_save = loc + 'get_bank';
        $.ajax({
            type: 'post',
            url: data_save,
            dataType: "json",
            data: 'id=' + value,
            success: function (result) {
                
               $('#edit_bank #bank_id').val(result[0]['id']);
               $('#edit_bank #bank_name').val(result[0]['bank_name']);
               $('#edit_bank #address').text(result[0]['address']);
               $('#edit_bank').modal('show');
                
            }
        });
    }
    $('#update_bank').on('click', function () {
        $('#update_bank_info').submit();
    });
</script>


