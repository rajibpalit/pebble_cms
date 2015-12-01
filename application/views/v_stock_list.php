
<style type="text/css">
    .hide_this{
        display: none;
    }
    .sub_cancel{
        text-align: center;
        float: left;
        margin-left: 30%;
        margin-bottom: 20px

    }
</style>
<div class="container" style="background-color: white;min-height: 600px">
    <div class="title" style="border-bottom: 5px solid #E5E5E5;">
        <h3><b>Stock List</b></h3>
    </div>

    <input type="hidden" id="initilize_value1" value="1">
    <input type="hidden" id="array_size" value="<?php echo sizeof($stock); ?>">
    <div style="margin-top: 5%; margin-left: 15%;">
        <form class="form-horizontal" id="keyword_insert" role="form" method="post" action="<?php echo base_url('home/stock') ?>">

            <div style="float: left; width: 115%; margin-left: -15%;">
                <a href="<?php echo base_url('home/stock_entry_reconcile'); ?>" class="btn col-sm-2 btn-primary" style="float: right; margin-left: 10px;  margin-bottom: 10px;"><b><?php echo 'Stock Entry Reconcile' ?></b></a>                                                        
                <a href="<?php echo base_url('home/stock'); ?>" class="btn col-sm-2 btn-primary" style="float: right; margin-left: 20px;"><b><?php echo 'Add Stock' ?></b></a>
                <table class="table table-bordered" id="distribution_wozerd">
                    <tr class="list_header">
                        <th>Product Name</th>                       
                        <th>Product Number</th> 
                        <th>Color</th>
                        <th>Size</th>
                        <th style=" text-align: center;" >Quantity</th>
                        <th style=" text-align: center;">Last update date</th>
                    </tr>
                    <?php
                    if (isset($stock)) {
                        $i = 0;
                        foreach ($stock as $value) {
                            $this->db->select('id,product_name,color,size,code,default_rate');
                            $this->db->where('id=' . $value['product_id']);
                            $part_name = $this->db->get('conf_product')->result_array();

                            $this->db->select('keyword_value');
                            $this->db->where('keyword_id=' . $part_name[0]['color']);
                            $p_color = $this->db->get('conf_keyword')->result_array();
                            $this->db->select('keyword_value');
                            $this->db->where('keyword_id=' . $part_name[0]['size']);
                            $p_size = $this->db->get('conf_keyword')->result_array();
                            ?>
                            <tr>
                                <td><?php echo $part_name[0]['product_name'] ?> </td>
                                <td><?php echo $part_name[0]['code'] ?></td>
                                <td><?php echo $p_color[0]['keyword_value'] ?></td>
                                <td><?php echo $p_size[0]['keyword_value'] ?></td>
                                <td align="center"><?php echo $value['existing_qty'] ?></td>
                                <td align="center"><?php echo date_format(date_create($value['last_updated']), 'd-M-Y') ?></td>
                                <?php
                                $i++;
                            }
                        }
                        ?>
                    </tr>
                </table>
            </div>
            <div class="col-sm-6">
                <?php echo $page; ?>
            </div>
        </form>

    </div>

</div>


