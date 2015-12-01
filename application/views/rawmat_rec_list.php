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
        <h3><b>Raw Material Receive List</b>
            <a  data-toggle="modal" data-target="#invoiceModal"  class="btn col-sm-3 " style="background-color: #85C51F; margin-right: 10px; padding: 4px; color: white; font-size: 20px; float: right"><b><span class="glyphicon glyphicon-plus"></span>Add Raw Material Received</b></a>
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
                <th>RM Receive Number</th>
                <th>PO Number</th>
                <th>PO Date</th>
                <th>Challan No.</th>
                <th>Challan Date</th>             

                <th></th>
            </tr>
            <?php
            foreach ($rawmat as $key) {
                ?>
                <tr>
                    <td><?php echo $key['rcv_number'] ?></td>
                    <td><?php echo $key['po_number'] ?></td>                 
                    <td><?php echo $key['po_date'] ?></td>                 
                    <td><?php echo $key['challan_number'] ?></td>                 
                    <td><?php echo $key['challan_date'] ?></td>                 
                    <td><a href="<?php echo base_url('rawmat_rec/add_rawmat') . '/' . $key['rmrcv_id'] ?>">View</a></td>
                </tr>
                <?php
            }
            ?> 
        </table>
    </div>
    <div class="col-sm-6">
        <?php //echo $page;   ?>
    </div>
</div>

<div id="invoiceModal" class="modal fade" role="dialog">
    <div class="modal-dialog">

        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title">Raw Material Receive</h4>
            </div>
            <div class="modal-body">
                <form class="form-inline" role="form" method="POST" id="search_invoice" action="<?php echo base_url('rawmat_rec/add_rawmat'); ?>">
                    <div class="form-group" style="width: 80%">
                        <label class="control-label " for="email">Select Supplier:</label>

                        <input type="text" class="form-control" name="supplier_name" id="supplier_name" placeholder="Enter supplier name">
                        <input type="hidden" class="form-control" name="supplier_id" id="supplier_id" placeholder="Enter invoice number">                       

                    </div>  
                    <div class="form-group" style="width: 80%">
                        <label class="control-label " for="email">Choose Purchase Order:</label>

                        <select name="purchase_order" class="form-control" id="purchase_order"></select>
<!--                        <input type="text" class="form-control" name="purchase_order" id="purchase_order" placeholder="Enter purchase order ">
                        <input type="hidden" class="form-control" name="purchase_order_id" id="purchase_order_id" placeholder="Enter invoice number">-->


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
    $(document).ready(function () {
        $('#click_search').on('click', function () {
            $('#search').toggle("slow");
        });
    });

    var pathArray = location.pathname.split('/');
    var loc7 = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';
    var url = loc7 + 'supplier_info';
    $('#supplier_name').autocomplete({
        source: url,
        minLength: 0,
        select: function (event, ui)
        {
            var p_id = ui.item.id;
            var name = ui.item.label;
            $('#supplier_name').val(name);
            $("#supplier_id").val(p_id);
            return false;
        }
    });
    $('#supplier_name').on('blur', function () {
        var id = $("#supplier_id").val();
        var link = loc7 + 'pur_order';
        $.ajax({
            type: "POST",
            url: link, //Relative or absolute path to response.php file
            data: 'id=' + id,
            dataType: 'json',
            success: function (data) {
                var i;
                var j = 0;
                var string = '';
                string += ' <option class="check_del" value="" >Please Select Branch</option>';
                var len = data.length;               
                for (i = 0; i < len; i++) {
                    string += '<option class="" value="' + data[j].rmpo_id + '">' + data[j].po_number + '</option>';
                    j = j + 1;
                }
                $('#purchase_order').append(string);
            }

        });
    });


$('#submit_invoice').on('click', function () {
        var invoice = $('#supplier_id').val();

        if (invoice == 0) {
            return false;
        }
        else {
            $('#search_invoice').submit();
            return true;
        }
    });
</script>

