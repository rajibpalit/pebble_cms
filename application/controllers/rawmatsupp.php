<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of rawmatsupp
 *
 * @author ahossain
 */
class Rawmatsupp extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        if (!$this->is_logged_in($this->session->userdata('logged_in'))) {
            redirect('login');
        }
        $this->load->model('user_model', 'um');
    }

    public function index() {
        $data['config'] = $this->config;
        $data['body'] = 'rawmatsupp_list';
        $where = array('status' => 1);
        $data['suppliers'] = $this->um->get_data('conf_supplier', $where);
        $this->load->view('element/main_temp', $data);
    }

    public function add_romat_supp($param = FALSE) {
        $data['config'] = $this->config;
        if ($param != FALSE) {
            $supplier_con = array(
                'id' => $param,
                'status' => 1
            );
            $data['suppliers'] = $this->um->get_data('conf_supplier', $supplier_con);
            $supp_prod = array(
                'supplier_id' => $param
            );
            $data['sup_prod'] = $this->um->get_data('conf_supplier_rawmaterial', $supp_prod);
        }
        $data['body'] = 'add_rawmat_supp';
        $this->load->view('element/main_temp', $data);
    }

    public function product_info() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->um->all_autocom($q, 'conf_rawmaterial', 'material_code', 'id');
        }
    }

    public function all_produt_info() {
        if (isset($_POST['id'])) {
            $hwhere = array(
                'id' => $_POST['id']
            );
            $data = $this->um->get_data('conf_rawmaterial', $hwhere, 'conf_keyword', 'keyword_id', 'color_id');

            $where = array(
                'keyword_id' => $data[0]['size_id']
            );
            $size = $this->um->get_data('conf_keyword', $where);
            $mwhere = array(
                'keyword_id' => $data[0]['m_unit_id']
            );
            $mu_name = $this->um->get_data('conf_keyword', $mwhere);
            $data[0]['mu_name'] = $mu_name[0]['keyword_value'];
            $data[0]['size_name'] = $size[0]['keyword_value'];
            echo json_encode($data[0]);
        }
    }

    public function supplier_from() {
       if(isset($_POST['supplier_id'])){
           
           $where=array('id'=>$_POST['supplier_id']);
           $data=array(
               'supplier_name'=>$_POST['supplier_name'],
               'address'=>$_POST['address'],
               'phone_no'=>$_POST['contact_no'],
               'email'=>$_POST['email'],
               'fax'=>$_POST['fax'],
               'webaddress'=>$_POST['web'],
               'status'=>$_POST['status']
           );
           $this->update_data('conf_supplier',$data,$where);
       }
       else{
           $data=array(
               'supplier_name'=>$_POST['supplier_name'],
               'address'=>$_POST['address'],
               'phone_no'=>$_POST['contact_no'],
               'email'=>$_POST['email'],
               'fax'=>$_POST['fax'],
               'webaddress'=>$_POST['web'],
               'status'=>$_POST['status']
           );
           $this->um->insert_data('conf_supplier',$data);
       }
    }

    public function save_info() {
        if (isset($_POST['rowsArray'])) {
            $last_id = $this->um->last_id('id', 'conf_supplier');
            $product = $_POST['rowsArray'];
            $final_array = array_chunk($product, 12);
            foreach ($final_array as $info) {
                $data = array(
                    'supplier_id' => $last_id,
                    'material_id' => $info[1],
                    'unit_price' => $info[3],
                    'lead_time' => $info[4],
                    'm_unit_id' => $info[6],
                    'color_id' => $info[8],
                    'size_id' => $info[10],
                    'status' => 1
                );
                $last_id = $this->um->insert_data('conf_supplier_rawmaterial', $data);
            }
        }
        echo 'sucess';
    }

    public function update_info() {
        if (isset($_POST['rowsArray'])) {           
            $product = $_POST['rowsArray'];
            $final_array = array_chunk($product, 13);
            foreach ($final_array as $info) {                
                $where=array('id'=>$info[0]);                
                $data = array(                   
                    'material_id' => $info[2],
                    'unit_price' => $info[4],
                    'lead_time' => $info[5],
                    'm_unit_id' => $info[7],
                    'color_id' => $info[9],
                    'size_id' => $info[11],                    
                );
                $this->um->update_data('conf_supplier_rawmaterial', $data,$where);
            }
        }
        echo 'sucess';
    }

}
