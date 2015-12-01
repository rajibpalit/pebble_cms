<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of workorder
 *
 * @author ahossain
 */
class Workorder extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        if (!$this->is_logged_in($this->session->userdata('logged_in'))) {
            redirect('login');
        }
        $this->load->model('user_model', 'um');
    }

    public function index() {
        $url = base_url('workorder/index');
        if ($this->uri->segment(3) == 'null') {
            $start = 0;
        } else {
            $start = $this->uri->segment(3);
        }
        $limit = $this->limit;
        $where = array('status' => 1);
        $data['body'] = 'workorder_list';
        $order_field = 'workorder_id';
        $order = 'desc';
        $data['workorder'] = $this->um->get_data('workorder', FALSE, 'invoice', 'inv_id', 'invoice_id', '', '', '', $limit, $start,$order_field,$order);

        $data['total'] = $this->um->get_data('workorder', $where);
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $this->load->view('element/main_temp', $data);
    }

    public function save_workorder() {
        $last_id_val = array('type' => 'work_order');
        $last_work_order = $this->um->get_data('confi_last_id', $last_id_val);
        $last_value = $last_work_order[0]['value'] + 1;
        $len = strlen($last_value);
        $j = '';
        for ($i = $len; $i < 9; $i++) {
            $j.='0';
        }
        $final_work_order = 'W' . $j . $last_value;

        $data = array(
            'workorder_no' => $final_work_order,
            'invoice_id' => $_POST['inv_number'],
            'status' => 1
        );

        $udata = array('value' => $last_value);
        $uwhere = array('id' => $last_work_order[0]['id']);
        $this->um->update_data('confi_last_id', $udata, $uwhere);
        $this->um->insert_data('workorder', $data);
        $invoice_id = $_POST['inv_number'];
        $this->workorder_product($invoice_id);
        redirect('pending_workorder');
    }

    public function workorder_product($invoice_id) {
        $invoice = array('invoice_id' => $invoice_id);
        $invoice_product = $this->um->get_data('invoice_product', $invoice);
        $last_id = $this->um->last_id('workorder_id', 'workorder');
        foreach ($invoice_product as $value) {
            $data = array(
                'inv_prod_id' => $value['inv_prod_id'],
//                'wo_qty' => $value['quantity'],
                'workorder_id' => $last_id,
                'order_qty' => $value['quantity'],
                'status' => 1
            );
            $this->um->insert_data('workorder_product', $data);
        }
    }

    public function edit_workorder($param = false) {
        $data['body'] = 'edit_workorder';
        $where = array('workorder_id' => $param);
        $workorder = $this->um->get_data('workorder', $where, 'invoice', 'inv_id', 'invoice_id');
        $data['workorder'] = $workorder;
        $invoice = array('invoice_id' => $workorder[0]['invoice_id']);
        $data['invoice_product'] = $this->um->get_data('invoice_product', $invoice);
        $this->load->view('element/main_temp', $data);
    }

    public function workorder_from() {
        $where = array('workorder_id' => $_POST['workorder_id']);
        $data = array('remarks' => $_POST['remarks']);
        $this->um->update_data('workorder', $data, $where);
        redirect('workorder');
    }

    public function save_info() {
        if (isset($_POST['rowsArray'])) {
            $product = $_POST['rowsArray'];
            $final_array = array_chunk($product, 9);

            foreach ($final_array as $info) {
                $data = array(
                    'inv_prod_id' => $info[1],
                    'order_qty' => $info[5],
                    'stock_qty' => $info[6],
                    'wo_qty' => $info[7],
                    'remarks' => $info[8],
                );
                $where = array('id' => $info[0]);
                $this->um->update_data('workorder_product', $data, $where);
            }
        }
    }

}
