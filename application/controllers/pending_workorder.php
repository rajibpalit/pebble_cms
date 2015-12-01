<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of pending_workorder
 *
 * @author ahossain
 */
class pending_workorder extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        if (!$this->is_logged_in($this->session->userdata('logged_in'))) {
            redirect('login');
        }
        $this->load->model('user_model', 'um');
    }

    public function index() {
        $url = base_url('pending_workorder/index');
        $limit = $this->limit;
        if ($this->uri->segment(3)) {
            $start = $this->uri->segment(3);
            $string = "select * from v_invoice where inv_id NOT in (select workorder.invoice_id from workorder)order by v_invoice.inv_id desc limit $start,$limit";
        } else {
            $string = "select * from v_invoice where inv_id NOT in (select workorder.invoice_id from workorder)order by v_invoice.inv_id desc limit $limit";
        }
        $query = $this->db->query($string)->result_array();
        $data['body'] = 'pending_workorder';
        $data['invoice'] = $query;
        $total_data = "select * from v_invoice where inv_id NOT in (select workorder.invoice_id from workorder)";
        $count = $this->db->query($total_data)->num_rows();
        $total = $count;
        $data['page'] = $this->pagination($url, $total, $limit);
        $this->load->view('element/main_temp', $data);
    }
    
      public function add_workorder($id = false) {
        $data['body'] = 'add_workorder';
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

}
