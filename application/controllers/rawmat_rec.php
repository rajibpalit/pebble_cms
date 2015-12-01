<?php

class Rawmat_rec extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->is_logged_in($this->session->userdata('logged_in'))) {
            redirect('login');
        }
        $this->load->model('user_model', 'um');
    }

    public function index() {
        $data['rawmat'] = $this->um->get_data('rawmreceive');
        $data['body'] = 'rawmat_rec_list';
        $this->load->view('element/main_temp', $data);
    }

    public function supplier_info() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->um->all_autocom($q, 'conf_supplier', 'supplier_name', 'id');
        }
    }

    public function pur_order() {
        $where = array('supplier_id' => $_POST['id']);
        $pur_order = $this->um->get_data('rawmpurchase', $where);
        echo json_encode($pur_order);
    }

    public function add_rawmat($param = FALSE) {
        if ($param != FALSE) {
            $where = array(
                'rmrcv_id' => $param
            );
            $data['rawmat_pur_edit'] = $this->um->get_data('rawmreceive', $where);
            $client_con = array('rmpo_id' => $data['rawmat_pur_edit'][0]['rmpo_id']);
            $data['client_info'] = $this->um->get_data('rawmpurchase', $client_con, 'conf_supplier', 'id', 'supplier_id');
            $data['rawmat_pur_product'] = $this->um->get_data('rawmreceive_raw', $where, 'conf_rawmaterial', 'id', 'rmporaw_id');
            $data['body'] = 'rawmat_rec_view';

        } else {
            $where = array('rmpo_id' => $this->input->post('purchase_order'));
            $data['rawmat_pur'] = $this->um->get_data('rawmpurchase', $where, 'conf_supplier', 'id', 'supplier_id');

            $prodwhere = array('rmpo_id' => $data['rawmat_pur'][0]['rmpo_id']);
            $data['rawmat_pur_product'] = $this->um->get_data('rawmpurchase_rawmaterial', $prodwhere, 'conf_rawmaterial', 'id', 'rawmaterial_id');

            $rwhere = array('type' => 'rmpo');
            $get_last_id = $this->um->get_data('confi_last_id', $rwhere);
            $value = $get_last_id[0]['value'] + 1;
            $len = strlen($value);
            $j = '';
            for ($i = $len; $i < 7; $i++) {
                $j .= '0';
            }
            $final_work_order = 'RPR' . $j . $value;

            $data['rawmat_pur'][0]['last'] = $final_work_order;
            $data['body'] = 'add_rawmat_rec';
        }


        $this->load->view('element/main_temp', $data);
    }

    public function rawmat_from() {
        $table = 'rawmreceive';
        if ($this->input->post('rmrcv_id')) {
            $date = strtotime($this->input->post('challan_date'));
            $challan_date = date('Y-m-d', $date);
            $where = array(
                'rmrcv_id' => $this->input->post('rmrcv_id')
            );
            $data = array(
                'challan_number' => $this->input->post('challan_no'),
                'challan_date' => $challan_date,
                'remarks' => $this->input->post('remarks'),
            );
            $this->um->update_data($table, $data, $where);
        } else {
            $date = strtotime($this->input->post('challan_date'));
            $challan_date = date('Y-m-d', $date);
            $data = array(
                'rcv_number' => $this->input->post('rawmat_rec_no'),
                'rmpo_id' => $this->input->post('rmpo_id'),
                'po_number' => $this->input->post('po_number'),
                'po_date' => $this->input->post('po_date'),
                'expected_delivery' => $this->input->post('delivery_date'),
                'challan_number' => $this->input->post('challan_no'),
                'challan_date' => $challan_date,
                'remarks' => $this->input->post('remarks'),
                'created_at' => date('Y-m-d')
            );
            $this->um->insert_data($table, $data);
        }
        redirect('rawmat_rec');
    }

    public function packing_product() {
        if (isset($_POST['rowsArray'])) {
            $last_id = $this->um->last_id('rmrcv_id', 'rawmreceive');
            $product = $_POST['rowsArray'];
            $final_array = array_chunk($product, 12);
            foreach ($final_array as $info) {
                $date = strtotime($info[10]);
                $expiry_date = date('Y-m-d h:i:s', $date);
                $data = array(
                    'rmrcv_id' => $last_id,
                    'rmporaw_id' => $info[11],
                    'received_qty' => $info[7],
                    'receive_qty' => $info[8],
                    'batch_no' => $info[9],
                    'expiry_date' => $expiry_date,
                );
                $this->um->insert_data('rawmreceive_raw', $data);

                $where = array('rawmaterial_id' => $info[11]);
                $stock = $this->um->get_data('stockrm', $where);
                if (count($stock) > 0) {
                    $total = $info[8] + $stock[0]['existing_qty'];
                    $condi = array('stockrm_id' => $stock[0]['stockrm_id']);
                    $update_data = array(
                        'existing_qty' => $total,
                        'last_updated' => date('Y-m-d h:i:s')
                    );
                    $this->um->update_data('stockrm', $update_data, $condi);
                } else {
                    $insert_data = array(
                        'rawmaterial_id' => $info[11],
                        'existing_qty' => $info[8],
                        'last_updated' => date('Y-m-d h:i:s')
                    );
                    $this->um->insert_data('stockrm', $insert_data);
                }

                echo 'ok';
            }
        }
    }

}
