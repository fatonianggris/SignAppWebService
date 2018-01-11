<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

class Auth extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('Authmodel');
        //$this->db->cache_on();
    }

    public function login_post() {

        $username = $this->post('username');
        $pass = $this->post('password');

        if ($username && $pass) {
            // get the user by email and password
            $data = $this->Authmodel->check_login($username, $pass);
            $result = array();
            //print_r($user);exit();
            if ($data) {
                // use is found              
                foreach ($data as $key => $value) {
                    $result['status'] = TRUE;
                    $result['user'] = $value;
                }
                $this->output
                        ->set_status_header(REST_Controller::HTTP_OK)
                        ->set_header('Cache-Control: no-store, no-cache, must-revalidate')
                        ->set_header('Cache-Control: post-check=0, pre-check=0')
                        ->set_header('Pragma: no-cache')
                        ->set_content_type('application/json', 'utf-8')
                        ->set_output(json_encode($result, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            } else {
                // required post params is missing
            $this->set_response([
                'status' => FALSE,
                'error_msg' => 'Password/Username anda salah!'], REST_Controller::HTTP_OK);
            }
        } else {
            // required post params is missing
            $this->set_response([
                'status' => FALSE,
                'error_msg' => 'Mohon maaf server sedang sibuk!'], REST_Controller::HTTP_OK);
        }
    }
    
     // SET REG ID FIREBASE
    public function setregid_post() {
        $id_user = $this->post('id_user');
        $reg_id = $this->post('reg_id');
        
        if ($id_user && $reg_id) {
            // get the data by id
            $data = $this->Authmodel->set_reg_id($id_user, $reg_id);

            if ($data) {
                // data is found              
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Reg ID berhasil diupdate!'], REST_Controller::HTTP_OK);
            } else {
                // required post params is missing
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Reg ID gagal diupdate!'], REST_Controller::HTTP_OK);
            }
        } else {
            // required post params is missing
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, server sedang sibuk!'], REST_Controller::HTTP_OK);
        }
    }

}
