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
        <h3><b>Packing List</b>
            <a data-toggle="modal" data-target="#invoiceModal"  class="btn col-sm-2 " style="background-color: #85C51F; margin-right: 10px; padding: 4px; color: white; font-size: 20px; float: right"><b><span class="glyphicon glyphicon-plus"></span>New Packing</b></a>
        </h3>
    </div>
    <div style="background-color: #E5E5E5; min-height: 50px">
        <!--            <a href="">Archive |</a>
                    <a href="">Delete</a>-->
        <button type="submit" class="btn col-sm-1 search" id="click_search"><b><span class="glyphicon glyphicon-search"></span> Search</b></button>
    </div>    
    <div id="search" class="search_div"> <!-- start search div -->
        <form class="form-inline" method="POST" action="<?php echo base_url('packing/bank') ?>"> <!--start search form -->
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
                <th>Packing Size</th>               
                <th>Box Number</th>
                <th>Created</th>

                <th></th>
            </tr>
            <?php
          
            foreach ($packings as $key) {
             
                $this->db->select('*');
                $this->db->where('client_id', $key['client_id']);
                $client_name = $this->db->get('conf_client')->result_array();/*Get cient name */              

                $this->db->select('keyword_value');
                $this->db->where('keyword_id', $key['pack_size']);
                $size_name = $this->db->get('conf_keyword')->result_array();/* Get size name*/
                
                                          
                
                ?>
                <tr>
                    <td><?php echo $key['inv_number'] ?></td>
                    <td><?php echo $client_name[0]['client_name'] ?></td>                 
                    <td><?php echo $size_name[0]['keyword_value'] ?></td>                 
                                 
                    <td><?php echo $key['box_number'] ?></td>                 
                    <td><?php echo $key['created_at'] ?></td>                 


                    <td><a href="<?php echo base_url('packing/edit_packing') . '/' . $key['pack_id'] ?>">Edit</a></td>
                </tr>
                <?php
            }
            ?> 
        </table>
    </div>
    <div class="col-sm-6">
        <?php //echo $page;  ?>
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

<!-- Modal -->
<div id="invoiceModal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title">Search Invoice</h4>
      </div>
      <div class="modal-body">
          <form class="form-inline" method="POST" id="search_invoice" action="<?php echo base_url('packing/edit_packing');?>">
            <div class="form-group" style="width: 80%">
                        <label class="control-label " for="email">Choose Your Invoice:</label>

                        <input type="text" class="form-control" name="invoice_name" id="inv_number" placeholder="Enter invoice number">
                        <input type="hidden" class="form-control" name="invoice_id" id="invoice_id" placeholder="Enter invoice number">

                        <button type="button" id="submit_invoice" class="btn btn-primary">Submit</button>
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
    
    
    var pathArray = location.pathname.split('/');
    var loc3 = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';
    var url = loc3 + 'get_invoice';
    $('#inv_number')
            .autocomplete({
                source: url,
                minLength: 0,
                select: function (event, ui)
                {
                    var p_id = ui.item.id;
                    var name = ui.item.label;
                    $('#inv_number').val(name);
                    $("#invoice_id").val(p_id);
                    return false;
                }
            });

    
$('#submit_invoice').on('click',function (){
    var invoice=$('#inv_number').val();
    
    if(invoice==0){
        return false;
    }
    else{
       $('#search_invoice').submit() ;
       return true;
    }
});
</script> 
