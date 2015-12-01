<?php

class Rawmat_pur extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->is_logged_in($this->session->userdata('logged_in'))) {
            redirect('login');
        }
        $this->load->model('user_model', 'um');
    }

    public function index() {
        $data['body'] = 'rawmat_list';
        $data['rawmat'] = $this->um->get_data('rawmpurchase', false, 'conf_supplier', 'id', 'supplier_id');
        $this->load->view('element/main_temp', $data);
    }

    public function add_rm_pur($id = FALSE) {

        $supplier_con = array('status' => 1);
        $data['suppliers'] = $this->um->get_data('conf_supplier', $supplier_con);
        if ($id != false) {
            $where = array('rmpo_id' => $id);
            $data['rawmat_pur'] = $this->um->get_data('rawmpurchase', $where);
            $data['rawmat_pur_product'] = $this->um->get_data('rawmpurchase_rawmaterial', $where, 'conf_rawmaterial', 'id', 'rawmaterial_id');
        }
        $data['body'] = 'add_rawmat_pur';
        $this->load->view('element/main_temp', $data);
    }

    public function get_supplier() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $where = array(
                'id' => $id
            );
            $result = $this->um->get_data('conf_supplier', $where);
            $rwhere = array('type' => 'rmpo');
            $rmpo = $this->um->get_data('confi_last_id', $rwhere);
            $result[0]['last_rmpo'] = $rmpo[0]['value'];
            echo json_encode($result[0]);
        }
    }

    public function product_info() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $where = array('supplier_id' => $_GET['id']);
            $this->um->all_autocom_con($q, 'conf_supplier_rawmaterial', 'material_name', 'id', $where, 'conf_rawmaterial', 'id', 'material_id');
        }
    }

    public function rawmat_from() {
        $date = strtotime($this->input->post('delivery_date'));
        $delivery = date('Y-m-d', $date);
        if ($this->input->post('rmpo_id')) {
            $data = array(
               
                'supplier_id' => $this->input->post('supplier'),
                'address' => $this->input->post('address'),
                'email' => $this->input->post('email'),
                'contact_no' => $this->input->post('contact_no'),
                'expected_delivery' => $delivery,
                'remarks' => $this->input->post('remarks'),
               
            );
            $where = array('rmpo_id' => $this->input->post('rmpo_id'));
            $this->um->update_data('rawmpurchase', $data,$where);
        } else {
            $data = array(
                'po_number' => $this->input->post('invoice_number'),
                'supplier_id' => $this->input->post('supplier'),
                'address' => $this->input->post('address'),
                'email' => $this->input->post('email'),
                'contact_no' => $this->input->post('contact_no'),
                'expected_delivery' => $delivery,
                'remarks' => $this->input->post('remarks'),
                'created_at' => date('Y-m-d')
            );
            $this->um->insert_data('rawmpurchase', $data);

            $where = array('type' => 'rmpo');
            $get_last_id = $this->um->get_data('confi_last_id', $where);
            $last_value = array('value' => $get_last_id[0]['value'] + 1);
            $this->um->insert_data('confi_last_id', $last_value, $where);
        }

        redirect('rawmat_pur');
    }

    public function all_produt_info() {
        if (isset($_POST['name'])) {
            $hwhere = array(
                'id' => $_POST['name']
            );
            $data = $this->um->get_data('conf_rawmaterial', $hwhere, 'conf_keyword', 'keyword_id', 'color_id');
            $where = array(
                'keyword_id' => $data[0]['size_id']
            );
            $size = $this->um->get_data('conf_keyword', $where);
            $mwhere = array(
                'keyword_id' => $data[0]['m_unit_id']
            );
            
            $pro_quenty=array(
                'rawmaterial_id'=> $_POST['name']
                );
            $product_stock=  $this->um->get_data('stockrm',$pro_quenty);
            $data[0]['stock']=$product_stock[0]['existing_qty'];
            $mu_name = $this->um->get_data('conf_keyword', $mwhere);
            $data[0]['mu_name'] = $mu_name[0]['keyword_value'];
            $data[0]['size_name'] = $size[0]['keyword_value'];
            echo json_encode($data[0]);
        }
    }

    public function packing_product() {
        if (isset($_POST['rowsArray'])) {
            $last_id = $this->um->last_id('rmpo_id', 'rawmpurchase');
            $product = $_POST['rowsArray'];
            $final_array = array_chunk($product, 13);
            foreach ($final_array as $info) {
                $data = array(
                    'rawmaterial_id' => $info[1],
                    'rmpo_id' => $last_id,
                    'origin' => $info[7],
                    'stock_qty' => $info[8],
                    'order_qty' => $info[9],
                    'unit_price' => $info[10],
                    'total_amount' => $info[11]
                );
                $this->um->insert_data('rawmpurchase_rawmaterial', $data);

                echo 'ok';
            }
        }
    }

    public function packing_product_update() {
        if (isset($_POST['rowsArray'])) {
            $product = $_POST['rowsArray'];
            $final_array = array_chunk($product, 14);
            foreach ($final_array as $info) {
                $data = array(
                    'rawmaterial_id' => $info[1],
                    'origin' => $info[7],
                    'stock_qty' => $info[8],
                    'order_qty' => $info[9],
                    'unit_price' => $info[10],
                    'total_amount' => $info[11]
                );
                $where = array('id' => $info[13]);
                $this->um->update_data('rawmpurchase_rawmaterial', $data, $where);

                echo 'ok';
            }
        }
    }

}
