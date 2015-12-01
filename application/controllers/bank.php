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
class Bank extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        if (!$this->is_logged_in($this->session->userdata('logged_in'))) {
            redirect('login');
        }
        $this->load->model('user_model', 'um');
    }

    public function index() {
        $url = base_url('bank/index');
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
        $data['body'] = 'bank_list';
        $data['value'] = $this->um->get_data('conf_bank', $where, '', '', '', '', '', '', $limit, $start);
        $data['total'] = $this->um->get_data('conf_bank', $where, '', '', '');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function add_bank() {
        $data = array(
            'bank_name' => $this->input->post('bank_name'),
            'address' => $this->input->post('address'),
            'status' => 1
        );
        $table = 'conf_bank';
        $id = $this->um->insert_data($table, $data);
        $this->add_branch($id);
    }

    public function update_bank() {
        $data = array(
            'bank_name' => $this->input->post('bank_name'),
            'address' => $this->input->post('address')
        );
        $where = array(
            'id' => $this->input->post('bank_id')
        );
        $table = 'conf_bank';
        $this->um->update_data($table, $data, $where);
        $this->edit_branch($this->input->post('bank_id'));
    }

    public function add_branch($bank_id) {
        $bank_where = array('id' => $bank_id);
        $data['bank_info'] = $this->um->get_data('conf_bank', $bank_where);
        $data['body'] = 'v_bank_new';
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function edit_branch($bank_id) {
        $data['config'] = 'config';
        $bank_where = array('id' => $bank_id);
        $bank_info = $this->um->get_data('conf_bank', $bank_where);
        $branch_where = array('bank_id' => $bank_info[0]['id']);
        $branch_info = $this->um->get_data('conf_bank_branch', $branch_where);

        $data['branch_info'] = $branch_info;
        $data['bank_info'] = $bank_info;
        $data['body'] = 'edit_bank';
        $this->load->view('element/main_temp', $data);
    }

    public function save_branch() {
        $data = array(
            'bank_id' => $_POST['rowsArray'][0],
            'branch_name' => $_POST['rowsArray'][1],
            'address' => $_POST['rowsArray'][2],
            'contact_number' => $_POST['rowsArray'][3],
            'short_code' => $_POST['rowsArray'][4],
            'status' => $_POST['rowsArray'][5]
        );

        $table = 'conf_bank_branch';
        $id = $this->um->insert_data($table, $data);
        $where = array('id' => $id);
        $branch_info = $this->um->get_data($table, $where);
        echo json_encode($branch_info);
    }

    public function get_branch() {
        $table = 'conf_bank_branch';
        $where = array('id' => $_POST['id']);
        $branch_info = $this->um->get_data($table, $where);
        echo json_encode($branch_info);
    }

    public function get_bank() {
        $table = 'conf_bank';
        $where = array('id' => $_POST['id']);
        $bank_info = $this->um->get_data($table, $where);
        echo json_encode($bank_info);
    }

    public function get_account() {
        $table = 'conf_bank_branch_ac';
        $where = array('branch_id' => $_POST['id']);
        $bank_info = $this->um->get_data($table, $where);
        echo json_encode($bank_info);
    }

    public function save_account() {
        $product = $_POST['rowsArray'];
        $final_array = array_chunk($product, 4);
        foreach ($final_array as $info) {
            $data = array(
                'branch_id' => $_POST['rowsArray'][0],
                'account_name' => $info[1],
                'account_no' => $info[2],
                'status' => 1
            );
            $this->um->insert_data('conf_bank_branch_ac', $data);
            echo 'ok';
        }
    }

    public function update_account() {
        $product = $_POST['rowsArray'];
        $final_array = array_chunk($product, 6);
        foreach ($final_array as $info) {
            if ($info[1]) {
                $data = array(
                    'branch_id' => $_POST['rowsArray'][0],
                    'account_name' => $info[2],
                    'account_no' => $info[3],
                    'status' => $info[4]
                );
                $where=array('account_id'=>$info[1]);
                $this->um->update_data('conf_bank_branch_ac', $data,$where);
            } else {
                $data = array(
                    'branch_id' => $_POST['rowsArray'][0],
                    'account_name' => $info[2],
                    'account_no' => $info[3],
                    'status' => $info[4]
                );
                $this->um->insert_data('conf_bank_branch_ac', $data);
                echo 'ok';
            }
        }
    }

    public function branch_info_update() {
        if (isset($_POST['rowsArray'])) {

            $branch_info = $_POST['rowsArray']['skill'];
//            $check = $_POST['rowsArray']['check'];

            $final_array = array_chunk($branch_info, 7);
            foreach ($final_array as $info) {
                $data = array(
                    'branch_name' => $info[1],
                    'address' => $info[2],
                    'contact_number' => $info[3],
                    'short_code' => $info[4],
                    'status' => $info[5]
                );
                $where['id'] = $info[0];
                $this->um->update_data('conf_bank_branch', $data, $where);
                echo 'ok';
            }
        }
    }

    public function account_info_update() {
        if (isset($_POST['rowsArray'])) {

            $branch_info = $_POST['rowsArray']['account_info'];
//            $check = $_POST['rowsArray']['check'];

            $final_array = array_chunk($branch_info, 4);
            foreach ($final_array as $info) {
                $data = array(
                    'account_name' => $info[1],
                    'account_no' => $info[2],
                    'status' => $info[3]
                );
                $where['account_id'] = $info[0];
                $this->um->update_data('conf_bank_branch_ac', $data, $where);
                echo 'ok';
            }
        }
    }

}
