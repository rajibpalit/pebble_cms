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
class Shipment extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        if (!$this->is_logged_in($this->session->userdata('logged_in'))) {
            redirect('login');
        }
        $this->load->model('user_model', 'um');
    }

    public function index() {
        $data['body'] = 'shipment_list';
        $data['shipment'] = $this->um->get_data('shipment');
        $this->load->view('element/main_temp', $data);
    }

    public function edit_shipment($param = false) {

        $fwhere = array('key_name' => 'Freight Term');
        $data['freight_term'] = $this->um->get_data('const_keys', $fwhere, 'conf_keyword', 'key_id', 'key_id');

        $cwhere = array('key_name' => 'Country');
        $data['country'] = $this->um->get_data('const_keys', $cwhere, 'conf_keyword', 'key_id', 'key_id');

        $swhere = array('key_name' => 'Shipment Mode');
        $data['shipment_mode'] = $this->um->get_data('const_keys', $swhere, 'conf_keyword', 'key_id', 'key_id');

        $inwhere = array('status' => 1);
        $data['insurance_company'] = $this->um->get_data('conf_insurancecompany', $inwhere);


        if ($param != FALSE) {
            $where = array('shipment.ship_id' => $param);
            $data['shipment'] = $this->um->get_data('shipment', $where);

            $spwhere = array(
                'shipment_id' => $data['shipment'][0]['ship_id']
            );
            $invoices = $this->um->get_data('shipment_box', $spwhere);
            $data['shipment_box'] = $invoices;



            $invopro = array(
                'inv_id' => $data['shipment'][0]['invoice_id']
            );
            $invoi_pro = $this->um->get_data('packingnote', $invopro);
            $pano_product = array('pack_id' => $invoi_pro[0]['pack_id']);
            $data['packnot_pro'] = $this->um->get_data('packingnote_product', $pano_product);
        } 
        else {
            $iwhere = array(
                'inv_id' => $this->input->post('invoice_id')
            );
            $invoices = $this->um->get_data('invoice', $iwhere, 'conf_client', 'client_id', 'client_id');
            $data['invoices'] = $invoices;

            
            $invopro = array(
                'inv_id' => $this->input->post('invoice_id')
            );
            $invoi_pro = $this->um->get_data('packingnote', $invopro);
            
            $pano_product = array('pack_id' => $invoi_pro[0]['pack_id']);

            $data['packnot_pro'] = $this->um->get_data('packingnote_product', $pano_product);

            $data['invoi_pro'] = $invoi_pro;
        }

        $data['body'] = 'add_shipment';

        $this->load->view('element/main_temp', $data);
    }

    /* get information data from invoice table */

    public function get_invoice() {

        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->um->all_autocom($q, 'invoice', 'inv_number', 'inv_id');
        }
    }

    public function test_invoice(){
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->um->test_auto($q);
        }
    }

    public function inv_detail() {
        $where = array('inv_id' => $_POST['id']);
        $result = $this->um->get_data('invoice', $where, 'conf_client', 'client_id', 'client_id');
        $indate = date('Y-m-d', $result[0]['created_at']);
        $result[0]['invoice_date'] = $indate;
        echo json_encode($result[0]);
    }

    public function save_shipment() {
        $table = 'shipment';

        if ($this->input->post('shimpment_id')) {
            $data = array(
                'ship_mode_id' => $this->input->post('ship_mode'),
                'vessel_cargo' => $this->input->post('cargo'),
                'erc_no' => $this->input->post('ercno'),
                'export_no' => $this->input->post('exportno'),
                'export_date' => date('Y-m-d h:i:s',strtotime($this->input->post('exportdate'))),
                'insurance_company_id' => $this->input->post('insurence'),
                'insurance_cert_no' => $this->input->post('certification'),
                'freight_term_id' => $this->input->post('freight'),
                'sales_term' => $this->input->post('sales'),
                'container_no' => $this->input->post('container'),
                'mode' => $this->input->post('mode'),
                'seal_no' => $this->input->post('sale_no'),
                'country_of_origin_id' => $this->input->post('counrty'),
                'port_of_origin' => $this->input->post('port_origin'),
                'port_of_destination' => $this->input->post('port_dest'),
                'total_gross_wt' => $this->input->post('total_gross'),
                'total_net_wt' => $this->input->post('total_net'),
                'remarks' => $this->input->post('remarks'),
            );
            $where = array('ship_id' => $this->input->post('shimpment_id'));
            $this->um->update_data($table, $data, $where);
        } else {
            $data = array(
                'invoice_id' => $this->input->post('invoice_id'),
                'ship_mode_id' => $this->input->post('ship_mode'),
                'vessel_cargo' => $this->input->post('cargo'),
                'erc_no' => $this->input->post('ercno'),
                'export_no' => $this->input->post('exportno'),
                'export_date' => date('Y-m-d h:i:s', strtotime($this->input->post('exportdate'))),
                'insurance_company_id' => $this->input->post('insurence'),
                'insurance_cert_no' => $this->input->post('certification'),
                'freight_term_id' => $this->input->post('freight'),
                'sales_term' => $this->input->post('sales'),
                'container_no' => $this->input->post('container'),
                'mode' => $this->input->post('mode'),
                'seal_no' => $this->input->post('sale_no'),
                'country_of_origin_id' => $this->input->post('counrty'),
                'port_of_origin' => $this->input->post('port_origin'),
                'port_of_destination' => $this->input->post('port_dest'),
                'total_gross_wt' => $this->input->post('total_gross'),
                'total_net_wt' => $this->input->post('total_net'),
                'remarks' => $this->input->post('remarks'),
                'created_at' => date('Y-m-d h:i:s')
            );
            $this->um->insert_data($table, $data);
        }

        redirect('shipment');
    }

    public function box_info() {
        if (isset($_POST['rowsArray'])) {
            $last_id = $this->um->last_id('ship_id', 'shipment');
            $product = $_POST['rowsArray'];
            $final_array = array_chunk($product, 13);
            foreach ($final_array as $info) {
                $int = strtotime($info[3]);
                $date = date('Y-m-d', $int);
                $data = array(
                    'shipment_id' => $last_id,
                    'hs_code' => $info[0],
                    'box_number' => $info[1],
                    'agent_name' => $info[2],
                    'shipped_on_board' => $date,
                    'track_number' => $info[4],
                    'dimension_length' => $info[5],
                    'dimension_width' => $info[6],
                    'dimension_height' => $info[7],
                    'dimension_unit' => $info[8],
                    'weight_gross' => $info[9],
                    'weight_net' => $info[10],
                    'weight_unit' => $info[11]
                );
                $this->um->insert_data('shipment_box', $data);

                echo 'ok';
            }
        }
    }

    public function packing_product_update() {
        if (isset($_POST['rowsArray'])) {

            $product = $_POST['rowsArray'];
            $final_array = array_chunk($product, 14);
            foreach ($final_array as $info) {
                $int = strtotime($info[3]);
                $date = date('Y-m-d', $int);
                $data = array(
                    'hs_code' => $info[0],
                    'box_number' => $info[1],
                    'agent_name' => $info[2],
                    'shipped_on_board' => $date,
                    'track_number' => $info[4],
                    'dimension_length' => $info[5],
                    'dimension_width' => $info[6],
                    'dimension_height' => $info[7],
                    'dimension_unit' => $info[8],
                    'weight_gross' => $info[9],
                    'weight_net' => $info[10],
                    'weight_unit' => $info[11]
                );

                $where = array('ship_box_id' => $info[13]);
                $this->um->update_data('shipment_box', $data, $where);

                echo 'ok';
            }
        }
    }

}
