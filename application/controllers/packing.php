<?php

defined('BASEPATH') OR exit('No direct script access allowed');
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
class Packing extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        if (!$this->is_logged_in($this->session->userdata('logged_in'))) {
            redirect('login');
        }
        $this->load->model('user_model', 'um');
    }

    public function index() {
        $data['invoices'] = $this->um->get_data('invoice');
        $data['body'] = 'packing_list';
        $data['packings'] = $this->um->get_data('packingnote','','invoice','inv_id','inv_id');
        $this->load->view('element/main_temp', $data);
    }

    public function edit_packing($param = false) {
        if ($param != FALSE) {
            $where = array('packingnote.pack_id' => $param);
            $data['packing'] = $this->um->get_data('packingnote', $where);
            $data['packing_product'] = $this->um->get_data('packingnote', $where, 'packingnote_product', 'pack_id', 'pack_id');
            $iwhere = array(
                'inv_id' => $data['packing'][0]['inv_id']
            );
            $invoices = $this->um->get_data('invoice', $iwhere, 'conf_client', 'client_id', 'client_id');
            $data['invoices'] = $invoices;

            $invopro = array(
                'pack_id' => $data['packing'][0]['pack_id']
            );

            $invoi_pro = $this->um->get_data('packingnote_product', $invopro, 'stock', 'product_id', 'prod_id');

            $data['invoi_pro'] = $invoi_pro;

            $Swhere = array('key_name' => 'Packing Size');
            $data['sizes'] = $this->um->get_data('const_keys', $Swhere, 'conf_keyword', 'key_id', 'key_id');
        } else {
            $iwhere = array(
                'inv_id' => $this->input->post('invoice_id')
            );
            $invoices = $this->um->get_data('invoice', $iwhere, 'conf_client', 'client_id', 'client_id');
            $data['invoices'] = $invoices;

            $invopro = array(
                'invoice_id' => $this->input->post('invoice_id')
            );
            $invoi_pro = $this->um->get_data('invoice_product', $invopro, 'stock', 'product_id', 'prod_id');

            $data['invoi_pro'] = $invoi_pro;

            $Swhere = array('key_name' => 'Packing Size');
            $data['sizes'] = $this->um->get_data('const_keys', $Swhere, 'conf_keyword', 'key_id', 'key_id');
                                 
        }

        $data['body'] = 'add_packing';

        $this->load->view('element/main_temp', $data);
    }

    /* get information data from invoice table */

    public function get_invoice_data() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $where = array(
                'inv_id' => $id,
                'status' => 1
            );
            $result = $this->um->get_data('invoice', $where);


            $cwhere = array(
                'client_id' => $result[0]['client_id']
            );
            $info = $this->um->get_data('conf_client', $cwhere);
            $result[0]['client_name'] = $info[0]['client_name'];
            echo json_encode($result[0]);
        }
    }

    public function get_invoice_product() {
        if (isset($_POST['id'])) {
            $id = $_POST['id'];
            $where = array(
                'invoice_id' => $id,
                'status' => 1
            );
            $result = $this->um->get_data('invoice_product', $where);
            echo json_encode($result);
        }
    }

    public function save_packing() {
        $table = 'packingnote';
        if ($this->input->post('packing_id')) {
            $data = array(
                'inv_id' => $this->input->post('inv_id'),
                'pack_size' => $this->input->post('packing_size'),
                'box_number' => $this->input->post('box_number'),
                'remarks' => $this->input->post('remarks'),
            );
            $where = array('pack_id' => $this->input->post('packing_id'));
            $this->um->update_data($table, $data, $where);
        } else {
            $data = array(
                'inv_id' => $this->input->post('inv_id'),
                'client_id' => $this->input->post('client_id'),
                'pack_size' => $this->input->post('packing_size'),
                'box_number' => $this->input->post('box_number'),
                'remarks' => $this->input->post('remarks'),
                'created_at' => date('Y-m-d h:i:s')
            );
            $this->um->insert_data($table, $data);
        }

        redirect('packing');
    }

    public function packing_product() {
        if (isset($_POST['rowsArray'])) {
            $last_id = $this->um->last_id('pack_id', 'packingnote');
            $product = $_POST['rowsArray'];
            $final_array = array_chunk($product, 12);
            foreach ($final_array as $info) {
                $data = array(
                    'pack_id' => $last_id,
                    'inv_prod_id' => $info[0],
                    'prod_id' => $info[2],
                    'order_qty' => $info[8],
                    'stock_qty' => $info[9],
                    'remain_qty' => $info[10],
                    'pack_qty' => $info[11]
                );
                $this->um->insert_data('packingnote_product', $data);

                echo 'ok';
            }
        }
    }

    public function packing_product_update() {
        if (isset($_POST['rowsArray'])) {
            $product = $_POST['rowsArray'];
            $final_array = array_chunk($product, 13);
            foreach ($final_array as $info) {
                $data = array(
                    'stock_qty' => $info[9],
                    'remain_qty' => $info[10],
                    'pack_qty' => $info[11]
                );
                $where = array('pack_prod_id' => $info[12]);
                $this->um->update_data('packingnote_product', $data, $where);

                echo 'ok';
            }
        }
    }

      public function get_invoice() {

        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->um->all_autocom($q, 'invoice', 'inv_number', 'inv_id');
        }
    }
    
}
