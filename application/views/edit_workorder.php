<style type="text/css">
    .hide_this{
        display: none;
    }
    .form-group{
        width: 49%;
    }
    .form-group label{
        min-width: 30%;
    }
    .form-group .form-control{
        width: 65%!important;
        margin-top: 10px
    }
    td .form-control{
        width: 100%
    }
    .sub_cancel{
        text-align: center;
        float: left;
        margin-left: 45%;
        margin-bottom: 20px

    }
</style>
<div class="container" style="background-color: white;min-height: 600px">

    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>
                <?php echo (isset($workorder)) ? 'Work Order' : 'New Invoice' ?></b>

    </div> 
</h3>


<input type="hidden" id="initilize_value" value="<?php echo (isset($inv_product)) ? count($inv_product) : 1 ?>"/>
<div style="margin-top: 5%; margin-left: 2%;">
    <form class="form-inline" id="invoice_info" name="myform" method="POST" action="<?php echo base_url('workorder/workorder_from') ?>">

        <?php if (isset($workorder)) { ?>
            <input type="hidden" name="workorder_id" id="workorder_id" value="<?php echo $workorder[0]['workorder_id'] ?>"/>
        <?php } ?>
        <div class="form-group">
            <label for="workorder_no">Work Order No</label>
            <input type="text" class="form-control" id="workorder_no" readonly name="workorder_no" value="<?php echo (isset($workorder)) ? $workorder[0]['workorder_no'] : '' ?>" >

        </div>
        <div class="form-group">
            <label for="invoice_id*">Invoice No</label>
            <input type="text" class="form-control" id="invoice_id" value="<?php echo (isset($workorder)) ? $workorder[0]['inv_number'] : '' ?>" name="invoice_id" readonly>
        </div>

        <div class="form-group">
            <label for="remarks">Remarks</label>
            <textarea class="form-control" id="remarks" name="remarks" placeholder="Remarks"><?php echo (isset($workorder)) ? $workorder[0]['remarks'] : '' ?></textarea>
        </div>

        <?php if (isset($invoice) && empty($inv_id)) { ?>
            <div class="form-group">   
                <input type="submit" name="work_order" formaction="<?php echo base_url('workorder/save_workorder') ?>" id="work_order" value="Create Work Order" class="btn btn-success"/>
            </div>
        <?php } ?>

    </form>     
    <div style="margin-top: 50px "></div>
    <table class="table table-bordered" id="bank_table">
        <tr class="list_header">
            <th class="hide_this"></th>
            <th class="hide_this">Invoice Product ID</th>  
            <th>Product</th>
            <th>Color</th>
            <th>Size</th>
            <th>Order Quantity</th>
            <th>Stock Quantity</th>                
            <th>Work order Quantity</th>               
            <th>Remarks</th>

        </tr>

        <?php
            foreach ($invoice_product as $value) {
            $table = 'workorder_product';
            $where = array('inv_prod_id' => $value['inv_prod_id']);
            $this->db->where($where);
            $result = $this->db->get($table)->result_array();

            $this->db->select('keyword_value');
            $this->db->where('keyword_id', $value['color_id']);
            $coror_name = $this->db->get('conf_keyword')->result_array();

            $this->db->select('keyword_value');
            $this->db->where('keyword_id', $value['size_id']);
            $size_name = $this->db->get('conf_keyword')->result_array();
            
            
            ?>
            <tr>
                <td class="hide_this"><input type="hidden" id="id" value="<?php echo $result[0]['id'] ?>"/></td>             
                <td class="hide_this"><input type="text" name="" class="form-control " id="name_0" readonly value="<?php echo $result[0]['inv_prod_id'] ?>" /></td>
                <td><input type="text" name="" class="form-control" id="pname_0" readonly value="<?php echo $value['prod_name'] ?>" /></td>
                <td><input type="text" name="" class="form-control" id="color_0" readonly value="<?php echo $coror_name[0]['keyword_value'] ?>" /></td>
                <td><input type="text" name="" class="form-control" id="size_0" readonly value="<?php echo $size_name[0]['keyword_value'] ?>" /></td>
                <td><input type="text" name="" class="form-control" id="color_0" readonly value="<?php echo $result[0]['order_qty'] ?>" /></td>
                <td><input type="text" name="" class="form-control" id="stock_0" readonly value="<?php echo $result[0]['stock_qty'] ?>" /></td>
                <td><input type="text" name="" class="form-control" id="quanti_0" value="<?php echo $result[0]['wo_qty'] ?>"/></td>
                <td><input type="text" name="" class="form-control" id="remark_0" value="<?php echo $result[0]['remarks'] ?>" readonly/></td>
            </tr>        
<?php } ?>
    </table>

    <div class="sub_cancel">
        <input type="button" id="<?php echo (isset($inv_product)) ? 'update' : 'submit'; ?>" value="<?php echo (isset($inv_product)) ? 'Update' : 'Submit'; ?>" class="btn btn-primary"/>
        <a href="<?php echo base_url('workorder') ?>" class="btn btn-success">Cancel</a>
    </div>
</div>
</div>
<script type="text/javascript">

    var pathArray = location.pathname.split('/');
    var loc = window.location.origin + '/' + pathArray[1] + '/' + pathArray[2] + '/';

    $('#submit').on('click', function () {
        $('#invoice_info').submit();
        var rowsArray = {};
        var i = 0;
        $('#bank_table tr td input,#bank_table tr td select').each(function () {
            rowsArray[i] = $(this).val();
            i++;
        });

        var data_save = loc + 'save_info';

        $.ajax({
            type: 'post',
            url: data_save,
            data: {rowsArray: rowsArray},
            success: function (result) {

            }
        });
    });

</script>

<!--<script src="<?php echo base_url('assets/js/custom/add_invoice.js') ?>"></script>--> 
