<?php

class Home extends CI_Controller {

    public function __construct() {
        parent::__construct();
        if (!$this->is_logged_in($this->session->userdata('logged_in'))) {
            redirect('login');
        }
        $this->load->model('user_model', 'um');
    }

    public function index() {
        $data['body'] = 'home';
        $this->load->view('element/main_temp', $data);
    }

    /* function for list inovice by Akbor */

    public function invoice() {
        $url = base_url('home/invoice');
        $where = array();
        $limit = $this->limit;
        if ($this->uri->segment(3) == 'null') {
            $start = 0;
        } else {
            $start = $this->uri->segment(3);
        }
        $data['body'] = 'invoice_list';
        $where = array('status' => 1);
//        $data['invoice'] = $this->um->get_data('v_invoice', $where);
        $order_field = 'inv_id';
        $order = 'desc';
        $data['invoice'] = $this->um->get_data('v_invoice', $where, '', '', '', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('v_invoice', $where);
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $this->load->view('element/main_temp', $data);
    }

    /* function for add inovice by Akbor */

    public function add_invoice($id = false) {
        $data['body'] = 'add_invoice';
        $where = array('status' => 1);
        $data['banks'] = $this->um->get_data('conf_bank', $where);
        if ($id != false) {
            $swhere = array('inv_id' => $id);
            $invoice = $this->um->get_data('v_invoice', $swhere);
            $data['invoice'] = $invoice;
            $inv_id = array('invoice_id' => $invoice[0]['inv_id']);
            $data['inv_product'] = $this->um->get_data('invoice_product', $inv_id);
            $wherework = array('invoice_id' => $invoice[0]['inv_id']);
            $data['inv_id'] = $this->um->get_data('workorder', $wherework);
        }
        $this->load->view('element/main_temp', $data);
    }

    function get_client() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->um->all_autocom($q, 'conf_client', 'client_name', 'client_id');
        }
    }

    public function get_client_info() {
        if (isset($_POST['name'])) {
            $where = array(
                'client_name' => $_POST['name']
            );
            $info = $this->um->get_data('conf_client', $where);
            $client_id = $info[0]['client_id'];
            $where_client = array('client_id' => $client_id);
            $pre_invoice = $this->um->get_data('invoice', $where_client);

            if (count($pre_invoice) > 0) {
                $info[0]['old_invoice'] = $pre_invoice[0]['inv_number'];
            } else {
                $info[0]['old_invoice'] = 0;
            }
            $swhere = array('currency_id' => $info[0]['currency']);
            $data = $this->um->get_data('conf_currency', $swhere);
            $info[0]['currency_name'] = $data[0]['currency_name'];
            echo json_encode($info[0]);
        }
    }

    public function get_invoice() {

        if (isset($_POST['name'])) {
            $hwhere = array('workorder_no' => $_POST['name']);
            $data = $this->um->get_data('workorder', $hwhere, 'invoice', 'inv_id', 'invoice_id');
            $where = array('workorder_id' => $data[0]['workorder_id']);
//            print_r($where);exit;
            $data1 = $this->um->get_data('workorder_product', $where, 'invoice_product', 'inv_prod_id', 'inv_prod_id');
//                print_r($data1);exit;
            echo json_encode($data1);
        }
    }

    public function all_produt_info() {
        if (isset($_POST['name'])) {
            $hwhere = array(
                'product_name' => $_POST['name']
            );
            $data = $this->um->get_data('conf_product', $hwhere, 'conf_keyword', 'keyword_id', 'color');
            $where = array(
                'keyword_id' => $data[0]['size']
            );
            $size = $this->um->get_data('conf_keyword', $where);
            $data[0]['size_name'] = $size[0]['keyword_value'];
//            print_r($data);
            echo json_encode($data[0]);
        }
    }

    public function all_raw_mat_info() {
        if (isset($_POST['name'])) {
            $hwhere = array(
                'material_name' => $_POST['name']
            );
            $data = $this->um->get_data('conf_rawmaterial', $hwhere, 'conf_keyword', 'keyword_id', 'color_id');
            $where = array(
                'keyword_id' => $data[0]['size_id']
            );
            $size = $this->um->get_data('conf_keyword', $where);
            $data[0]['size_name'] = $size[0]['keyword_value'];
            $where = array(
                'keyword_id' => $data[0]['m_unit_id']
            );
            $mu_name = $this->um->get_data('conf_keyword', $where);
            $data[0]['mu_name'] = $mu_name[0]['keyword_value'];
            echo json_encode($data[0]);
        }
    }

    public function product_info() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->um->all_autocom1($q, 'conf_product', 'product_name', 'id');
        }
    }

    public function raw_mat_reconcile() {
        $data['body'] = 'raw_mat_reconcile';
        $data['stockrm'] = $this->um->get_data('stockrm');
        $this->load->view('element/main_temp', $data);
    }

    public function raw_mat_info() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->um->all_autocom2($q, 'conf_rawmaterial', 'material_name', 'id');
        }
    }

    public function update_and_insert_stockrm() {
        if (isset($_POST['rowsArray'])) {
            $stock = $_POST['rowsArray'];
            $final_array = array_chunk($stock, 12);
            foreach ($final_array as $info) {
                if ($info[11]) { //check new stockrm_id
                    if ($info[7]) { //check new new quantity value assine
                        $data = array(
                            'rawmaterial_id' => $info[11],
                            'existing_qty' => $info[7],
                            'last_updated' => $info[8],
                            'remarks' => $info[9]
                        );
                        $this->um->insert_data('stockrm', $data);
                    } else {
                        $data = array(
                            'rawmaterial_id' => $info[11],
                            'existing_qty' => $info[5],
                            'last_updated' => $info[8],
                            'remarks' => $info[9]
                        );
                        $this->um->insert_data('stockrm', $data);
                    }
                } else {
                    if ($info[7]) {
                        $where['stockrm_id'] = $info[10];
                        $data = array(
                            'existing_qty' => $info[7],
                            'last_updated' => $info[8],
                            'remarks' => $info[9]
                        );
                        $this->um->update_data('stockrm', $data, $where);
                    } else {
                        $where['stockrm_id'] = $info[10];
                        $data = array(
                            'existing_qty' => $info[5],
                            'last_updated' => $info[8],
                            'remarks' => $info[9]
                        );
                        $this->um->update_data('stockrm', $data, $where);
                    }
                }
            }
        }
        echo 'sucess';
    }

    public function raw_mat_stock_list() {
        $url = base_url('home/raw_mat_stock_list');
        $where = array();
        $limit = $this->limit;
        if ($this->uri->segment(3) == 'null') {
            $start = 0;
        } else {
            $start = $this->uri->segment(3);
        }
        if ($this->input->post('search')) {
            if ($this->input->post('keyword_for')) {
                $where['key_name'] = $this->input->post('keyword_for');
            }
            if ($this->input->post('keyword_value')) {
                $where['keyword_value'] = $this->input->post('keyword_value');
            }
            if ($this->input->post('status')) {
                $where['status'] = $this->input->post('status');
            }
        }
        $order_field = 'stockrm_id';
        $order = 'desc';
        $data['body'] = 'raw_material_stock_entry_list';
        $data['stockrm'] = $this->um->get_data('stockrm', '', '', '', '', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('stockrm');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $this->load->view('element/main_temp', $data);
    }

    public function stock_entry_reconcile() {
        $data['body'] = 'stock_entry_reconcile';
        $data['stock'] = $this->um->get_data('stock');
        $this->load->view('element/main_temp', $data);
    }

    /* save all information form table to database */

    public function save_info() {
        if (isset($_POST['rowsArray'])) {
            $last_id = $this->um->last_id('inv_id', 'invoice');
            $product = $_POST['rowsArray'];
            $final_array = array_chunk($product, 10);

            foreach ($final_array as $info) {
                $data = array(
                    'invoice_id' => $last_id,
                    'prod_name' => $info[0],
                    'prod_id' => $info[1],
                    'color_id' => $info[3],
                    'size_id' => $info[5],
                    'quantity' => $info[6],
                    'unit_price' => $info[7],
                    'line_total' => $info[8],
                    'status' => 1
                );

                $this->um->insert_data('invoice_product', $data);
            }
        }
        echo 'sucess';
    }

    public function raw_material_stock_entry() {
        $data['body'] = 'raw_material_stock_entry';
        $data['stockrm'] = $this->um->get_data('stockrm');
        $this->load->view('element/main_temp', $data);
    }

    public function stock() {
        $data['body'] = 'v_stock';
        $data['stock'] = $this->um->get_data('stock');
        $this->load->view('element/main_temp', $data);
    }

    public function save_stock() {
//        $info = $_POST['name'];
        $data = array();
        $stock = explode(" ", $_POST['name']);
        $stock_id = $stock['0'];
        $data['existing_qty'] = $stock['1'];
        $data['last_updated'] = $stock['2'];
        $where['stock_id'] = $stock_id;
        $this->um->update_data('stock', $data, $where);
//        redirect('home/stock');
//        echo '<pre>';
//        print_r($data);
//        echo '</pre>';
//        exit;
    }

    public function stock_list() {
        $url = base_url('home/stock_list');
        $where = array();
        $limit = $this->limit;
        if ($this->uri->segment(3) == 'null') {
            $start = 0;
        } else {
            $start = $this->uri->segment(3);
        }
        if ($this->input->post('search')) {
            if ($this->input->post('keyword_for')) {
                $where['key_name'] = $this->input->post('keyword_for');
            }
            if ($this->input->post('keyword_value')) {
                $where['keyword_value'] = $this->input->post('keyword_value');
            }
            if ($this->input->post('status')) {
                $where['status'] = $this->input->post('status');
            }
        }
        $order_field = 'stock_id';
        $order = 'desc';
        $data['body'] = 'v_stock_list';
        $data['stock'] = $this->um->get_data('stock', '', '', '', '', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('stock');

        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
//        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function update_and_insert_stock() {
        if (isset($_POST['rowsArray'])) {
//            $last_id = $this->um->last_id('inv_id', 'invoice');
            $stock = $_POST['rowsArray'];
            $final_array = array_chunk($stock, 11);
//            echo '<pre>';
//            print_r($final_array);
//            echo '</pre>';
//            exit();
            foreach ($final_array as $info) {
                if ($info[10]) {

                    if ($info[6]) {

                        $data = array(
                            'product_id' => $info[10],
                            'existing_qty' => $info[6],
                            'last_updated' => $info[7],
                            'remarks' => $info[8]
                        );
                        $last_id = $this->um->insert_data('stock', $data);
                    } else {
                        $data = array(
                            'product_id' => $info[10],
                            'existing_qty' => $info[4],
                            'last_updated' => $info[7],
                            'remarks' => $info[8]
                        );
                        $last_id = $this->um->insert_data('stock', $data);
                    }
                } else {
                    if ($info[6]) {
                        $where['stock_id'] = $info[9];
                        $data = array(
                            'existing_qty' => $info[6],
                            'last_updated' => $info[7],
                            'remarks' => $info[8]
                        );
                        $last_id = $this->um->update_data('stock', $data, $where);
                    } else {
                        $where['stock_id'] = $info[9];
                        $data = array(
                            'existing_qty' => $info[4],
                            'last_updated' => $info[7],
                            'remarks' => $info[8]
                        );
                        $last_id = $this->um->update_data('stock', $data, $where);
                    }
                }
            }
        }
        echo 'sucess';
    }

    public function save_invoice() {
        print_r($_POST);
    }

    public function invoice_from() {
        $table = 'invoice';
        if (isset($_POST['inv_number'])) {
            if ($_POST['discount_value']) {
                $dicount = $_POST['discount_value'];
            } else {
                $dicount = 0;
            }
            $data = array(
                'inv_number' => $_POST['invoice_number'],
                'client_id' => $_POST['client_id'],
                'address' => $_POST['address'],
                'currency_id' => $_POST['currency_id'],
                'po_number' => $_POST['po_number'],
                'ac_number' => $_POST['b_number'],
                'remarks' => $_POST['remarks'],
                'created_at' => strtotime(date('Y-m-d')),
                'discount_type' => $_POST['discount'],
                'discount_value' => $dicount,
                'total_value' => $_POST['total'],
                'status' => 1
            );

            $where = array('inv_id' => $_POST['inv_number']);
            $this->um->update_data($table, $data, $where);
            $data['success'] = 'Invoice Successfully Updated';
        } else {
            if ($_POST['discount_value']) {
                $dicount = $_POST['discount_value'];
            } else {
                $dicount = 0;
            }

            $data = array(
                'inv_number' => $_POST['invoice_number'],
                'client_id' => $_POST['client_id'],
                'address' => $_POST['address'],
                'currency_id' => $_POST['currency_id'],
                'po_number' => $_POST['po_number'],
                'ac_number' => $_POST['b_number'],
                'remarks' => $_POST['remarks'],
                'created_at' => strtotime(date('Y-m-d')),
                'discount_type' => $_POST['discount'],
                'discount_value' => $dicount,
                'total_value' => $_POST['total'],
                'status' => 1
            );
            $inv_data = array('last_invoice' => $_POST['last_invoice']);
            $inv_condition = array('client_id' => $_POST['client_id']);
            $this->um->update_data('conf_client', $inv_data, $inv_condition);
            $this->um->insert_data($table, $data);
            $data['success'] = 'Invoice Successfully Inserted';
        }
        redirect('home/invoice');
    }

    public function branch() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $where = array(
                'bank_id' => $id,
                'status' => 1
            );
            $result = $this->um->get_data('conf_bank_branch', $where);
            echo json_encode($result);
        }
    }

    public function account() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $where = array(
                'branch_id' => $id,
                'status' => 1
            );
            $result = $this->um->get_data('conf_bank_branch_ac', $where);
            echo json_encode($result);
        }
    }

    public function update_info() {

        if (isset($_POST['rowsArray'])) {
            $product = $_POST['rowsArray'];
            $final_array = array_chunk($product, 12);
            foreach ($final_array as $info) {
                if ($info[1] != '') {
                    $data = array(
                        'invoice_id' => $info[0],
                        'prod_name' => $info[2],
                        'prod_id' => $info[3],
                        'color_id' => $info[5],
                        'size_id' => $info[7],
                        'quantity' => $info[8],
                        'unit_price' => $info[9],
                        'line_total' => $info[10]
                    );
                    $where = array('inv_prod_id' => $info[1]);
                    $last_id = $this->um->update_data('invoice_product', $data, $where);
                } else {
                    $sdata = array(
                        'invoice_id' => $info[0],
                        'prod_name' => $info[2],
                        'prod_id' => $info[3],
                        'color_id' => $info[5],
                        'size_id' => $info[7],
                        'quantity' => $info[8],
                        'unit_price' => $info[9],
                        'line_total' => $info[10],
                        'status' => 1
                    );
                    $last_id = $this->um->insert_data('invoice_product', $sdata);
                }
            }
            echo 'Ok';
        }
    }

    public function get_rc() {
        if (isset($_GET['term'])) {
            $col_name = 'center_name';
            $table = 'conf_ruralcenter';
            $q = strtolower($_GET['term']);
            $this->um->get_autocom_info($q, $col_name, $table);
        }
    }

    public function get_product() {
        if (isset($_GET['term'])) {
            $col_name = 'inv_prod_id';
            $table = 'workorder_product';
            $q = strtolower($_GET['term']);
            $this->um->get_autocom_info($q, $col_name, $table);
        }
    }

    public function get_product_distribution() {
        if (isset($_GET['term'])) {
            $inv_number = $_GET['inv_number'];
            $table = 'invoice_product';
            $q = strtolower($_GET['term']);
            $this->um->dis_prod_name($q, $table, 'prod_name', 'invoice_id', $inv_number);
        }
    }

    public function all_rc() {
        if (isset($_POST['name'])) {
//            print_r($_POST);exit;
            $hwhere = array('center_name' => $_POST['name']);
            $data = $this->um->get_data('conf_ruralcenter', $hwhere);
            echo json_encode($data);
        }
    }

    public function all_pro() {
        if (isset($_POST['name'])) {
            $hwhere = array('prod_id' => $_POST['name']);
            $data = $this->um->get_data('invoice_product', $hwhere);
            $hwhere1 = array('inv_prod_id' => $data[0]['inv_prod_id']);
            $data[2] = $this->um->get_data('workorder_product', $hwhere1);
//             print_r($data[2]);exit;
            $where3 = array('keyword_id' => $data[0]['color_id']);
            $data[3] = $this->um->get_data('conf_keyword', $where3);
            $where4 = array('keyword_id' => $data[0]['size_id']);
            $data[4] = $this->um->get_data('conf_keyword', $where4);
            $hwhere2 = array('id' => $data[0]['prod_id']);
            $data[5] = $this->um->get_data('conf_product', $hwhere2);
//            $hwhere21 = array('product_id' => $data[0]['prod_id']);
//              print_r($hwhere21);exit;
            $hwhere21 = array('product_id' => 10);
            $data[1] = $this->um->get_data('conf_product_actiontime', $hwhere21, 'conf_productactions', 'id', 'action_id');
//            print_r($data[6]);exit;
            $data[6] = $this->um->get_data('conf_product_parts', $hwhere21, 'conf_product', 'id', 'part_name_id');
//            print_r($data[6]);exit;
            for ($size = 0; $size < sizeof($data[6]); $size++) {
                $part_name_id = array('id' => $data[6][$size]['part_name_id']);
//                $part_name_id1 = array('id' => $data[6][1]['part_name_id']);
                $data[7] = $this->um->get_data('conf_product', $part_name_id);
                $color_id = array('keyword_id' => $data[7][0]['color']);
                $data[8][$size] = $this->um->get_data('conf_keyword', $color_id);
                $size_id = array('keyword_id' => $data[7][0]['size']);
                $data[9][$size] = $this->um->get_data('conf_keyword', $size_id);
                $prod_id = array('product_id' => $data[6][$size]['part_name_id']);
                $data[10][$size] = $this->um->get_data('conf_product_actiontime', $prod_id, 'conf_productactions', 'id', 'action_id');
            }

            echo json_encode($data);
        }
    }

    public function distribution_wizard($workorder_id = false) {
        $data['body'] = 'v_distribution_wizard';
        $wo_id = array('workorder_id' => $workorder_id);
        $inv_id = $this->um->get_data('workorder', $wo_id);
//        print_r($inv_id);exit;
//        $wo = $_POST['inv_id'];
//        print_r($wo);exit; 
        $invoice_id = array('invoice_id' => $inv_id[0]['invoice_id']);
//        print_r($invoice_id);exit;
        $data['invoice_id'] = $this->um->get_data('invoice_product', $invoice_id);
//        print_r(    $data['invoice_id'] );        exit;
        $wo_no = array('workorder_no' => $inv_id[0]['workorder_no']);
        $data['wo_no'] = $this->um->get_data('workorder', $invoice_id);
//        print_r($data['wo_no']);exit;
        $data['inv_id'] = $inv_id[0]['invoice_id'];
        $in_id = array('inv_id' => $inv_id[0]['invoice_id']);
        $data['inv_no'] = $this->um->get_data('invoice', $in_id);
//        print_r($data['inv_no'][0]['inv_number']);exit;

        $this->load->view('element/main_temp', $data);
    }

    public function distribution_receive() {
        $data['body'] = 'v_rec_distribution';
        $data['order_no'] = $this->um->get_data('workorder');

        $this->load->view('element/main_temp', $data);
    }

    public function save_wizard() {
        if (isset($_POST['myarray'])) {
            $wizard = $_POST['myarray']['wizard'];
//            print_r($wizard);exit;
            $wo1 = $_POST['myarray']['wo'];
            $wo = array_pop($wo1);
//            print_r($wo);exit;
            $dis_no = $this->um->get_data('distribution');
            $uy = array_pop($dis_no);
//               print_r($uy['distribution_no']);exit;
            $distribution_sl_no = $uy['distribution_no'];
            $hgdfjk = explode('D', $distribution_sl_no);
            $bby = $hgdfjk[1];

//            print_r($wo);exit;
            $final_array = array_chunk($wizard, 16);
//               print_r($final_array);exit;
            foreach ($final_array as $info) {
                $where = array('ruralcenter_id' => $info[10]);
                $bby = $bby + 1;
                $final_dis_no = "D" . sprintf("%'.09d", $bby);
                $data = array(
                    'distribution_no' => $final_dis_no,
                    'workworder_id' => $wo,
                    'ruralcenter_id' => $info[12],
                    'created_at' => date('Y/m/d'),
                );
                $distribution_id = $this->um->insert_data('distribution', $data);

                $data = array(
                    'wo_prod_id' => $info[2],
                    'prod_id' => $info[1],
                    'prod_part_id' => $info[5],
                    'prod_action_id' => $info[9],
                    'wo_qty' => $info[12],
                    'distributed_qty' => $info[13],
                    'distribution_qty' => $info[14],
                    'distribution_id' => $distribution_id,
                    'remarks' => 'null',
                );
                $product_id1 = $this->um->insert_data('distribution_product', $data);
            }
        }
    }

    public function update_wizard() {
        if (isset($_POST['myarray'])) {
            $wizard = $_POST['myarray']['wizard'];
            $final_array = array_chunk($wizard, 15);

            foreach ($final_array as $info) {
                $data = array(
                    'distribution_qty' => $info[13]
                );
                $where = array('distribution_prod_id' => $info[2]);
                $this->um->update_data('distribution_product', $data, $where);
            }
        }
    }

    public function distribution($distribution_id = FALSE) {
        $data['body'] = 'v_distribution';
//        print_r($distribution_id);exit;
        $where = array('distribution_id' => $distribution_id);
        $data['dis'] = $this->um->get_data('distribution', $where, 'workorder', 'workorder_id', 'workworder_id', 'conf_ruralcenter', 'id', 'ruralcenter_id');
//        print_r($data);exit;
        $invoice = array('inv_id' => $data['dis'][0]['invoice_id']);
        $data['invoice'] = $this->um->get_data('invoice', $invoice);
        $data['all'] = $this->um->get_data('distribution_product', $where, 'conf_product', 'id', 'prod_id');

        $this->load->view('element/main_temp', $data);
    }

    public function pending_distribution_list() {
        $url = base_url('home/pending_distribution_list');
        $where = array();
        $limit = $this->limit;
        if ($this->uri->segment(3) == 'null') {
            $start = 0;
        } else {
            $start = $this->uri->segment(3);
        }
        if ($this->input->post('search')) {
            if ($this->input->post('keyword_for')) {
                $where['key_name'] = $this->input->post('keyword_for');
            }
            if ($this->input->post('keyword_value')) {
                $where['keyword_value'] = $this->input->post('keyword_value');
            }
            if ($this->input->post('status')) {
                $where['status'] = $this->input->post('status');
            }
        }
        $where = array('status' => 1);
        $data['body'] = 'v_pending_distribution_list';
        $order_field = 'workorder_id';
        $order = 'desc';
        $data['workorder'] = $this->um->get_data('workorder', FALSE, 'invoice', 'inv_id', 'invoice_id', '', '', '', $limit, $start, $order_field, $order);

        $data['total'] = $this->um->get_data('workorder');
        $total = count($data['total']);
//             print_r($total);exit;
        $data['page'] = $this->pagination($url, $total, $limit);
        $this->load->view('element/main_temp', $data);
    }

    public function distribution_list() {
        $url = base_url('home/distribution_list');
        $where = array();
        $limit = $this->limit;
        if ($this->uri->segment(3) == 'null') {
            $start = 0;
        } else {
            $start = $this->uri->segment(3);
        }
        if ($this->input->post('search')) {
            if ($this->input->post('keyword_for')) {
                $where['key_name'] = $this->input->post('keyword_for');
            }
            if ($this->input->post('keyword_value')) {
                $where['keyword_value'] = $this->input->post('keyword_value');
            }
            if ($this->input->post('status')) {
                $where['status'] = $this->input->post('status');
            }
        }
        $data['body'] = 'v_distribution_list';
        $order_field = 'distribution_id';
        $order = 'desc';
        $data['value'] = $this->um->get_data('distribution', '', '', '', '', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('distribution');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
//        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function rawdistribution_list() {
        $url = base_url('home/rawdistribution_list');
        $where = array();
        $limit = $this->limit;
        if ($this->uri->segment(3) == 'null') {
            $start = 0;
        } else {
            $start = $this->uri->segment(3);
        }
        if ($this->input->post('search')) {
            if ($this->input->post('keyword_for')) {
                $where['key_name'] = $this->input->post('keyword_for');
            }
            if ($this->input->post('keyword_value')) {
                $where['keyword_value'] = $this->input->post('keyword_value');
            }
            if ($this->input->post('status')) {
                $where['status'] = $this->input->post('status');
            }
        }
        $order_field = 'disrm_id';
        $order = 'desc';
        $data['body'] = 'v_rawdistribution_list';
        $data['value'] = $this->um->get_data('distribution_rawmaterial', '', '', '', '', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('distribution_rawmaterial');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
//        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function pending_rawdistribution_list() {
        $url = base_url('home/pending_rawdistribution_list');
        $where = array();
        $limit = $this->limit;
        if ($this->uri->segment(3) == 'null') {
            $start = 0;
        } else {
            $start = $this->uri->segment(3);
        }
        if ($this->input->post('search')) {
            if ($this->input->post('keyword_for')) {
                $where['key_name'] = $this->input->post('keyword_for');
            }
            if ($this->input->post('keyword_value')) {
                $where['keyword_value'] = $this->input->post('keyword_value');
            }
            if ($this->input->post('status')) {
                $where['status'] = $this->input->post('status');
            }
        }
        $data['body'] = 'v_pending_rawdistribution_list';
        $order_field = 'distribution_id';
        $order = 'desc';
        $data['value'] = $this->um->get_data('distribution', '', '', '', '', '', '', '', $limit, $start, $order_field, $order);
           $limit_peg = $this->um->get_data('distribution', '', '', '', '', '', '', '', $limit, $start, $order_field, $order);
//        print_r($limit_peg);exit;
        $v=0;
        foreach ($limit_peg as $dis_no){
//            print_r($dis_no['distribution_no']);exit;
            $d_value = array('distribution_no'=>$dis_no['distribution_no']);
            $total_count = $this->um->get_data('distribution' ,$d_value);
            if($total_count!= null)
            {
            $v++;
            }
        }
//        print_r($v);exit;
        $data['total'] = $this->um->get_data('distribution');
        $total = count($data['total']);
        $total = $total - $v;
        $data['page'] = $this->pagination($url, $total, $limit);
//        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function save_raw_dis_wizard() {
        if (isset($_POST['myarray'])) {
            $wizard = $_POST['myarray']['wizard'];
            $wo = $_POST['myarray']['wo'];
            $distribution_id = $wo[0];

            $data = array(
                'distribution_id' => $distribution_id,
//                    'time_hr' => $info[4],
                'time_hr' => $wo[4],
                'created_at' => $wo[6],
                'prep_start_dt' => $wo[7],
                'prep_end_dt' => $wo[8],
                'send_date' => $wo[9],
                'exp_return_dt' => $wo[10],
                'remarks' => $wo[5],
            );
            $dis_prod_id = $this->um->insert_data('distribution_rawmaterial', $data);
//            $dis_prod_id = $this->um->get_data('distribution_rawmaterial');
//                     print_r($dis_prod_id[0]['disrm_id']);exit;
            $final_array = array_chunk($wizard, 12);
            foreach ($final_array as $info) {
                $data = array(
                    'disrm_id' => $dis_prod_id,
                    'dis_prod_id' => $info[0],
                    'prod_id' => $info[2],
                    'rawmaterial_id' => $info[7],
                    'dist_qty' => $info[5],
                    'dist_rm_qty' => $info[8],
//                          'dist_rm_qty' => 10.00,
                    'total_qty' => $info[9],
//                           'total_qty' => 100,
                    'stock_qty' => $info[10],
                    'remarks' => 'null',
                );
                $product_id1 = $this->um->insert_data('distribution_rawmaterial_product', $data);
            }
        }
    }

    public function update_raw_dis_wizard() {
        if (isset($_POST['myarray'])) {
            $wizard = $_POST['myarray']['wizard'];
//            print_r($wizard);exit;
            $wo = $_POST['myarray']['wo'];
            $distribution_id = $wo[0];
            $final_array = array_chunk($wizard, 9);
//            print_r($final_array);exit;
            foreach ($final_array as $info) {
                $disrm_prod_id['disrm_prod_id'] = $info[7];
                $data = array(
                    'dist_rm_qty' => $info[4],
                    'total_qty' => $info[5],
                );
//                print_r($data);exit;
                $dis_receive_update = $this->um->update_data('distribution_rawmaterial_product', $data, $disrm_prod_id);
            }
        }
    }

    public function rawdistribution_wizard($distribution_id = false) {
        $data['body'] = 'v_rawdistribution_wizard';
//        print_r($distribution_id);exit;
//        $distribution_id = $_POST['distribution_no'];
//        print_r($dis_id);exit;
        $where = array('distribution_id' => $distribution_id);
        $data['distribution'] = $this->um->get_data('distribution', $where);

        $workorder_id = array('workorder_id' => $data['distribution'][0]['workworder_id']);
        $data['workorder_no'] = $this->um->get_data('workorder', $workorder_id);
        $invoice_id = array('inv_id' => $data['workorder_no'][0]['invoice_id']);
        $data['invoice_no'] = $this->um->get_data('invoice', $invoice_id);
        $ruralcenter_id = array('id' => $data['distribution'][0]['ruralcenter_id']);

        $data['rc_name'] = $this->um->get_data('conf_ruralcenter', $ruralcenter_id);
        $distribution_id = array('distribution_id' => $distribution_id);
        $data['all_dis_product'] = $this->um->get_data('distribution_product', $distribution_id);
        $action = $this->um->get_data('distribution_product', $distribution_id);
        $time = 0;
        foreach ($action as $test) {
            $product_id = array('product_id' => $test['prod_id']);
            $action_time = $this->um->get_data('conf_product_actiontime', $product_id);
            if ($action_time != null) {
                $time1 = $action_time[0]['action_time'];
            } else {
                $time1 = 0;
            }
            $time = $time + $time1 * $test['distribution_qty'];
        }
        $data['time'] = $time;
        $this->load->view('element/main_temp', $data);
    }

    public function rawdistribution() {
        $data['body'] = 'v_rawdistribution';
//        print_r($_POST);exit;
        $distribution_id = $_GET['disrm_id'];
//        print_r($dis_id);exit;
        $where = array('distribution_id' => $distribution_id);
        $data['distribution'] = $this->um->get_data('distribution', $where);

        $workorder_id = array('workorder_id' => $data['distribution'][0]['workworder_id']);
        $data['workorder_no'] = $this->um->get_data('workorder', $workorder_id);
        $invoice_id = array('inv_id' => $data['workorder_no'][0]['invoice_id']);
        $data['invoice_no'] = $this->um->get_data('invoice', $invoice_id);
        $ruralcenter_id = array('id' => $data['distribution'][0]['ruralcenter_id']);

        $data['rc_name'] = $this->um->get_data('conf_ruralcenter', $ruralcenter_id);
        $distribution_id = array('distribution_id' => $distribution_id);
        $data['all_dis_product'] = $this->um->get_data('distribution_rawmaterial_product');
        $data['all_dis_rm_value'] = $this->um->get_data('distribution_rawmaterial', $distribution_id);
        $this->load->view('element/main_temp', $data);
    }

    public function get_product_no() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->um->all_autocom($q, 'conf_product', 'code', 'id');
        }
    }

    public function get_distribution_no() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->um->all_autocom($q, 'distribution', 'distribution_no', 'distribution_id');
        }
    }

    public function get_inv_no() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->um->all_autocom($q, 'invoice', 'inv_number', 'inv_id');
        }
    }

    public function get_rcname() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->um->all_autocom($q, 'conf_ruralcenter', 'center_name', 'id');
        }
    }

    public function get_wo_no() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->um->all_autocom($q, 'workorder', 'workorder_no', 'workorder_id');
        }
    }

    public function get_invoice_no() {
        $where = array('workorder_id' => $_POST['id']);
        $data = $this->um->get_data('workorder', $where);

        $where1 = array('inv_id' => $data[0]['invoice_id']);
        $data1 = $this->um->get_data('invoice', $where1);
//        print_r($data1);exit;

        echo json_encode($data1);
    }

    public function get_dis_no() {
        $where = array('ruralcenter_id' => $_POST['id']);
        $data = $this->um->get_data('distribution', $where);
        echo json_encode($data);
    }

    public function receivedistribution_list() {
        $url = base_url('home/receivedistribution_list');
        $where = array();
        $limit = $this->limit;
        if ($this->uri->segment(3) == 'null') {
            $start = 0;
        } else {
            $start = $this->uri->segment(3);
        }
        if ($this->input->post('search')) {
            if ($this->input->post('keyword_for')) {
                $where['key_name'] = $this->input->post('keyword_for');
            }
            if ($this->input->post('keyword_value')) {
                $where['keyword_value'] = $this->input->post('keyword_value');
            }
            if ($this->input->post('status')) {
                $where['status'] = $this->input->post('status');
            }
        }
        $order_field = 'distrcv_id';
        $order = 'desc';
        $data['body'] = 'v_receivedistribution_list';
        $data['value'] = $this->um->get_data('distribution_receive', '', '', '', '', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('distribution_receive');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
//        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function receivedistribution_wizard() {
        $data['body'] = 'v_receivedistribution_wizard';
//        print_r($_GET);exit;
        $distribution_id = $_GET['distribution_no'];
//                $distribution_id = 'd';
//        print_r($distribution_id);exit;
        $where = array('distribution_no' => $distribution_id);
        $data['distribution'] = $this->um->get_data('distribution', $where);
//        print_r($data['distribution'][0]['distribution_id']);exit;
        $workorder_id = array('workorder_id' => $data['distribution'][0]['workworder_id']);
        $data['workorder_no'] = $this->um->get_data('workorder', $workorder_id);
        $invoice_id = array('inv_id' => $data['workorder_no'][0]['invoice_id']);
        $data['invoice_no'] = $this->um->get_data('invoice', $invoice_id);
        $ruralcenter_id = array('id' => $data['distribution'][0]['ruralcenter_id']);
        $data['rc_name'] = $this->um->get_data('conf_ruralcenter', $ruralcenter_id);
        $distribution_id = array('distribution_id' => $data['distribution'][0]['distribution_id']);

        $data['all_dis_product'] = $this->um->get_data('distribution_product', $distribution_id);
//        print_r($data['all_dis_product']);
        $action = $this->um->get_data('distribution_product', $distribution_id);

        $this->load->view('element/main_temp', $data);
    }

    public function receivedistribution() {
        $data['body'] = 'v_receivedistribution';
        $distribution_id = $_GET['distrcv_id'];
//        print_r($distribution_id);exit;
        $where = array('distribution_id' => $distribution_id);
        $data['distribution'] = $this->um->get_data('distribution', $where);
        $workorder_id = array('workorder_id' => $data['distribution'][0]['workworder_id']);
        $data['workorder_no'] = $this->um->get_data('workorder', $workorder_id);
        $invoice_id = array('inv_id' => $data['workorder_no'][0]['invoice_id']);
        $data['invoice_no'] = $this->um->get_data('invoice', $invoice_id);
        $ruralcenter_id = array('id' => $data['distribution'][0]['ruralcenter_id']);
        $data['rc_name'] = $this->um->get_data('conf_ruralcenter', $ruralcenter_id);
        $distribution_id = array('distribution_id' => $distribution_id);
        $data['all_dis_product'] = $this->um->get_data('distribution_product', $distribution_id);
        $data['dis_rcv_product'] = $this->um->get_data('distribution_receive_product');
        $dis_rcv = array('distrcv_id' => $_GET['distrcv_id']);
        $data['dis_rcv'] = $this->um->get_data('distribution_receive', $dis_rcv);

        $this->load->view('element/main_temp', $data);
    }

    public function update_rcvdis() {
        if (isset($_POST['myarray'])) {
            $wizard = $_POST['myarray']['wizard'];
//            print_r($wizard);            exit;

            $final_array = array_chunk($wizard, 14);
            foreach ($final_array as $info) {

                $data = array(
                    'due_qty' => $info[8],
                    'receive_qty' => $info[9],
                    'over_qty' => $info[10],
                    'qc_passed' => $info[11],
                    'qc_failed' => $info[12],
                    'damaged' => $info[13],
                );
                $distrcvprod_id = array('distrcvprod_id' => $info[2]);
                $dis_receive_update = $this->um->update_data('distribution_receive_product', $data, $distrcvprod_id);
            }
        }
    }

    public function save_receive_dis_wizard() {
        if (isset($_POST['myarray'])) {
            $wizard = $_POST['myarray']['wizard'];
            $wo = $_POST['myarray']['wo'];
            $distribution_id = $wo[0];
//            print_r($wo);exit;
            $data = array(
                'distribution_id' => $distribution_id,
                'receive_date' => $wo[1],
                'remarks' => $wo[2],
            );
            $distrcv_id = $this->um->insert_data('distribution_receive', $data);
//            print_r($wizard);            exit;
            $final_array = array_chunk($wizard, 18);
            foreach ($final_array as $info) {
                $data = array(
                    'distrcv_id' => $distrcv_id,
                    'dist_prod_id' => $info[2],
                    'prod_id' => $info[1],
                    'distributed_qty' => $info[9],
                    'receive_qty' => $info[11],
                    'due_qty' => $info[10],
                    'over_qty' => $info[12],
                    'qc_passed' => $info[13],
                    'qc_failed' => $info[14],
                    'damaged' => $info[15],
                    'remarks' => $info[16],
                );
                $product_id1 = $this->um->insert_data('distribution_receive_product', $data);
            }
        }
    }

    public function payment() {

        $data['body'] = 'payment';
        $distribution_id = $_GET['dis_id'];
        $where = array('distribution_id' => $distribution_id);
        $data['distribution'] = $this->um->get_data('distribution', $where);
        $workorder_id = array('workorder_id' => $data['distribution'][0]['workworder_id']);
        $data['workorder_no'] = $this->um->get_data('workorder', $workorder_id);
        $invoice_id = array('inv_id' => $data['workorder_no'][0]['invoice_id']);
        $data['invoice_no'] = $this->um->get_data('invoice', $invoice_id);
        $ruralcenter_id = array('id' => $data['distribution'][0]['ruralcenter_id']);
        $data['rc_name'] = $this->um->get_data('conf_ruralcenter', $ruralcenter_id);
        $data['payment_mode'] = $this->um->get_data('conf_paymentmode');
        $data['payment_currency'] = $this->um->get_data('conf_currency');
        $data['receive_date'] = $this->um->get_data('distribution_receive', $where);
        $data['receive_dis'] = $this->um->get_data('distribution_receive_product');
        $this->load->view('element/main_temp', $data);
    }

    public function payment_edit() {

        $data['body'] = 'payment_edit';
        $pay_id = $_GET['pay_id'];
        $where_pay = array('pay_id' => $pay_id);
        $data['dis_pay'] = $this->um->get_data('payment', $where_pay, 'distribution_receive', 'distrcv_id', 'dist_rcv_id');
        $distribution_id = $data['dis_pay'][0]['distribution_id'];
        $where = array('distribution_id' => $distribution_id);
        $data['distribution'] = $this->um->get_data('distribution', $where);
        $workorder_id = array('workorder_id' => $data['distribution'][0]['workworder_id']);
        $data['workorder_no'] = $this->um->get_data('workorder', $workorder_id);
        $invoice_id = array('inv_id' => $data['workorder_no'][0]['invoice_id']);
        $data['invoice_no'] = $this->um->get_data('invoice', $invoice_id);
        $ruralcenter_id = array('id' => $data['distribution'][0]['ruralcenter_id']);
        $data['rc_name'] = $this->um->get_data('conf_ruralcenter', $ruralcenter_id);
        $pay = array('pay_id' => $distribution_id);
        $data['payment_mode'] = $this->um->get_data('conf_paymentmode');
//        print_r($data['payment_mode']);exit;
        $data['payment_currency'] = $this->um->get_data('conf_currency');
//         print_r($data['payment_currency']);exit;
        $data['receive_date'] = $this->um->get_data('distribution_receive', $where);
        $data['receive_dis'] = $this->um->get_data('payment_product', $where_pay);
//        print_r($data);exit;
        $this->load->view('element/main_temp', $data);
    }

    public function payment_list() {
        $url = base_url('home/payment_list');
        $where = array();
        $limit = $this->limit;
        if ($this->uri->segment(3) == 'null') {
            $start = 0;
        } else {
            $start = $this->uri->segment(3);
        }
        if ($this->input->post('search')) {
            if ($this->input->post('keyword_for')) {
                $where['key_name'] = $this->input->post('keyword_for');
            }
            if ($this->input->post('keyword_value')) {
                $where['keyword_value'] = $this->input->post('keyword_value');
            }
            if ($this->input->post('status')) {
                $where['status'] = $this->input->post('status');
            }
        }
        $order_field = 'pay_id';
        $order = 'desc';
        $data['body'] = 'payment_list';
        $data['value'] = $this->um->get_data('payment', '', '', '', '', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('payment');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
//        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function save_payment() {
        if (isset($_POST['myarray'])) {
            $wizard = $_POST['myarray']['wizard'];
            $wo = $_POST['myarray']['wo'];
            $pay_number = $this->um->get_data('payment');
            $uy = array_pop($pay_number);
            $pay_sl_no = $uy['pay_number'];
            $hgdfjk = explode('P', $pay_sl_no);
            $bby = $hgdfjk[1];
            $bby = $bby + 1;
            $final_pay_number = "P" . sprintf("%'.09d", $bby);

            $data = array(
                'pay_number' => $final_pay_number,
                'dist_rcv_id' => $wo[0],
                'pay_date' => $wo[1],
                'pay_mode_id' => $wo[2],
                'pay_currency_id' => $wo[3],
            );
            $pay_id = $this->um->insert_data('payment', $data);
            $distrcv_id = array('distrcv_id' => $wo[0]);
            $status = array('status' => 0);
            $dis_receive_update = $this->um->update_data('distribution_receive', $status, $distrcv_id);
//            print_r($wizard);            exit;
            $final_array = array_chunk($wizard, 9);
            foreach ($final_array as $info) {
                $data = array(
                    'pay_id' => $pay_id,
                    'distrcvprod_id' => $info[1],
                    'received_qty' => $info[3],
                    'price' => $info[4],
                    'total_price' => $info[5],
                    'due_price' => $info[6],
                    'paid_price' => $info[7],
                );
                $product_id1 = $this->um->insert_data('payment_product', $data);
            }
        }
    }

    public function update_payment() {
        if (isset($_POST['myarray'])) {
            $wizard = $_POST['myarray']['wizard'];

            $wo = $_POST['myarray']['wo'];
//                   print_r($wizard);exit;
            $pay_id1 = $wo[1];
            $data = array(
                'pay_mode_id' => $wo[2],
                'pay_currency_id' => $wo[3],
            );
            $pay_id = array('pay_id' => $pay_id1);
            $dis_receive_update = $this->um->update_data('payment', $data, $pay_id);
            $final_array = array_chunk($wizard, 9);
            foreach ($final_array as $info) {
                $pay_prod_id = array('pay_prod_id' => $info[1]);
                $data = array('paid_price' => $info[7],);
                $dis_receive_update = $this->um->update_data('payment_product', $data, $pay_prod_id);
            }
        }
    }

    public function find_receive() {
//        print_r(myarray[]);exit;
        $th = $_POST['myarray']['1'];
//        print_r($th);exit;
        $where = array('ruralcenter_id' => $th);
        $data['value'] = $this->um->get_data('distribution', $where, 'distribution_receive', 'distribution_id', 'distribution_id');
        echo json_encode($data);
    }

    public function find_receive_list() {
        $rc_id = $_POST['myarray'][1];
        $inv_id = $_POST['myarray'][3];
        $prod_id = $_POST['myarray'][5];
        $distribution_id = $_POST['myarray'][7];
        if ($inv_id != null && $prod_id != null) {
            $where = array('invoice_id' => $inv_id, 'prod_id' => $prod_id);
            $data = $this->um->get_data('invoice_product', $where);
        } elseif ($inv_id != null && $prod_id == null) {
            $where = array('invoice_id' => $inv_id);
            $data = $this->um->get_data('invoice_product', $where);
        } elseif ($inv_id == null && $prod_id != null) {
            $where = array('prod_id' => $prod_id);
            $data = $this->um->get_data('invoice_product', $where);
        }
//        print_r($data);        exit;
        $invoice_id = $data[0]['invoice_id'];
//        print_r($invoice_id);
        $where1 = array('invoice_id' => $invoice_id);
        $data1 = $this->um->get_data('workorder', $where1);
        $workorder_id = $data1[0]['workorder_id'];
//        print_r($workorder_id);exit;
        if ($distribution_id != null) {

            $where2 = array('workworder_id' => $workorder_id, 'ruralcenter_id' => $rc_id, 'distribution_id' => $distribution_id);
            $data2['value'] = $this->um->get_data('distribution', $where2);
        } else {

            $where2 = array('workworder_id' => $workorder_id, 'ruralcenter_id' => $rc_id);
            $data2['value'] = $this->um->get_data('distribution', $where2);
        }

//        print_r($data2);exit;
        echo json_encode($data2);
    }

    public function for_test() {
        $dis_id = $_POST['name'];
        echo json_encode($dis_id);
    }

    public function complete_raw_dis() {
//        print_r($_POST['value']);exit;
        $disrm_id = array('disrm_id' => $_POST['value']);
        $status = array('status' => 1);
        $dis_receive_update = $this->um->update_data('distribution_rawmaterial', $status, $disrm_id);
    }

    public function complete_rcv_dis() {
//        print_r($_POST['value']);exit;
        $distrcv_id = array('distrcv_id' => $_POST['value']);
        $status = array('status' => 1);
        $dis_receive_update = $this->um->update_data('distribution_receive', $status, $distrcv_id);
    }

}
