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
class Payment extends CI_Controller {

    //put your code here

    public function __construct() {
        parent::__construct();
        if (!$this->is_logged_in($this->session->userdata('logged_in'))) {
            redirect('login');
        }
        $this->load->model('user_model', 'um');
    }

    public function index() {
        $data['body'] = 'payment_list';
        
//        $data['workorder'] = $this->um->get_data('workorder',FALSE,'invoice','inv_id','invoice_id');
        $this->load->view('element/main_temp', $data);
    }

  }
