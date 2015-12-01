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
        <h3><b>Supplier List</b>
            <a href="<?php echo base_url('rawmatsupp/add_romat_supp'); ?>" class="btn col-sm-3 " id="add_new_btn" style=""><b><span class="glyphicon glyphicon-plus"></span>Add Raw Material Supplier</b></a>
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
                <th>Name</th>
                <th>Address</th>
                <th>Phone</th>
                <th>Email</th>             
                <th>Fax</th>             
                <th>Web address</th>
                <th></th>
            </tr>
            <?php
          foreach ($suppliers as $key) { ?>
              
                <tr>
                    <td><?php echo $key['supplier_name'] ?></td>
                    <td><?php echo $key['address'] ?></td>                 
                    <td><?php echo $key['phone_no'] ?></td>                 
                    <td><?php echo $key['email'] ?></td>                 
                    <td><?php echo $key['fax'] ?></td>                 
                    <td><?php echo $key['webaddress'] ?></td>                                                                    
                    <td><a href="<?php echo base_url('rawmatsupp/add_romat_supp') . '/' . $key['id'] ?>">Edit</a></td>
                </tr>
                <?php
            }
          ?> 
        </table>
    </div>
    <div class="col-sm-6">
        <?php //echo $page;  ?>
    </div>
</div>
<script>
    $(document).ready(function () {
        $('#click_search').on('click', function () {
            $('#search').toggle("slow");
        });
    });
</script>

