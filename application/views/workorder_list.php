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
        <h3><b>Complete Work Order List</b>
            <!--<a href="<?php echo base_url('workorder/add_workorder'); ?>" class="btn col-sm-2 " style="background-color: #85C51F; margin-right: 10px; padding: 4px; color: white; font-size: 20px; float: right"><b><span class="glyphicon glyphicon-plus"></span>New Work Order</b></a>-->
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
            <div class="form-group">           </div>
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
            <?php foreach ($workorder as $key) { ?>    
                <tr>
                    <td><?php echo $key['workorder_no'] ?></td>
                    <td><a href="<?php echo base_url('home/add_invoice') . '/' . $key['invoice_id'] ?>"><?php echo $key['inv_number'] ?></a></td>                 
                    <td><?php echo date('Y-m-d', $key['created_at']) ?></td>

                    <td><a href="<?php echo base_url('workorder/edit_workorder') . '/' . $key['workorder_id'] ?>">Edit</a></td>
                </tr>
                <?php
            }
            ?> 
        </table>
    </div>
    <div class="col-ms-3 pull-right"> <a href="<?php echo base_url('workorder') ?>" class="btn btn-primary">Complete Workorder</a>
        <a href="<?php echo base_url('pending_workorder') ?>" class="btn btn-primary">Pending Workorder</a>

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
<script>
    $(document).ready(function () {
        $('#click_search').on('click', function () {
            $('#search').toggle("slow");
        });
    });
</script>

