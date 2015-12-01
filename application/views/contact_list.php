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
        <h3><b>Contact List</b>
            <a href="<?php echo base_url('main/contact'); ?>" class="btn col-sm-2 " id="add_new_btn" style=""><b><span class="glyphicon glyphicon-plus"></span> New Contact</b></a>
        </h3>
    </div>
    <div style="background-color: #E5E5E5; min-height: 50px">
        <!--            <a href="">Archive |</a>
                    <a href="">Delete</a>-->
        <button type="submit" class="btn col-sm-1 search" id="click_search"><b><span class="glyphicon glyphicon-search"></span> Search</b></button>
    </div>    
    <div id="search" class="search_div"> <!-- start search div -->
        <form class="form-inline" method="POST" action="<?php echo base_url('main/contact') ?>"> <!--start search form -->
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
<!--                <th><label>
                        <input type="checkbox" value="">
                    </label></th>-->
                <th>Contact Type</th>
                <th>Name</th> 
                <th>Email</th><!-- First Name + Last Name  -->
                <th>Mobile No.</th>
                <th>Status</th>
                <th></th>
            </tr>
            <?php
            foreach ($value as $currency) {
                ?>
                <tr>
                    <td><?php echo $currency['contact_type'] ?></td>
                    <td><?php echo $currency['first_name'] . ' ' . $currency['last_name'] ?></td>
                    <td><?php echo $currency['email'] ?></td>
                    <td><?php echo $currency['cell_no'] ?></td>
                    <td><?php echo ($currency['status']) == 1 ? 'Active' : 'Inactive' ?></td>
                    <td><a href="<?php echo base_url('main/contact') . '/' . $currency['contact_id'] ?>">Edit</a></td>
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
<script>
    $(document).ready(function () {
        $('#click_search').on('click', function () {
            $('#search').toggle("slow");
        });
    });
</script>

