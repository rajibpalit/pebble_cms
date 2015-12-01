<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Main extends CI_Controller {

    function __construct() {

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

    public function keyword($param = false) {
        $where = array();
        if ($param) {
            $where['keyword_id'] = $param;
            $data['keywords'] = $this->um->get_data('conf_keyword', $where);
        }
        $data['body'] = 'v_keyword';
        $order_field = 'key_name';
        $order = 'asc';
        $data['value'] = $this->um->get_data('const_keys', '', '', '', '', '', '', '', '', '', $order_field, $order);
        $data['config'] = $this->config;
        $this->load->view('element/main_temp', $data);
    }

    public function list_keyword() {
        $url = base_url('main/list_keyword');
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
        $data['body'] = 'v_keyword_list';
        $order_field = 'keyword_id';
        $order = 'desc';
        $data['value'] = $this->um->get_data('conf_keyword', $where, 'const_keys', 'key_id', 'key_id', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('conf_keyword', $where, 'const_keys', 'key_id', 'key_id');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function data_insert() {
        //starting for update data if have Keyword id
        if ($this->input->post('keyword_id')) {
            $data = array(
                'key_id' => $this->input->post('key_id'),
                'keyword_value' => $this->input->post('keyword_value'),
                'status' => $this->input->post('status')
            );
            $where = array(
                'keyword_id' => $this->input->post('keyword_id')
            );
            $id = $this->um->update_data('conf_keyword', $data, $where);
            $this->list_keyword();
        }
        // insert data
        else {
            $value = array(
                'key_id' => $this->input->post('key_id'),
                'keyword_value' => $this->input->post('keyword_value'),
                'status' => $this->input->post('status')
            );
            $id = $this->um->insert_data('conf_keyword', $value);
            $this->list_keyword();
        }
    }

    public function config() {
        $data['body'] = 'home';
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function change_password() {
        $data['body'] = 'change_password_form';
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function check_password() {
        if (isset($_POST['password'])) {
//            $password = $_POST['password'];
            $user_id = $this->session->userdata('login_id');
            $password = explode(" ", $_POST['password']);
            $current_password = $password[0];
            $new_password = $password[1];

            $where = array(
                'user_id' => $user_id
            );
            $result = $this->um->get_data('conf_user', $where);
            if (strcmp($current_password, $result[0]['password']) == 0) {

                $data1['password'] = $new_password;
                $data1['user_name'] = $result[0]['user_name'];
                $data1['login_id'] = $result[0]['login_id'];
                $data1['role'] = $result[0]['role'];
                $data1['comments'] = $result[0]['comments'];
                $data1['user_remarks'] = $result[0]['user_remarks'];
                $data1['user_status'] = $result[0]['user_status'];
                $this->um->update_data('conf_user', $data1, $where);
                echo json_encode(1);
            } else {
                echo json_encode(0);
            }
        }
    }

    /* show all data */

    public function contact($contact_id = FALSE) {
        $data['body'] = 'v_contact';
        $data['config'] = 'config';
        $title = array('key_name' => 'Title');
        $country = array('key_name' => 'Country');
        $division = array('key_name' => 'Division');
        $job_title = array('key_name' => 'Job Title');
        $job_status = array('key_name' => 'Job Status');
        $data['title'] = $this->um->get_data('const_keys', $title, 'conf_keyword', 'key_id', 'key_id');
        $data['countrys'] = $this->um->get_data('const_keys', $country, 'conf_keyword', 'key_id', 'key_id');
        $data['division'] = $this->um->get_data('const_keys', $division, 'conf_keyword', 'key_id', 'key_id');
        $data['job_title'] = $this->um->get_data('const_keys', $job_title, 'conf_keyword', 'key_id', 'key_id');
        $data['job_status'] = $this->um->get_data('const_keys', $job_status, 'conf_keyword', 'key_id', 'key_id');
        if ($contact_id != NULL) {
            $condition['contact_id'] = $contact_id;
            $data['keywords'] = $this->um->get_data('conf_contact', $condition);
        }
        $this->load->view('element/main_temp', $data);
    }

    public function add_contact() {
        // Update Data

        if ($this->input->post('contact_id')) {
            $data = array(
                'contact_type' => $this->input->post('contact_type'),
                'title' => $this->input->post('title'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'dob' => $this->input->post('dob'),
                'spouse_name' => $this->input->post('spouse_name'),
                'gender' => $this->input->post('gender'),
                'national_id' => $this->input->post('national_id'),
                'address' => $this->input->post('address'),
                'post_code' => $this->input->post('post_code'),
                'country' => $this->input->post('country'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'phone' => $this->input->post('phone'),
                'cell_no' => $this->input->post('cell_no'),
                'email' => $this->input->post('email'),
                'web_address' => $this->input->post('web_address'),
                'join_date' => $this->input->post('join_date'),
                'job_title' => $this->input->post('job_title'),
                'job_status' => $this->input->post('job_status'),
                'division' => $this->input->post('division'),
                'avg_working_capacity' => $this->input->post('avg_working_capacity'),
                'status' => $this->input->post('status'),
                'remarks' => $this->input->post('remarks')
            );
            $where = array(
                'contact_id' => $this->input->post('contact_id')
            );
            $id = $this->um->update_data('conf_contact', $data, $where);
            $this->contact_list();
        }
        // insert data
        else {
            $value = array(
                'contact_type' => $this->input->post('contact_type'),
                'title' => $this->input->post('title'),
                'first_name' => $this->input->post('first_name'),
                'last_name' => $this->input->post('last_name'),
                'dob' => $this->input->post('dob'),
                'spouse_name' => $this->input->post('spouse_name'),
                'gender' => $this->input->post('gender'),
                'national_id' => $this->input->post('national_id'),
                'address' => $this->input->post('address'),
                'post_code' => $this->input->post('post_code'),
                'country' => $this->input->post('country'),
                'city' => $this->input->post('city'),
                'state' => $this->input->post('state'),
                'phone' => $this->input->post('phone'),
                'cell_no' => $this->input->post('cell_no'),
                'email' => $this->input->post('email'),
                'web_address' => $this->input->post('web_address'),
                'join_date' => $this->input->post('join_date'),
                'job_title' => $this->input->post('job_title'),
                'job_status' => $this->input->post('job_status'),
                'division' => $this->input->post('division'),
                'avg_working_capacity' => $this->input->post('avg_working_capacity'),
                'status' => $this->input->post('status'),
                'remarks' => $this->input->post('remarks')
            );
            $id = $this->um->insert_data('conf_contact', $value);
            $this->contact_list();
        }
    }

    public function contact_list() {
        $url = base_url('main/contact_list');
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
        $order_field = 'contact_id';
        $order = 'desc';
        $data['body'] = 'contact_list';
        $data['value'] = $this->um->get_data('conf_contact', $where, '', '', '', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('conf_contact');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function currency($currency_id = FALSE) {

        $data['body'] = 'currency';
        $data['config'] = 'config';
//        $where = array('status' => 1);
        $mu_form = array(
            'key_name' => 'Country'
        );
        $data['countrys'] = $this->um->get_data('conf_keyword', $mu_form, 'const_keys', 'key_id', 'key_id');
        if ($currency_id != FALSE) {
            $condition['currency_id'] = $currency_id;
            $data['value'] = $this->um->get_data('conf_currency', $condition, 'conf_keyword', 'keyword_id', 'country', '', '', '');

//            $data['value'] = $this->um->get_data('conf_currency', $where, 'conf_keyword', 'keyword_id', 'country', '', '', '');
        }

        $this->load->view('element/main_temp', $data);
    }

    public function add_currency() {
        if ($this->input->post('currency_id')) {
            $data = array(
                'currency_name' => $this->input->post('currency_name'),
                'short_form' => $this->input->post('short_form'),
                'symbol_text' => $this->input->post('symbol_text'),
                'country' => $this->input->post('country'),
                'fractional_unit' => $this->input->post('fractional_unit'),
                'is_base' => $this->input->post('is_base'),
                'status' => $this->input->post('status')
            );

            $where = array(
                'currency_id' => $this->input->post('currency_id')
            );
            $id = $this->um->update_data('conf_currency', $data, $where);
            $this->currency_list();
        }
        // insert data
        else {
            $value = array(
                'currency_name' => $this->input->post('currency_name'),
                'short_form' => $this->input->post('short_form'),
                'symbol_text' => $this->input->post('symbol_text'),
                'country' => $this->input->post('country'),
                'fractional_unit' => $this->input->post('fractional_unit'),
                'is_base' => $this->input->post('is_base'),
                'status' => $this->input->post('status')
            );
            $id = $this->um->insert_data('conf_currency', $value);
            $this->currency_list();
        }
    }

    public function currency_list() {
        $url = base_url('main/currency_list');
        $where = array();
        $limit = $this->limit;
//        print_r($limit)
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
        $order_field = 'currency_id';
        $order = 'desc';
        $data['body'] = 'currency_list';
        $data['value'] = $this->um->get_data('conf_currency', $where, 'conf_keyword', 'keyword_id', 'country', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('conf_currency', $where, 'conf_keyword', 'keyword_id', 'country');
        $total = count($data['total']);
//        $data['value'] = $this->um->get_data('conf_currency', $where, 'conf_keyword', 'keyword_id', 'country', '', '', '', $limit, $total-$limit);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function exchange_rate($exchange_id = FALSE) {
        $data['body'] = 'exchange_rate';
        $data['config'] = 'config';
        $data['exchange_name'] = $this->um->get_data('conf_currency');
        $where = array('is_base' => 1);
        $data['base'] = $this->um->get_data('conf_currency', $where);
        if ($exchange_id != NULL) {
            $condition['exchange_id'] = $exchange_id;
            $data['exchange'] = $this->um->get_data('conf_exchangerate', $condition, '', '', '');
        }
        $this->load->view('element/main_temp', $data);
    }

    public function add_exchange_rate() {
        if ($this->input->post('exchange_id')) {
            $data = array(
                'currency_from' => $this->input->post('currency_from'),
                'currency_to' => $this->input->post('currency_to'),
                'exchange_rate' => $this->input->post('rate'),
                'exchange_date' => $this->input->post('date'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $where = array(
                'exchange_id' => $this->input->post('exchange_id')
            );
            $id = $this->um->update_data('conf_exchangerate', $data, $where);
            $this->exchange_rates_list();
        }
        // insert data
        else {
            $value = array(
                'currency_from' => $this->input->post('currency_from'),
                'currency_to' => $this->input->post('currency_to'),
                'exchange_rate' => $this->input->post('rate'),
                'exchange_date' => $this->input->post('date'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $id = $this->um->insert_data('conf_exchangerate', $value);
            $this->exchange_rates_list();
        }
    }

    public function exchange_rates_list() {
        $url = base_url('main/exchange_rates_list');
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
        $order_field = 'exchange_id';
        $order = 'desc';
        $data['body'] = 'exchange_rate_list';
        $data['value'] = $this->um->get_data('conf_currency', $where, 'conf_exchangerate', 'currency_from', 'currency_id', '', '', '', $limit, $start, $order_field, $order);
        $data['value1'] = $this->um->get_data('conf_currency', $where, 'conf_exchangerate', 'currency_to', 'currency_id', '', '', '', $limit, $start);
        $data['total'] = $this->um->get_data('conf_exchangerate', $where, '', '', '');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function client($client_id = FALSE) {
        $data['body'] = 'client';
        $data['config'] = 'config';
        $where = array('status' => 1);
//  $where = array('currency_id' => 1);
        $mu_form = array('key_name' => 'Country');
        $data['countrys'] = $this->um->get_data('conf_keyword', $mu_form, 'const_keys', 'key_id', 'key_id');
        $data['currencys'] = $this->um->get_data('conf_currency', $where);
        if ($client_id != FALSE) {
            $condition['client_id'] = $client_id;
            $data['keywords'] = $this->um->get_data('conf_client', $condition, 'conf_keyword', 'keyword_id', 'country', 'conf_currency', 'currency_id', 'currency');
        }
        $this->load->view('element/main_temp', $data);
    }

    public function client_list() {
        $url = base_url('main/client_list');
        $data['config'] = 'config';
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
        $order_field = 'client_id';
        $order = 'desc';
        $data['body'] = 'client_list';
        $data['value'] = $this->um->get_data('conf_client', $where, 'conf_keyword', 'keyword_id', 'country', 'conf_currency', 'currency_id', 'currency', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('conf_client', $where, 'conf_keyword', 'keyword_id', 'country', '', '', '');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function add_client() {
        if ($this->input->post('client_id')) {
            $data = array(
                'client_name' => $this->input->post('client_name'),
                'contact_name' => $this->input->post('contact_name'),
                'shipping_address' => $this->input->post('shipping_address'),
                'mobile_no' => $this->input->post('mobile_no'),
                'home_phone' => $this->input->post('home_phone'),
                'email' => $this->input->post('email'),
                'vat_no' => $this->input->post('vat_no'),
                'country' => $this->input->post('country'),
                'currency' => $this->input->post('currency_id'),
                'invoice_prefix' => $this->input->post('prefix'),
                'last_invoice' => $this->input->post('last_invoice'),
                'status' => $this->input->post('status')
            );
            $where = array(
                'client_id' => $this->input->post('client_id')
            );
            $id = $this->um->update_data('conf_client', $data, $where);
            $this->client_list();
        }
        // insert data
        else {
            $value = array(
                'client_name' => $this->input->post('client_name'),
                'contact_name' => $this->input->post('contact_name'),
                'shipping_address' => $this->input->post('shipping_address'),
                'mobile_no' => $this->input->post('mobile_no'),
                'home_phone' => $this->input->post('home_phone'),
                'email' => $this->input->post('email'),
                'vat_no' => $this->input->post('vat_no'),
                'country' => $this->input->post('country'),
                'currency' => $this->input->post('currency_id'),
                'invoice_prefix' => $this->input->post('prefix'),
                'last_invoice' => $this->input->post('last_invoice'),
                'status' => $this->input->post('status')
            );
            $id = $this->um->insert_data('conf_client', $value);
            $this->client_list();
        }
    }

    public function mu_list($id = false) {

        $url = base_url('main/mu_list');
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
        $order_field = 'id';
        $order = 'desc';
        $data['body'] = 'mu_list';
        $data['value_from'] = $this->um->get_data('conf_muconversion', '', 'conf_keyword', 'keyword_id', 'mu_from', '', '', '', $limit, $start, $order_field, $order);
        $data['value_to'] = $this->um->get_data('conf_muconversion', '', 'conf_keyword', 'keyword_id', 'mu_to');


        $data['total'] = $this->um->get_data('conf_muconversion', '', 'conf_keyword', 'keyword_id', 'mu_from');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function add_mu_conversion($id = FALSE) {
        $data['body'] = 'v_mu_conversion';
        $data['config'] = 'config';
        $mu_form = array('key_name' => 'Measurement unit');
        $data['mu'] = $this->um->get_data('conf_keyword', $mu_form, 'const_keys', 'key_id', 'key_id');
        if ($id != FALSE) {
            $where = array('id' => $id);
            $data['value_from'] = $this->um->get_data('conf_muconversion', $where, 'conf_keyword', 'keyword_id', 'mu_from');
            $data['value_to'] = $this->um->get_data('conf_muconversion', $where, 'conf_keyword', 'keyword_id', 'mu_to');
        }
        $this->load->view('element/main_temp', $data);
    }

    public function add_mu() {
        if ($this->input->post('id')) {
            $data = array(
                'mu_from' => $this->input->post('mu_from'),
                'mu_to' => $this->input->post('mu_to'),
                'quantity' => $this->input->post('quantity'),
                'status' => $this->input->post('status'),
            );
            $where = array(
                'id' => $this->input->post('id')
            );
            $id = $this->um->update_data('conf_muconversion', $data, $where);
            $this->mu_list();
        }
        // insert data
        else {
            $value = array(
                'mu_from' => $this->input->post('mu_from'),
                'mu_to' => $this->input->post('mu_to'),
                'quantity' => $this->input->post('quantity'),
                'status' => $this->input->post('status'),
            );
            $id = $this->um->insert_data('conf_muconversion', $value);
            $this->mu_list();
        }
    }

    public function skill($skill_id = FALSE) {
        $data['body'] = 'v_skill';
        $data['config'] = 'config';
        if ($skill_id != NULL) {
            $condition['id'] = $skill_id;
            $data['skills'] = $this->um->get_data('conf_skills', $condition, '', '', '');
        }

        $this->load->view('element/main_temp', $data);
    }

    public function add_skills() {
        if ($this->input->post('id')) {
            $data = array(
                'description' => $this->input->post('description'),
                'associated_action' => $this->input->post('associated_action'),
                'status' => $this->input->post('status')
            );
            $where = array(
                'id' => $this->input->post('id')
            );
            $id = $this->um->update_data('conf_skills', $data, $where);
            $this->skill_list();
        }
        // insert data
        else {
            $value = array(
                'description' => $this->input->post('description'),
                'associated_action' => $this->input->post('associated_action'),
                'status' => $this->input->post('status')
            );
            $id = $this->um->insert_data('conf_skills', $value);
            $this->skill_list();
        }
    }

    public function skill_list() {
        $url = base_url('main/skill_list');
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
        $order_field = 'id';
        $order = 'desc';
        $data['body'] = 'v_skills_list';
        $data['value'] = $this->um->get_data('conf_skills', $where, '', '', '', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('conf_skills', $where, '', '', '');
//                echo '<pre>';
//         print_r($data);
//        echo '</pre>';
//        exit();
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function user($user_id = FALSE) {
        $data['body'] = 'v_user';
        $data['config'] = 'config';
        $where = array('status' => 1);
        $data['users'] = $this->um->get_data('conf_contact', $where);
        $data['roles'] = $this->um->get_data('conf_roles', $where);
        if ($user_id != NULL) {
            $condition['user_id'] = $user_id;
            $data['value'] = $this->um->get_data('conf_user', $condition, 'conf_contact', 'contact_id', 'user_id');
        }
        $this->load->view('element/main_temp', $data);
    }

    public function users_list() {
        $url = base_url('main/users_list');
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
            if ($this->input->post('user_status')) {
                $where['user_status'] = $this->input->post('user_status');
            }
        }
        $order_field = 'user_id';
        $order = 'desc';
        $data['body'] = 'v_user_list';
        $data['value'] = $this->um->get_data('conf_user', $where, 'conf_contact', 'contact_id', 'user_name', 'conf_roles', 'role_id', 'role', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('conf_user', $where, '', '', '');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function add_user() {
        if ($this->input->post('user_id')) {
            $data = array(
                'login_id' => $this->input->post('login_id'),
                'user_name' => $this->input->post('user_name'),
                'role' => $this->input->post('role'),
                'password' => $this->input->post('password'),
                'comments' => $this->input->post('comments'),
                'user_remarks' => $this->input->post('user_remarks'),
                'user_status' => $this->input->post('user_status')
            );
            $where = array(
                'user_id' => $this->input->post('user_id')
            );
            $id = $this->um->update_data('conf_user', $data, $where);
            $this->users_list();
        }
        // insert data
        else {
            $value = array(
                'login_id' => $this->input->post('login_id'),
                'user_name' => $this->input->post('user_name'),
                'role' => $this->input->post('role'),
                'password' => $this->input->post('password'),
                'comments' => $this->input->post('comments'),
                'user_remarks' => $this->input->post('user_remarks'),
                'user_status' => $this->input->post('user_status')
            );
            $id = $this->um->insert_data('conf_user', $value);
            $this->users_list();
        }
    }

    public function insurance_company($id = FALSE) {
        $data['body'] = 'v_insurance_company';
        $data['config'] = 'config';
        $where = array('status' => 1);
        $mu_form = array(
            'key_name' => 'Country'
        );
        $data['countrys'] = $this->um->get_data('conf_keyword', $mu_form, 'const_keys', 'key_id', 'key_id');
        if ($id != NULL) {
            $condition['id'] = $id;
            $data['value'] = $this->um->get_data('conf_insurancecompany', $condition, '', '', '');
        }
        $this->load->view('element/main_temp', $data);
    }

    public function insurance_companies_list() {
        $url = base_url('main/insurance_companies_list');
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
        $order_field = 'id';
        $order = 'desc';
        $data['body'] = 'v_insurance_companies_list';
        $data['value'] = $this->um->get_data('conf_insurancecompany', $where, '', '', '', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('conf_insurancecompany', $where, '', '', '');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function add_insurance_company() {
        if ($this->input->post('id')) {
            $data = array(
                'company_name' => $this->input->post('company_name'),
                'address' => $this->input->post('address'),
                'country_id' => $this->input->post('country_id'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $where = array(
                'id' => $this->input->post('id')
            );
            $id = $this->um->update_data('conf_insurancecompany', $data, $where);
            $this->insurance_companies_list();
        }
        // insert data
        else {
            $value = array(
                'company_name' => $this->input->post('company_name'),
                'address' => $this->input->post('address'),
                'country_id' => $this->input->post('country_id'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $id = $this->um->insert_data('conf_insurancecompany', $value);
            $this->insurance_companies_list();
        }
    }

    public function mail($id = FALSE) {
        $data['body'] = 'v_mail';
        $data['config'] = 'config';
        if ($id != NULL) {
            $condition['id'] = $id;
            $data['value'] = $this->um->get_data('conf_mailformat', $condition, '', '', '');
        }
        $this->load->view('element/main_temp', $data);
    }

    public function mail_list() {
        $url = base_url('main/mail_list');
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
        $order_field = 'id';
        $order = 'desc';
        $data['body'] = 'v_mail_list';
        $data['value'] = $this->um->get_data('conf_mailformat', $where, '', '', '', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('conf_mailformat', $where, '', '', '');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function add_mail() {
        if ($this->input->post('id')) {
            $data = array(
                'mail_subject' => $this->input->post('mail_subject'),
                'mail_text' => $this->input->post('mail_text'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $where = array(
                'id' => $this->input->post('id')
            );
            $id = $this->um->update_data('conf_mailformat', $data, $where);
            $this->mail_list();
        }
        // insert data
        else {
            $value = array(
                'mail_subject' => $this->input->post('mail_subject'),
                'mail_text' => $this->input->post('mail_text'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $id = $this->um->insert_data('conf_mailformat', $value);
            $this->mail_list();
        }
    }

    public function payment_mode($id = FALSE) {
        $data['body'] = 'v_payment';
        $data['config'] = 'config';
        if ($id != NULL) {
            $condition['id'] = $id;
            $data['value'] = $this->um->get_data('conf_paymentmode', $condition, '', '', '');
        }
        $this->load->view('element/main_temp', $data);
    }

    public function payment_list() {
        $url = base_url('main/payment_list');
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
        $order_field = 'exchange_id';
        $order = 'desc';
        $data['body'] = 'v_payment_list';
        $data['value'] = $this->um->get_data('conf_paymentmode', $where, '', '', '', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('conf_paymentmode', $where, '', '', '');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function add_payment() {
        if ($this->input->post('id')) {
            $data = array(
                'payment_mode' => $this->input->post('payment_mode'),
                'description' => $this->input->post('description'),
                'payment_particular' => $this->input->post('payment_particular'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $where = array(
                'id' => $this->input->post('id')
            );
            $id = $this->um->update_data('conf_paymentmode', $data, $where);
            $this->payment_list();
        }
        // insert data
        else {
            $value = array(
                'payment_mode' => $this->input->post('payment_mode'),
                'description' => $this->input->post('description'),
                'payment_particular' => $this->input->post('payment_particular'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $id = $this->um->insert_data('conf_paymentmode', $value);
            $this->payment_list();
        }
    }

    public function rural_center($id = FALSE) {
        $data['body'] = 'v_rural_center';
        $data['config'] = 'config';
        if ($id != NULL) {
            $condition['id'] = $id;
            $where = array('ruralcenter_id' => $id);
            $data['value'] = $this->um->get_data('conf_ruralcenter', $condition, '', '', '');
            $data['products'] = $this->um->get_data('conf_ruralcenter_product', $where);
            $data['skills'] = $this->um->get_data('conf_ruralcenter_skill', $where);
        }
        $this->load->view('element/main_temp', $data);
    }

    public function rural_info() {
        if (isset($_POST['rowsArray'])) {
            $last_id = $this->um->last_id('id', 'conf_ruralcenter');
            $product = $_POST['rowsArray']['product'];
            $skill = $_POST['rowsArray']['skill'];
            $final_array = array_chunk($product, 4);
            foreach ($final_array as $info) {
                $data = array(
                    'product_id' => $info[0],
                    'ruralcenter_id' => $last_id,
                    'product_code' => $info[2]
                );
                $this->um->insert_data('conf_ruralcenter_product', $data);

                echo 'ok';
            }
            $final_array1 = array_chunk($skill, 9);
            foreach ($final_array1 as $info) {
                $data = array(
                    'skill_id' => $info[0],
                    'ruralcenter_id' => $last_id,
                    'supervisor' => $info[2],
                    'artisan_capacity' => $info[3],
                    'hour_capacity' => $info[4],
                    'hourly_rate' => $info[5],
                    'basic_skill' => $info[6]
                );
                $this->um->insert_data('conf_ruralcenter_skill', $data);

                echo 'ok';
            }
        }
    }

    public function rural_info_update() {
        if (isset($_POST['rowsArray'])) {
            //$last_id = $this->um->last_id('id', 'conf_ruralcenter');
            $product = $_POST['rowsArray']['product'];
            $skill = $_POST['rowsArray']['skill'];
            $check = $_POST['rowsArray']['check'];
            $value = $check['id'];
//            print_r($value); exit;
            $where['ruralcenter_id'] = $value;
            $check_info1 = $this->um->get_data('conf_ruralcenter_skill', $where);
            $check_info2 = $this->um->get_data('conf_ruralcenter_product', $where);
//            print_r($check_info2); exit;
            $final_array = array_chunk($product, 6);
            foreach ($final_array as $info) {
                if (empty($check_info2)) {
                    $data = array(
                        'product_id' => $info[0],
                        'product_code' => $info[2],
                        'ruralcenter_id' => $value
                    );
//                    print_r( $data); exit;
                    $this->um->insert_data('conf_ruralcenter_product', $data);

                    echo 'ok';
                } else if ($info[4]) {
                    $data = array(
                        'product_id' => $info[0],
                        'product_code' => $info[2]
                    );
                    $where['id'] = $info[4];
                    $this->um->update_data('conf_ruralcenter_product', $data, $where);

                    echo 'ok';
                } else {
                    $data = array(
                        'product_id' => $info[0],
                        'product_code' => $info[2],
                        'ruralcenter_id' => $info[5]
                    );
                    $this->um->insert_data('conf_ruralcenter_product', $data);

                    echo 'ok';
                }
            }
            $final_array1 = array_chunk($skill, 11);
            foreach ($final_array1 as $info) {
                if (empty($check_info1)) {
                    $data = array(
                        'skill_id' => $info[0],
                        'supervisor' => $info[2],
                        'artisan_capacity' => $info[3],
                        'hour_capacity' => $info[4],
                        'hourly_rate' => $info[5],
                        'basic_skill' => $info[6],
                        'ruralcenter_id' => $value
                    );
                    $this->um->insert_data('conf_ruralcenter_skill', $data);

                    echo 'ok';
                } else if ($info[9]) {
                    $data = array(
                        'skill_id' => $info[0],
                        'supervisor' => $info[2],
                        'artisan_capacity' => $info[3],
                        'hour_capacity' => $info[4],
                        'hourly_rate' => $info[5],
                        'basic_skill' => $info[6]
                    );
                    $where['id'] = $info[9];
                    $this->um->update_data('conf_ruralcenter_skill', $data, $where);

                    echo 'ok';
                } else {
                    $data = array(
                        'skill_id' => $info[0],
                        'supervisor' => $info[2],
                        'artisan_capacity' => $info[3],
                        'hour_capacity' => $info[4],
                        'hourly_rate' => $info[5],
                        'basic_skill' => $info[6],
                        'ruralcenter_id' => $info[10]
                    );
                    $this->um->insert_data('conf_ruralcenter_skill', $data);

                    echo 'ok';
                }
            }
        }
    }

    public function skill_info() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $where = array('status' => 1);
            $this->um->all_autocom_con($q, 'conf_skills', 'associated_action', 'id', $where);
        }
    }

    public function product_info() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $where = array('status' => 1);
            $this->um->all_autocom_con($q, 'conf_product', 'product_name', 'id', $where);
        }
    }

    public function action_info() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $where = array('status' => 1);
            $this->um->all_autocom_con($q, 'conf_productactions', 'action_name', 'id', $where);
        }
    }

    public function all_produt_info() {
        if (isset($_POST['id'])) {
            $product_id = $_POST['id'];
            $where = array('id' => $product_id);
            $result = $this->um->get_data('conf_product', $where);
//            print_r($result);
            echo json_encode($result[0]);
        }
    }

    public function rural_center_list() {
        $url = base_url('main/rural_center_list');
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
        $order_field = 'id';
        $order = 'desc';
        $data['body'] = 'v_rural_center_list';
        $data['value'] = $this->um->get_data('conf_ruralcenter', $where, '', '', '', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('conf_ruralcenter', $where, '', '', '');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function add_rural_center() {
        if ($this->input->post('id')) {
            $data = array(
                'center_name' => $this->input->post('center_name'),
                'address' => $this->input->post('address'),
                'artisan_capacity' => $this->input->post('artisan_capacity'),
                'hour_capacity' => $this->input->post('hour_capacity'),
                'hourly_rate' => $this->input->post('hourly_rate'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $where = array(
                'id' => $this->input->post('id')
            );
            $id = $this->um->update_data('conf_ruralcenter', $data, $where);
            $this->rural_center_list();
        }
        // insert data
        else {
            $value = array(
                'center_name' => $this->input->post('center_name'),
                'address' => $this->input->post('address'),
                'artisan_capacity' => $this->input->post('artisan_capacity'),
                'hour_capacity' => $this->input->post('hour_capacity'),
                'hourly_rate' => $this->input->post('hourly_rate'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $id = $this->um->insert_data('conf_ruralcenter', $value);
            $this->rural_center_list();
        }
    }

    public function raw_material($id = FALSE) {
        $data['body'] = 'v_raw_material';
        $data['config'] = 'config';
        $where = array('raw_status' => 1);

        $mu_form = array(
            'key_name' => 'Material Type'
        );
        $data['materials_type'] = $this->um->get_data('conf_keyword', $mu_form, 'const_keys', 'key_id', 'key_id');
        $mu_form = array(
            'key_name' => 'Size'
        );
        $data['sizes'] = $this->um->get_data('conf_keyword', $mu_form, 'const_keys', 'key_id', 'key_id');
        $mu_form = array(
            'key_name' => 'Color'
        );
        $data['colors'] = $this->um->get_data('conf_keyword', $mu_form, 'const_keys', 'key_id', 'key_id');
        $mu_form = array(
            'key_name' => 'Measurement unit'
        );
        $data['mus'] = $this->um->get_data('conf_keyword', $mu_form, 'const_keys', 'key_id', 'key_id');
        if ($id != FALSE) {
            $condition['id'] = $id;
            $data['value'] = $this->um->get_data('conf_rawmaterial', $condition, 'conf_keyword', 'keyword_id', 'material_type_id', '', '', '');
            $data['value1'] = $this->um->get_data('conf_rawmaterial', $condition, 'conf_keyword', 'keyword_id', 'size_id', '', '', '');
            $data['value2'] = $this->um->get_data('conf_rawmaterial', $condition, 'conf_keyword', 'keyword_id', 'color_id', '', '', '');
            $data['value3'] = $this->um->get_data('conf_rawmaterial', $condition, 'conf_keyword', 'keyword_id', 'm_unit_id', '', '', '');
        }
        $this->load->view('element/main_temp', $data);
    }

    public function raw_material_list() {
        $url = base_url('main/raw_material_list');
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
        $order_field = 'exchange_id';
        $order = 'desc';
        $data['body'] = 'v_raw_material_list';
        $data['value'] = $this->um->get_data('conf_keyword', $where, 'conf_rawmaterial', 'color_id', 'keyword_id', 'const_keys', 'key_id', 'key_id', $limit, $start);
//        $data['value'] = $this->um->get_data('conf_rawmaterial', $where, 'conf_keyword', 'keyword_id', 'color_id', 'const_keys', 'key_id', 'key_id', $limit, $start);
        $data['value1'] = $this->um->get_data('conf_keyword', $where, 'conf_rawmaterial', 'size_id', 'keyword_id', 'const_keys', 'key_id', 'key_id', $limit, $start);
        $data['value2'] = $this->um->get_data('conf_keyword', $where, 'conf_rawmaterial', 'material_type_id', 'keyword_id', 'const_keys', 'key_id', 'key_id', $limit, $start);
        $data['value3'] = $this->um->get_data('conf_keyword', $where, 'conf_rawmaterial', 'm_unit_id', 'keyword_id', 'const_keys', 'key_id', 'key_id', $limit, $start);
//        $data['value'] = $this->um->get_data('conf_user', $where, 'conf_contact', 'contact_id', 'user_name', 'conf_roles', 'role_id', 'role', $limit, $start);
        $data['total'] = $this->um->get_data('conf_user', $where, '', '', '');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function add_raw_material() {
        if ($this->input->post('id')) {
            $data = array(
                'material_code' => $this->input->post('material_code'),
                'material_name' => $this->input->post('material_name'),
                'material_type_id' => $this->input->post('material_type_id'),
                'size_id' => $this->input->post('size_id'),
                'color_id' => $this->input->post('color_id'),
                'm_unit_id' => $this->input->post('m_unit_id'),
                'reorder_level' => $this->input->post('reorder_level'),
                'raw_remarks' => $this->input->post('raw_remarks'),
                'raw_status' => $this->input->post('raw_status')
            );
            $where = array(
                'id' => $this->input->post('id')
            );
            $id = $this->um->update_data('conf_rawmaterial', $data, $where);
            $this->raw_material_list();
        }
        // insert data
        else {
            $value = array(
                'material_code' => $this->input->post('material_code'),
                'material_name' => $this->input->post('material_name'),
                'material_type_id' => $this->input->post('material_type_id'),
                'size_id' => $this->input->post('size_id'),
                'color_id' => $this->input->post('color_id'),
                'm_unit_id' => $this->input->post('m_unit_id'),
                'reorder_level' => $this->input->post('reorder_level'),
                'raw_remarks' => $this->input->post('raw_remarks'),
                'raw_status' => $this->input->post('raw_status')
            );
            $id = $this->um->insert_data('conf_rawmaterial', $value);
            $this->raw_material_list();
        }
    }

    public function production_action() {
        $data['body'] = 'v_production_action';
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function add_product($id = false) {
        $data['body'] = 'v_add_product';
        if ($id != false) {
            $where = array('id' => $id);
            $rawwhere = array('product_id' => $id);
            $data['product'] = $this->um->get_data('conf_product', $where);
            $data['rawmaterial'] = $this->um->get_data('conf_product_rawmaterials', $rawwhere, 'conf_keyword', 'keyword_id', 'color_id');
//        $data['rawmaterial1'] = $this->um->get_data('conf_product_rawmaterials', $where, 'conf_keyword', 'keyword_id', 'size_id');
            $data['clientrate'] = $this->um->get_data('conf_product_clientrate', $rawwhere);
            $data['product_part'] = $this->um->get_data('conf_product_parts', $rawwhere);
//          print_r( $data['product_part'] );
        }
        $color = array('key_id' => 3);
        $size = array('key_id' => 4);
        $flow = array('key_id' => 5);
//                $skill = array('key_id' => 15);
        $data['color'] = $this->um->get_data('conf_keyword', $color);
        $data['size'] = $this->um->get_data('conf_keyword', $size);
        $data['skill'] = $this->um->get_data('conf_skills');
        $data['flow'] = $this->um->get_data('conf_keyword', $flow);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function flow_action($id = FALSE) {
        $data['body'] = 'v_flow_action';
        $where['key_id'] = 5;
        $data['flow_names'] = $this->um->get_data('conf_keyword', $where);
        if ($id != NULL) {
            $condition['id'] = $id;
            $where = array('flow_action_id' => $id);
            $data['value'] = $this->um->get_data('conf_flowaction', $condition, '', '', '');
            $data['conf_flowaction_actions'] = $this->um->get_data('conf_flowaction_actions', $where);
        }
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function save_flow_action() {
        if ($this->input->post('f_action_id')) {
            $data = array(
                'flow_name' => $this->input->post('flow_name'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $f_action_id = $this->input->post('f_action_id');
            $where['id'] = $f_action_id;
            $id = $this->um->update_data('conf_flowaction', $data, $where);
            $this->flow_action_list();
        }
        // insert data
        else {
            $value = array(
                'flow_name' => $this->input->post('flow_name'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $id = $this->um->insert_data('conf_flowaction', $value);
            $this->flow_action_list();
        }
    }

    public function flow_action_list() {
        $url = base_url('main/flow_action_list');
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
        $order_field = 'conf_flowaction_actions.id';
        $order = 'desc';
        $data['body'] = 'v_flow_action_list';
        $data['value'] = $this->um->get_data('conf_flowaction_actions', $where, 'conf_flowaction', 'id', 'flow_action_id', 'conf_productactions', 'id', 'action_name', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('conf_flowaction_actions', $where, 'conf_flowaction', 'id', 'flow_action_id');
//        print_r($data['total']);exit;
        $i = 0;
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function save_and_update_flow_info() {
        if (isset($_POST['rowsArray'])) {
            $flow_actions = $_POST['rowsArray']['flow_actions'];
            $product_action = $_POST['rowsArray']['product_action'];
            $value = $product_action['product_action_id'];
//            $update_flow_info = $_POST['rowsArray'];
            $final_array = array_chunk($flow_actions, 7);
            foreach ($final_array as $info) {
                if ($info[5]) {
                    $data = array(
                        'order' => $info[2],
                        'qc' => $info[3],
                        'remarks' => $info[4]
                    );
                    $where = $info[5];
                    $this->um->update_data('conf_flowaction_actions', $data, $where);

                    echo 'ok';
                } else {
                    $data = array(
                        'flow_action_id' => $value,
                        'action_name' => $info[1],
                        'order' => $info[2],
                        'qc' => $info[3],
                        'remarks' => $info[4]
                    );
                    $this->um->insert_data('conf_flowaction_actions', $data);

                    echo 'ok';
                }
            }
        }
    }

    public function ajax_data() {
//        $this->setOutputMode(NORMAL);
        $country_id = $_POST['id'];
        $table = 'conf_currency';
        $where = array('country' => $country_id);
        $country_name = $this->um->get_data($table, $where);
//        print_r($country_name);exit;
        echo json_encode($country_name[0]);
//      
    }

    public function ajax_data_user() {
//        $this->setOutputMode(NORMAL);
        $email = $_POST['email'];
        $where = array('email' => $email);
        $country_name = $this->um->get_data('conf_contact', $where);
        echo json_encode($country_name[0]);
//      
    }

    public function email_search() {
//        $this->setOutputMode(NORMAL);
        $email = $_POST['email'];
        $where = array('email' => $email);
        $country_name = $this->um->get_data('conf_contact', $where);
        echo json_encode($country_name);
//      
    }

    public function logout() {
        $this->session->sess_destroy();
        redirect('login');
    }

    public function search() {
        $keyword = $this->input->post('login_id');

        $data['response'] = 'false'; //Set default response

        $query = $this->um->sw_search($keyword); //Model DB search

        if ($query->num_rows() > 0) {
            $data['response'] = 'true'; //Set response
            $data['message'] = array(); //Create array
            foreach ($query->result() as $row) {
                $data['message'][] = array('email' => $row->email); //Add a row to array
            }
        }
        echo json_encode($data);
    }

    public function bank($id = FALSE) {
        $data['config'] = 'config';
        if ($id != NULL) {
            $where = array('id' => $id);
            $bwhere = array('bank_id' => $id);
            $data['bank'] = $this->um->get_data('conf_bank', $where);
            $data['branch'] = $this->um->get_data('conf_bank_branch', $bwhere);
            $data['body'] = 'v_bank_new';
        }

        $this->load->view('element/main_temp', $data);
    }

    public function bank_list() {
        $url = base_url('main/bank_list');
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
//        $data['value'] = $this->um->get_data('conf_user', $where, 'conf_contact', 'contact_id', 'user_name', 'conf_roles', 'role_id', 'role', $limit, $start);
        $data['value'] = $this->um->get_data('conf_bank', $where, '', '', '', '', '', '', $limit, $start);
        $data['total'] = $this->um->get_data('conf_bank', $where, '', '', '');
//                echo '<pre>';
//         print_r($data);
//        echo '</pre>';
//        exit();
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function bank_branch($id = FALSE) {
        $data['body'] = 'bank_branch';
        $data['config'] = 'config';

        $this->load->view('element/main_temp', $data);
    }

    public function bank_branch_list() {
        $url = base_url('main/bank_branch_list');
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
        $data['body'] = 'bank_branch_list';
//        $data['value'] = $this->um->get_data('conf_user', $where, 'conf_contact', 'contact_id', 'user_name', 'conf_roles', 'role_id', 'role', $limit, $start);
        $data['value'] = $this->um->get_data('conf_bank_branch', $where, '', '', '', '', '', '', $limit, $start);
        $data['total'] = $this->um->get_data('conf_bank_branch', $where, '', '', '');
//                echo '<pre>';
//         print_r($data);
//        echo '</pre>';
//        exit();
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function add_bank_branch() {
        if ($this->input->post('id')) {
            $data = array(
                'bank_id' => $this->input->post('bank_id'),
                'branch_name' => $this->input->post('branch_name'),
                'address' => $this->input->post('address'),
                'account_name' => $this->input->post('account_name'),
                'account_number' => $this->input->post('account_number'),
                'short_code' => $this->input->post('short_code'),
                'contact_number' => $this->input->post('contact_number'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $where = array(
                'user_id' => $this->input->post('id')
            );
            $id = $this->um->update_data('conf_bank_branch', $data, $where);
            $this->bank_branch_list();
        }
        // insert data
        else {
            $value = array(
                'bank_id' => $this->input->post('bank_id'),
                'branch_name' => $this->input->post('branch_name'),
                'address' => $this->input->post('address'),
                'account_name' => $this->input->post('account_name'),
                'account_number' => $this->input->post('account_number'),
                'short_code' => $this->input->post('short_code'),
                'contact_number' => $this->input->post('contact_number'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $id = $this->um->insert_data('conf_bank_branch', $value);
            $this->bank_branch_list();
        }
    }

    public function shipment_provider($id = FALSE) {
        $data['body'] = 'shipment_provider';
        $data['config'] = 'config';
        $mu_form = array('key_name' => 'Country');
        $data['countrys'] = $this->um->get_data('conf_keyword', $mu_form, 'const_keys', 'key_id', 'key_id');
        if ($id != NULL) {
            $mu_form = array('id' => $id);
            $data['keywords'] = $this->um->get_data('conf_shipmentprovider', $mu_form, '', '', '');
        }

        $this->load->view('element/main_temp', $data);
    }

    public function shipment_provider_list() {
        $url = base_url('main/shipment_provider_list');
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
        $order_field = 'id';
        $order = 'desc';
        $data['body'] = 'shipment_provider_list';
        $data['value'] = $this->um->get_data('conf_shipmentprovider', $where, 'conf_keyword', 'keyword_id', 'country_id', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('conf_shipmentprovider', $where, '', '', '');
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function add_shipment_provider() {
        if ($this->input->post('id')) {
            $data = array(
                'material_name' => $this->input->post('material_name'),
                'country_id' => $this->input->post('country'),
                'contact_no' => $this->input->post('contact_no'),
                'mobile_no' => $this->input->post('mobile_no'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'interval_days' => $this->input->post('interval_days'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $where = array(
                'id' => $this->input->post('id')
            );
            $id = $this->um->update_data('conf_shipmentprovider', $data, $where);
            $this->shipment_provider_list();
        }
        // insert data
        else {
            $value = array(
                'material_name' => $this->input->post('material_name'),
                'country_id' => $this->input->post('country'),
                'contact_no' => $this->input->post('contact_no'),
                'mobile_no' => $this->input->post('mobile_no'),
                'email' => $this->input->post('email'),
                'address' => $this->input->post('address'),
                'interval_days' => $this->input->post('interval_days'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $id = $this->um->insert_data('conf_shipmentprovider', $value);
            $this->shipment_provider_list();
        }
    }

    public function product_actions($id = FALSE) {
        $data['body'] = 'product_actions';
        $data['config'] = 'config';
        if ($id != NULL) {
            $mu_form = array('id' => $id);
            $data['keywords'] = $this->um->get_data('conf_productactions', $mu_form, '', '', '');
        }

        $this->load->view('element/main_temp', $data);
    }

    public function product_actions_list() {
        $url = base_url('main/product_actions_list');
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
        $order_field = 'id';
        $order = 'desc';
        $data['body'] = 'product_actions_list';
        $data['value'] = $this->um->get_data('conf_productactions', $where, '', '', '', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('conf_productactions', $where, '', '', '');

        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function add_product_actions() {
        if ($this->input->post('id')) {
            $data = array(
                'action_name' => $this->input->post('action_name'),
                'action_place' => $this->input->post('action_place'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $where = array(
                'user_id' => $this->input->post('id')
            );
            $id = $this->um->update_data('conf_productactions', $data, $where);
            $this->product_actions_list();
        }
        // insert data
        else {
            $value = array(
                'action_name' => $this->input->post('action_name'),
                'action_place' => $this->input->post('action_place'),
                'remarks' => $this->input->post('remarks'),
                'status' => $this->input->post('status')
            );
            $id = $this->um->insert_data('conf_productactions', $value);
            $this->product_actions_list();
        }
    }

    public function invoice() {
        $data['body'] = 'v_invoice';
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function new_bank() {
        $data['body'] = 'v_bank_new';
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    function get_birds() {
        if (isset($_GET['term'])) {
            $q = strtolower($_GET['term']);
            $this->um->get_bird($q);
        }
    }

    public function get_info() {
        if (isset($_GET['term'])) {
            $col_name = 'bank_name';
            $table = 'conf_bank';
            $q = strtolower($_GET['term']);
            $this->um->get_autocom_info($q, $col_name, $table);
        }
    }

    public function client_get_info1() {
        if (isset($_POST['term'])) {
            $col_name = 'client_name';
            $table = 'conf_client';
            $q = strtolower($_GET['term']);
            $value = $this->um->get_autocom_info1($q, $col_name, $table);
            $where['currency'] = $value['value1'];
            $data['value'] = $this->um->get_data('conf_client', $where, 'conf_currency', 'currency_id', 'currency', '', '', '');
//                            echo '<pre>';
//         print_r($data);
//        echo '</pre>';
//        exit();
            return $data;
        }
    }

    public function client_get_info() {
        if (isset($_GET['term'])) {
            $col_name = 'client_name';
            $table = 'conf_client';
            $q = strtolower($_GET['term']);
            $this->um->get_autocom_info($q, $col_name, $table);
        }
    }

    public function get_product_name() {
        if (isset($_GET['term'])) {
            $col_name = 'product_name';
            $table = 'conf_product';
            $q = strtolower($_GET['term']);
            $this->um->get_autocom_info($q, $col_name, $table);
        }
    }

    public function get_product_part() {
        if (isset($_GET['term'])) {
            $col_name = 'product_name';
            $table = 'conf_product';
            $q = strtolower($_GET['term']);
            $this->um->get_autocom_info($q, $col_name, $table);
        }
    }

    public function get_action1() {


        if (isset($_POST['name'])) {
            $flow = $_POST['name'];

            $where1 = array('flow_name' => $flow);
            $data['value'] = $this->um->get_data('conf_flowaction', $where1, 'conf_flowaction_actions', 'flow_action_id', 'id');
//            print_r($data);exit;
            if ($data['value'] != NULL) {
                $flow_id = $data['value'][0]['id'];
                $where = array('flow_action_id' => $flow_id);
                $data['value'] = $this->um->get_data('conf_flowaction_actions', $where, 'conf_productactions', 'id', 'action_name', 'conf_product_actiontime', 'id', 'id');
            }
            echo json_encode($data);
        }
    }

    public function get_action() {


        if (isset($_POST['name'])) {
            $flow = $_POST['name'];

            $where1 = array('flow_name' => $flow);
            $data['value'] = $this->um->get_data('conf_flowaction', $where1, 'conf_flowaction_actions', 'flow_action_id', 'id');
//            print_r($data);exit;
            if ($data['value'] != NULL) {
                $flow_id = $data['value'][0]['id'];
                $where = array('flow_action_id' => $flow_id);
                $data['value'] = $this->um->get_data('conf_flowaction_actions', $where, 'conf_productactions', 'id', 'action_name');
            }
            echo json_encode($data['value']);
        }
    }

    public function get_material() {
        if (isset($_GET['term'])) {
            $col_name = 'material_name';
            $table = 'conf_rawmaterial';
            $q = strtolower($_GET['term']);
            $this->um->get_autocom_info($q, $col_name, $table);
        }
    }

    public function all_product_part() {
        if (isset($_POST['name'])) {
            $hwhere = array(
                'product_name' => $_POST['name']
            );
            $data = $this->um->get_data('conf_product', $hwhere);
//            print_r($data);exit;
            $where1 = array(
                'keyword_id' => $data[0]['size']
            );
            $size = $this->um->get_data('conf_keyword', $where1);
            $data[0]['size_name'] = $size[0]['keyword_value'];
            $where2 = array(
                'keyword_id' => $data[0]['color']
            );
            $size = $this->um->get_data('conf_keyword', $where2);
            $data[0]['color_name'] = $size[0]['keyword_value'];

//            print_r($data);
            echo json_encode($data[0]);
        }
    }

    public function all_material_info() {
        if (isset($_POST['name'])) {
            $hwhere = array(
                'material_name' => $_POST['name']
            );
            $data = $this->um->get_data('conf_rawmaterial', $hwhere);
//            print_r($data);exit;
            $where1 = array(
                'keyword_id' => $data[0]['size_id']
            );
            $size = $this->um->get_data('conf_keyword', $where1);
            $data[0]['size_name'] = $size[0]['keyword_value'];
            $where2 = array(
                'keyword_id' => $data[0]['color_id']
            );
            $size = $this->um->get_data('conf_keyword', $where2);
            $data[0]['color_name'] = $size[0]['keyword_value'];
            $where3 = array(
                'keyword_id' => $data[0]['m_unit_id']
            );
            $size = $this->um->get_data('conf_keyword', $where3);
            $data[0]['m_unit_name'] = $size[0]['keyword_value'];
//            print_r($data[0]);exit;
            echo json_encode($data[0]);
        }
    }

    public function image_upload() {
        if (isset($_FILES["file"]["type"])) {
            $validextensions = array("jpeg", "jpg", "png");
            $temporary = explode(".", $_FILES["file"]["name"]);
            $trmp = $temporary[0] . "_thumb." . $temporary[1];
//            print_r($trmp);exit;
            $file_extension = end($temporary);
            if ((($_FILES["file"]["type"] == "image/png") || ($_FILES["file"]["type"] == "image/jpg") || ($_FILES["file"]["type"] == "image/jpeg")
                    ) && ($_FILES["file"]["size"] < 100000000)//Approx. 100kb files can be uploaded.
                    && in_array($file_extension, $validextensions)) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
                } else {
                    if (file_exists("upload/" . $_FILES["file"]["name"])) {
                        echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
                    } else {

                        $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
                        $targetPath = "upload/image/" . $_FILES['file']['name']; // Target path where file is to be stored
                        move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file
                        $config['image_library'] = 'gd2';
                        $config['source_image'] = $targetPath; //'C:/Users/Public/Pictures/Sample Pictures/Chrysanthemum.jpg'; //'/img/proizvodi/' . $row->proizvodid . '.jpg';
                        $config['create_thumb'] = TRUE;
                        $config['maintain_ratio'] = TRUE;
                        $config['width'] = 250;
                        $config['height'] = 250;

                        $this->load->library('image_lib', $config);
                        $value = $this->image_lib->resize();
                        echo "Image Uploaded";
                    }
                }
            } else {
                echo "<span id='invalid'>***Invalid file Size or Type***<span>";
            }
        } else {
            print_r("test");
        }
    }

    public function file_upload() {
//            print_r($_FILES);exit;

        if (isset($_FILES["file"]["type"])) {

            $validextensions = array("pdf", "doc", "txt");
            $temporary = explode(".", $_FILES["file"]["name"]);
            $file_name = $temporary[0];
            $file_extention = $temporary[1];
            $location = 'upload/file/' . $file_name . '.' . $file_extention;
            $size = $_FILES["file"]["size"];
            $data[0]['doc_name'] = $file_name;
            $data[0]['doc_extension'] = $file_extention;
            $data[0]['doc_size'] = $size;
            $data[0]['doc_location'] = $location;
            $file_extension = end($temporary);
            if (($_FILES["file"]["size"] < 10000000)//Approx. 10000kb files can be uploaded.
                    && in_array($file_extension, $validextensions)) {
                if ($_FILES["file"]["error"] > 0) {
                    echo "Return Code: " . $_FILES["file"]["error"] . "<br/><br/>";
                } else {
                    if (file_exists("upload/" . $_FILES["file"]["name"])) {
                        echo $_FILES["file"]["name"] . " <span id='invalid'><b>already exists.</b></span> ";
                    } else {
                        $sourcePath = $_FILES['file']['tmp_name']; // Storing source path of the file in a variable
                        $targetPath = "upload/file/" . $_FILES['file']['name']; // Target path where file is to be stored
                        move_uploaded_file($sourcePath, $targetPath); // Moving Uploaded file
                    }
                }
            } else {
                echo "<span id='invalid'>***Invalid file Size or Type***<span>";
            }
            echo json_encode($data[0]);
        }
    }

    public function client_rate_info() {
        if (isset($_POST['name'])) {
            $where = array(
                'client_name' => $_POST['name']
            );
            $data = $this->um->get_data('conf_client', $where, 'conf_currency', 'currency_id', 'currency', '', '', '');
            echo json_encode($data[0]);
        }
    }

    public function save_product() {
//        print_r($_POST['myarray']['test'][0]);exit;
        if (isset($_POST['myarray'])) {
            if ($_POST['myarray']['test'][0] != 0) {
                $product_id1 = $_POST['myarray']['test'][0];
                $where['product_id'] = $product_id1;
                $where1['id'] = $product_id1;
                $product = $_POST['myarray']['product'];
                $final_array = array_chunk($product, 10); // array divided in based in 6 index
                if ($product) {
                    foreach ($final_array as $info) {
                        if ($info[7] != null) {
                            $temporary = explode(".", $info[7]);
                            $data = array(
                                'product_name' => $info[0],
                                'code' => $info[1],
                                'color' => $info[2],
                                'size' => $info[3],
                                'skill' => $info[4],
                                'flow' => $info[5],
                                'default_rate' => $info[6],
                                'picture' => $temporary[0] . "_thumb." . $temporary[1],
                                'has_part' => $info[8],
                                'status' => $info[9]
                            );
                        } else {
                            $data = array(
                                'product_name' => $info[0],
                                'code' => $info[1],
                                'color' => $info[2],
                                'size' => $info[3],
                                'skill' => $info[4],
                                'flow' => $info[5],
                                'default_rate' => $info[6],
//                            'picture' => $temporary[0] . "_thumb." . $temporary[1],
                                'has_part' => $info[8],
                                'status' => $info[9]
                            );
                        }

                        $this->um->update_data('conf_product', $data, $where1);
                    }
                }
                $file_name = $_POST['myarray']['docsArray'];
                if ($file_name != null) {
                    $file_data = array();
                    $file_data['product_id'] = $product_id1;
                    $file_data['doc_name'] = $file_name[0];
                    $file_data['doc_extension'] = $file_name[1];
                    $file_data['doc_size'] = $file_name[2];
                    $file_data['doc_location'] = $file_name[3];
                    $product_id = $this->um->update_data('conf_product_docs', $file_data, $where);
                }
                $actiontimeArray = $_POST['myarray']['actiontimeArray'];
                $final_array = array_chunk($actiontimeArray, 5); // array divided in based in 6 index
                foreach ($final_array as $info) {
                    $data = array(
                        'action_id' => $info[3],
                        'action_time' => $info[1],
                        'dist_req' => $info[2],
                        'product_id' => $product_id1
                    );
                    $this->um->update_data('conf_product_actiontime', $data, $where);
                }
                $partArray = $_POST['myarray']['partArray'];
                $final_array = array_chunk($partArray, 8); // array divided in based in 6 index
                foreach ($final_array as $info) {
                    $data = array(
                        'part_name_id' => $info[6],
                        'product_id' => $product_id1,
                        'quantity' => $info[2],
                    );
//                $product_id = $this->um->insert_data('conf_product_parts', $data);
                    $this->um->update_data('conf_product_parts', $data, $where);
                }
                $rawmaterialsArray = $_POST['myarray']['rawmaterialsArray'];
                $final_array = array_chunk($rawmaterialsArray, 11); // array divided in based in 6 index
                foreach ($final_array as $info) {
                    $data = array(
                        'quantity' => $info[5],
                        'raw_material_id' => $info[6],
                        'm_unit_id' => $info[7],
                        'color_id' => $info[8],
                        'size_id' => $info[9],
                        'product_id' => $product_id1
                    );
//                            print_r($data);
                    $product_id = $this->um->update_data('conf_product_rawmaterials', $data, $where);
                }
                $clientrateArray = $_POST['myarray']['clientrateArray'];
                $final_array = array_chunk($clientrateArray, 8); // array divided in based in 6 index
                foreach ($final_array as $info) {
                    $data = array(
                        'client_id' => $info[6],
                        'current_rate' => $info[1],
                        'currency_id' => 2, //  problem
                        'rate_date' => $info[4],
                        'client_p_code' => $info[5],
                        'product_id' => $product_id1
                    );
                    $this->um->update_data('conf_product_clientrate', $data, $where);
                }
                echo "Success";
            } else {

                $product = $_POST['myarray']['product'];
//            print_r($product);exit;
                $final_array = array_chunk($product, 10); // array divided in based in 6 index
                foreach ($final_array as $info) {
                    if ($info[7] != null) {
                        $temporary = explode(".", $info[7]);
                    } else {
                        $temporary = explode(".", "noimage.png");
                    }
                    $has_part = $info[8];
                    $data = array(
                        'product_name' => $info[0],
                        'code' => $info[1],
                        'color' => $info[2],
                        'size' => $info[3],
                        'skill' => $info[4],
                        'flow' => $info[5],
                        'default_rate' => $info[6],
//                        'picture' => $info[7],
                        'picture' => $temporary[0] . "_thumb." . $temporary[1],
                        'has_part' => $info[8],
                        'status' => $info[9]
                    );
//                            print_r($data); exit;
                    $product_id1 = $this->um->insert_data('conf_product', $data);
                }
                $file_name = $_POST['myarray']['docsArray'];
//            print_r($file_name['partArray']);
                $file_data = array();

                $file_data['product_id'] = $product_id1;
                $file_data['doc_name'] = $file_name[0];
                $file_data['doc_extension'] = $file_name[1];
                $file_data['doc_size'] = $file_name[2];
                $file_data['doc_location'] = $file_name[3];
                $product_id = $this->um->insert_data('conf_product_docs', $file_data);
                $actiontimeArray = $_POST['myarray']['actiontimeArray'];

                $final_array = array_chunk($actiontimeArray, 5); // array divided in based in 6 index
                foreach ($final_array as $info) {
                    $data = array(
                        'action_id' => $info[1],
                        'action_time' => $info[2],
                        'dist_req' => $info[3],
                        'product_id' => $product_id1
                    );
                    $product_id = $this->um->insert_data('conf_product_actiontime', $data);
                }
                if ($has_part == 1) {
                    $partArray = $_POST['myarray']['partArray'];

                    $final_array = array_chunk($partArray, 8); // array divided in based in 6 index
                    foreach ($final_array as $info) {
                        $data = array(
                            'part_name_id' => $info[6],
                            'product_id' => $product_id1,
                            'quantity' => $info[2],
                        );
                        $product_id = $this->um->insert_data('conf_product_parts', $data);
                    }
                }
                $rawmaterialsArray = $_POST['myarray']['rawmaterialsArray'];
                $final_array = array_chunk($rawmaterialsArray, 11); // array divided in based in 6 index
                foreach ($final_array as $info) {
                    $data = array(
                        'quantity' => $info[5],
                        'raw_material_id' => $info[6],
                        'm_unit_id' => $info[7],
                        'color_id' => $info[8],
                        'size_id' => $info[9],
                        'product_id' => $product_id1
                    );
//                            print_r($data);
                    $product_id = $this->um->insert_data('conf_product_rawmaterials', $data);
                }
                $clientrateArray = $_POST['myarray']['clientrateArray'];
                $final_array = array_chunk($clientrateArray, 8); // array divided in based in 6 index
                foreach ($final_array as $info) {
                    $data = array(
                        'client_id' => $info[6],
                        'current_rate' => $info[1],
                        'currency_id' => 2, //  problem
                        'rate_date' => $info[4],
                        'client_p_code' => $info[5],
                        'product_id' => $product_id1
                    );
                    $product_id = $this->um->insert_data('conf_product_clientrate', $data);
                }
                echo "Success";
            }
        }
    }

    public function save_flow_info() {
        if (isset($_POST['rowsArray'])) {
            $last_id = $this->um->last_id('id', 'conf_flowaction');
            $flow_info = $_POST['rowsArray'];
            $final_array = array_chunk($flow_info, 7);
            foreach ($final_array as $info) {
                $data = array(
                    'flow_action_id' => $last_id,
                    'action_name' => $info[1],
                    'order' => $info[2],
                    'qc' => $info[3],
                    'remarks' => $info[4]
                );
                $this->um->insert_data('conf_flowaction_actions', $data);
            }
        };
    }

    public function save_info() {
        $input_array = array();
        $final_array = array();
        $input_array_final = array();
        if (isset($_POST['myarray'])) {
            $input_array = $_POST['myarray'];
            $length = count($input_array);
            $address = $input_array[$length - 1];
            $bank_name = $input_array[$length - 2];
            array_pop($input_array);
            array_pop($input_array);
            $bank_info = array(
                'bank_name' => $bank_name,
                'address' => $address
            );
            $id = $this->um->insert_data('conf_bank', $bank_info);

            $final_array = array_chunk($input_array, 7); // array divided in based in 6 index
            foreach ($final_array as $info) {
                $data = array(
                    'bank_id' => $id,
                    'branch_name' => $info[0],
                    'address' => $info[1],
                    'account_name' => $info[2],
                    'account_number' => $info[3],
                    'contact_number' => $info[4],
                    'short_code' => $info[5],
                    'status' => $info[6]
                );

                $this->um->insert_data('conf_bank_branch', $data);
            }
            echo 'inserted';
        }
    }

    public function product_list() {
        $url = base_url('main/product_list');
        $data['config'] = 'config';
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
        $order_field = 'id';
        $order = 'desc';
        $data['body'] = 'product_list';
        $data['value'] = $this->um->get_data('conf_product', $where, '', '', '', '', '', '', $limit, $start, $order_field, $order);
        $data['total'] = $this->um->get_data('conf_product', $where);
        $total = count($data['total']);
        $data['page'] = $this->pagination($url, $total, $limit);
        $data['config'] = 'config';
        $this->load->view('element/main_temp', $data);
    }

    public function update_bank_info() {
        if (isset($_POST['myarray'])) {
            $input_array = $_POST['myarray'];
            $length = count($input_array);
            $bank_id = $input_array[$length - 1];
            $address = $input_array[$length - 2];
            $bank_name = $input_array[$length - 3];
            array_pop($input_array);
            array_pop($input_array);
            array_pop($input_array);
            $bank_info = array(
                'bank_name' => $bank_name,
                'address' => $address
            );
            $bank_where = array('id' => $bank_id);
            $this->um->update_data('conf_bank', $bank_info, $bank_where);

            $final_array = array_chunk($input_array, 8); // array divided in based in 6 index
            foreach ($final_array as $info) {
                if ($info[0] == 0) {
                    $data = array(
                        'bank_id' => $bank_id,
                        'branch_name' => $info[1],
                        'address' => $info[2],
                        'account_name' => $info[3],
                        'account_number' => $info[4],
                        'contact_number' => $info[5],
                        'short_code' => $info[6],
                        'status' => $info[7]
                    );

                    $this->um->insert_data('conf_bank_branch', $data);
                } else {
                    $data = array(
                        'branch_name' => $info[1],
                        'address' => $info[2],
                        'account_name' => $info[3],
                        'account_number' => $info[4],
                        'contact_number' => $info[5],
                        'short_code' => $info[6],
                        'status' => $info[7]
                    );
                    $where = array('id' => $info[0]);
                    $this->um->update_data('conf_bank_branch', $data, $where);
                }
            }
            echo 'inserted';
        }
    }

}
