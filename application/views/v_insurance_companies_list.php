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
        <h3><b>Insurance Companies List</b>
            <a href="<?php echo base_url('main/insurance_company'); ?>" class="btn col-sm-2 " id="add_new_btn" style=""><b><span class="glyphicon glyphicon-plus"></span>New Company</b></a>

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
            <div class="form-group" style="width: 100%;text-align: center;margin-top: 20px;margin-bottom: 20px">                
                <button type="submit" name="search" value="search" class="btn btn-default">Search</button>
                    <button type="reset" class="btn btn-default">Reset</button>                
            </div>
        </form><!-- end search form -->
    </div><!-- end search div -->
    
    <div>
        <table class="table table-striped">
            <tr class="list_header">
                <th>Company Name</th>
                <th>Address</th>
                <th>Country</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
            <?php
            foreach ($value as $company) {

                $this->db->select('keyword_value');
                $this->db->where('keyword_id',$company['country_id']);
                $country_name = $this->db->get('conf_keyword')->result_array();

                ?>
                <tr>
                    <td><?php echo $company['company_name'] ?></td>
                    <td><?php echo $company['address'] ?></td>
                    <td><?php echo $country_name[0]['keyword_value'] ?></td>
                    <td><?php echo ($company['status']==1)?"Active":"Inactive"?></td>
                    <td><a href="<?php echo base_url('main/insurance_company').'/'.$company['id']?>">Edit</a></td>
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
<script>
$(document).ready(function(){
    $('#click_search').on('click',function(){
        $('#search').toggle("slow");
    });
});
</script>
    
