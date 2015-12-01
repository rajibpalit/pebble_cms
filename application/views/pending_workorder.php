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
        <h3><b>Pending Work Order List</b>

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
                <th>Invoice Number</th>
                <th>Client Name</th>
                <th>Currency</th>
                <th>PO Number</th>
                <th>Account Number</th>
                <th>Total</th>
                <th>After Discount</th>
                <th></th>
            </tr>
            <?php
            foreach ($invoice as $key) {


                $this->db->select('*');
                $this->db->where('invoice_id', $key['inv_id']);
                $info = $this->db->get('workorder')->result_array();

                if (!$info) {


                    if ($key['discount_type'] == 1) {
                        $d_sum = $key['total_value'] - $key['discount_value'];
                    } else {
                        $d_sum = ($key['discount_value'] / 100) * $key['total_value'];
                        $d_sum = $key['total_value'] - $d_sum;
                    }
                    ?>
                    <tr>
                        <td><?php echo $key['inv_number'] ?></td>
                        <td><?php echo $key['client_name'] ?></td>                 
                        <td><?php echo $key['currency_name'] ?></td>                 
                        <td><?php echo $key['po_number'] ?></td>                 
                        <td><?php echo $key['ac_number'] ?></td>                 
                        <td><?php echo $key['total_value'] ?></td>                 
                        <td><?php echo $d_sum ?></td>                 

                        <td><a href="<?php echo base_url('pending_workorder/add_workorder') . '/' . $key['inv_id'] ?>">Create</a></td>
                    </tr>
                    <?php
                }
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

