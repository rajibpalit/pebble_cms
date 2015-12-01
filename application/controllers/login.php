<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Login extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('user_model');
        if ($this->is_logged_in($this->session->userdata('logged_in'))) {
            redirect('main');
        }
    }

    public function index() {
        $data['body'] = 'login_form';
        $this->load->view('element/login_temp', $data);
    }

    public function check_login() {
        $sdata = array();
        $login_id = $this->input->post('login_id');
        $password = $this->input->post('password');
        $where = array(
            'login_id' => $login_id,
            'password' => $password,
            'user_status' => 1
        );

        $result = $this->user_model->get_data('conf_user', $where, 'conf_contact', 'contact_id', 'user_id');
        if (count($result) == 1) {
            $sdata['login_id'] = $result[0]['user_id'];
            $sdata['user_name'] = $result[0]['first_name'].' '.$result[0]['last_name'];
            $sdata['logged_in'] = $result[0]['user_name'];
            $sdata['role'] = $result[0]['user_name'];
//            print_r($sdata);exit;
            $this->session->set_userdata($sdata);
            redirect("home");
        } else {
            $sdata['exception'] = " User Id & Password Invalid !";
            $this->session->set_userdata($sdata);
            redirect("login");
        }
    }

}
