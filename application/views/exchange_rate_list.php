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
        <h3><b>Exchange Rates List</b>
            <a href="<?php echo base_url('main/exchange_rate'); ?>" class="btn col-sm-2 " id="add_new_btn" style=""><b><span class="glyphicon glyphicon-plus"></span>Exchange Rate</b></a>

        </h3>
    </div>
    <div style="background-color: #E5E5E5; min-height: 50px">
        <!--            <a href="">Archive |</a>
                    <a href="">Delete</a>-->
        <button type="submit" class="btn col-sm-1 search" id="click_search"><b><span class="glyphicon glyphicon-search"></span> Search</b></button>
    </div>    
    <div id="search" class="search_div"> <!-- start search div -->
        <form class="form-inline" method="POST" action="<?php echo base_url('main/list_keyword')?>"> <!--start search form -->
            <div class="form-group">
                <label for="keyword_for">Keyword For</label>
                <input type="text" class="form-control" name="keyword_for" id="keyword_for" placeholder="Keyword For">
            </div>
            <div class="form-group">
                <label for="keyword_value">Keyword Value</label>
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
                <th>Currency From</th>
                <th>Currency To</th>
                <th>Rate</th>
                <th>Date</th>
                <th>Status</th>
                <th></th>
            </tr>
            <?php
            $counter = 0;
            foreach ($value as $exchange_rate) {
                ?>
                <tr>
                    <td><?php echo $exchange_rate['currency_name'] ?></td>
                    <td><?php echo $value1[$counter]['currency_name'] ?></td>
                    <td><?php echo $exchange_rate['exchange_rate'] ?></td>
                    <td><?php echo $exchange_rate['exchange_date'] ?></td>
                    <td><?php  if($exchange_rate['status'] == 1){echo "Active";}else{echo "Inactive";} ?></td>
                    <td><a href="<?php echo base_url('main/exchange_rate') . '/' . $exchange_rate['exchange_id'] ?>">Edit</a></td>
                </tr>
                <?php
                $counter++;
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
$(document).ready(function(){
    $('#click_search').on('click',function(){
        $('#search').toggle("slow");
    });
});
</script>
    
