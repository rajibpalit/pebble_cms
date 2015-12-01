
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
        <h3><b>Raw Material Stock Entry List</b></h3>
    </div>

    <input type="hidden" id="initilize_value1" value="1">
    <input type="hidden" id="array_size1" value="<?php echo sizeof($stockrm); ?>">
    <div style="margin-top: 5%; margin-left: 15%;">
        <form class="form-horizontal" id="keyword_insert" role="form" method="post" action="<?php echo base_url('main/add_currency') ?>">

            <div style="float: left; width: 115%; margin-left: -15%;">

                <a href="<?php echo base_url('home/raw_mat_reconcile'); ?>" class="btn col-sm-2 btn-primary" style="float: right; margin-left: 10px;  margin-bottom: 10px;"><b><?php echo 'Stock Entry Reconcile' ?></b></a>                                                        
                <a href="<?php echo base_url('home/raw_material_stock_entry'); ?>" class="btn col-sm-2 btn-primary" style="float: right; margin-left: 20px;"><b><?php echo 'Add Raw Material Stock' ?></b></a>
                <table class="table table-bordered" id="distribution_wozerd">
                    <tr class="list_header">
                        <th>Material Name</th>                       
                        <th>Material Number</th> 
                        <th>Color</th>
                        <th>Size</th>
                        <th>MU</th>
                        <th style=" text-align: center;">Quantity</th>
                        <th style=" text-align: center;">Last update date</th>
                    </tr>
                    <?php
                    if (isset($stockrm)) {
                        $i = 0;
                        foreach ($stockrm as $value) {
                            $this->db->select('id,material_name,material_code,material_type_id,color_id,size_id,m_unit_id');
                            $this->db->where('id=' . $value['rawmaterial_id']);
                            $part_name = $this->db->get('conf_rawmaterial')->result_array();
                            $this->db->select('keyword_value');
                            $this->db->where('keyword_id=' . $part_name[0]['color_id']);
                            $p_color = $this->db->get('conf_keyword')->result_array();
                            $this->db->select('keyword_value');
                            $this->db->where('keyword_id=' . $part_name[0]['size_id']);
                            $p_size = $this->db->get('conf_keyword')->result_array();
                            $this->db->select('keyword_value');
                            $this->db->where('keyword_id=' . $part_name[0]['m_unit_id']);
                            $p_mu = $this->db->get('conf_keyword')->result_array();
                            ?>
                            <tr>
                                <td><?php echo $part_name[0]['material_name'] ?> </td>
                                <td><?php echo $part_name[0]['material_code'] ?></td>
                                <td><?php echo $p_color[0]['keyword_value'] ?></td>
                                <td><?php echo $p_size[0]['keyword_value'] ?></td>
                                <td><?php echo $p_mu[0]['keyword_value'] ?></td>
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

