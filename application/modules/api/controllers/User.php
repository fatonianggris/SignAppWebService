<?php

defined('BASEPATH') OR exit('No direct script access allowed');

// This can be removed if you use __autoload() in config.php OR use Modular Extensions
require APPPATH . '/libraries/REST_Controller.php';

/**
 * This is an example of a few basic user interaction methods you could use
 * all done with a hardcoded array
 *
 * @package         CodeIgniter
 * @subpackage      Rest Server
 * @category        Controller
 * @author          Phil Sturgeon, Chris Kacerguis
 * @license         MIT
 * @link            https://github.com/chriskacerguis/codeigniter-restserver
 */
class User extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('Usermodel');
        //$this->db->cache_on();
    }

    public function getuser_get() {
        $id = $this->get('id_posisi');
        if (!$id) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $data ['result'] = $this->Usermodel->get_worker($id);
            if ($data) {
                // Set the response and exit
                $this->output
                        ->set_status_header(REST_Controller::HTTP_OK)
                        ->set_header('Cache-Control: no-store, no-cache, must-revalidate')
                        ->set_header('Cache-Control: post-check=0, pre-check=0')
                        ->set_header('Pragma: no-cache')
                        ->set_content_type('application/json', 'utf-8')
                        ->set_output(json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES));
            } else {
                // Set the response and exit
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'User tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    public function getuserbyid_get() {
        $id = $this->get('id_user');
        if (!$id) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $data = $this->Usermodel->get_user($id);
            $result = array();
            if ($data) {
                // Set the response and exit
                // data is found              
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
                // Set the response and exit
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'User tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    // UPDATE USER
    public function updateuser_post() {
        $id_user = $this->post('id_user');

        $image = $this->post('foto');
        $image_thumb = $this->post('foto_thumb');
        $nama_image = $this->post('nama_foto');        
        $pass = $this->post('password');
        
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        if ($param) {
            if ($nama_image != '') {
                $path = 'uploads/user/' . $nama_image . '.png';
                $path_thumb = 'uploads/user/thumbs/' . $nama_image . '.png';
                file_put_contents($path, base64_decode($image));
                file_put_contents($path_thumb, base64_decode($image_thumb));
                $data['pic'] = $path;
                $data['pic_thumb'] = $path_thumb;
            } else {
                $data['pic'] = $image;
                $data['pic_thumb'] = $image_thumb;
            }
            if ($pass != "") {
                $dt['pass'] = $pass;
                $this->Usermodel->update_pass($id_user, $dt);
            }

            $input = $this->Usermodel->update_user($id_user, $data);
            if ($input == true) {
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Data telah tersimpan'], REST_Controller::HTTP_OK);
            } else {
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'Mohon maaf, terjadi kesalahan.'], REST_Controller::HTTP_OK);
            }
        } else {
            // user is not found with the credentials
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, server sedang sibuk'], REST_Controller::HTTP_OK);
        }
    }

}
