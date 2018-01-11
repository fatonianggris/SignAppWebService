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
class Project extends REST_Controller {

    function __construct() {
        // Construct the parent class
        parent::__construct();

        // Configure limits on our controller methods
        // Ensure you have created the 'limits' table and enabled 'limits' within application/config/rest.php
        $this->methods['user_get']['limit'] = 500; // 500 requests per hour per user/key
        $this->methods['user_post']['limit'] = 100; // 100 requests per hour per user/key
        $this->methods['user_delete']['limit'] = 50; // 50 requests per hour per user/key
        $this->load->model('Projectmodel');
        $this->load->library("firebase/Firebase");
        $this->load->library("firebase/Push");
        $this->load->library("firebase/config");
        //$this->db->cache_on();
    }

    /**
     * METHOD/FUNCTION JOBS CRUD
     */
    // GET PROJECT
    public function getjob_get() {
        //get id project
        $id_job = $this->get('id_job');
        if ($id_job) {
            // get the data by id
            $data = $this->Projectmodel->get_job($id_job);
            $result = array();
            if ($data) {
                // data is found              
                foreach ($data as $key => $value) {
                    $result['status'] = TRUE;
                    $result['tugas'] = $value;
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
                    'message' => 'ID tidak ditemukan!'], REST_Controller::HTTP_OK);
            }
        } else {
            // required post params is missing
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, server sedang sibuk!'], REST_Controller::HTTP_OK);
        }
    }

    // ADD PROJECT
    public function addjob_post() {
        $id_project = $this->post('id_projek');
        $image = $this->post('img');
        $image_thumb = $this->post('img_thumb');
        $nama_image = $this->post('nama_img');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);
        $cek = $this->Projectmodel->get_by_id_project($id_project);
        $id_lap = $cek[0]->id_plapangan;
        $id_sur = $cek[0]->id_penyurvei;

        if ($param) {

            if ($nama_image != '') {
                $path = 'uploads/job/' . $nama_image . '.png';
                $path_thumb = 'uploads/job/thumbs/' . $nama_image . '.png';
                file_put_contents($path, base64_decode($image));
                file_put_contents($path_thumb, base64_decode($image_thumb));
                $data['pic'] = $path;
                $data['pic_thumb'] = $path_thumb;
            } else {
                $data['pic'] = $image;
                $data['pic_thumb'] = $image_thumb;
            }

            $input = $this->Projectmodel->insert_job($id_project, $id_lap, $id_sur, $data);
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

    // UPDATE STATUS JOB
    public function updatestsjob_post() {
        $id_job = $this->post('id_tugas');
        $status = (int) $this->post('sts_tugas') + 1;
        if ($id_job && $status) {
            // get the data by id
            $data = $this->Projectmodel->update_status_job($id_job, $status);

            if ($data) {
                // data is found              
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Status berhasil diupdate!'], REST_Controller::HTTP_OK);
            } else {
                // required post params is missing
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'ID tidak ditemukan!'], REST_Controller::HTTP_OK);
            }
        } else {
            // required post params is missing
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, server sedang sibuk!'], REST_Controller::HTTP_OK);
        }
    }

    // UPDATE JOB
    public function updatejob_post() {
        $id_job = $this->post('id_tugas');
        $id_project = $this->post('id_projek');
        $image = $this->post('img');
        $image_thumb = $this->post('img_thumb');
        $nama_image = $this->post('nama_img');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);
        $cek = $this->Projectmodel->get_by_id_project($id_project);
        $id_lap = $cek[0]->id_plapangan;
        $id_sur = $cek[0]->id_penyurvei;
            
        if ($param) {
            if ($nama_image != '') {
                $path = 'uploads/job/' . $nama_image . '.png';
                $path_thumb = 'uploads/job/thumbs/' . $nama_image . '.png';
                file_put_contents($path, base64_decode($image));
                file_put_contents($path_thumb, base64_decode($image_thumb));
                $data['pic'] = $path;
                $data['pic_thumb'] = $path_thumb;
            } else {
                $data['pic'] = $image;
                $data['pic_thumb'] = $image_thumb;
            }

            $input = $this->Projectmodel->update_job($id_job, $id_project, $id_lap, $id_sur, $data);
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

    // DELETE JOB
    public function deletejob_post() {
        $id_job = $this->post('id_tugas');
        $data = $this->Projectmodel->get_img_by_id_job($id_job);
        $data_img = explode('/', $data[0]->foto);
        $name_img = $data_img[2];
        if ($id_job) {
            // get the data by id
            $data = $this->Projectmodel->delete_job($id_job);
            //print_r($user);exit();
            if ($data) {
                // data is found    
                $this->delete_file($name_img);
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Data berhasil dihapus!'], REST_Controller::HTTP_OK);
            } else {
                // required post params is missing
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'ID tidak ditemukan!'], REST_Controller::HTTP_OK);
            }
        } else {
            // required post params is missing
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, server sedang sibuk!'], REST_Controller::HTTP_OK);
        }
    }

    public function listjob_get() {
        $id = $this->get('id_projek');
        $limit = $this->get('limit');
        if (!$id) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_NOT_FOUND);
        } else {
            $count = $this->Projectmodel->count_job($id);
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($count) {
                if ($limit >= $count) {
                    $data['status'] = FALSE;
                    $data['message'] = "Data terakhir telah diupdate";
                    $limit = $count;
                } else {
                    $data['status'] = TRUE;
                }
                $data['result'] = $this->Projectmodel->get_list_job($id, $limit);
                if ($data) {
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
                        'message' => 'Data tidak ditemukan'
                            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                }
            }
        }
    }

    /**
     * METHOD/FUNCTION PROJECT CRUD
     */
    // GET PROJECT
    public function getproject_get() {
        //get id project
        $id_project = $this->get('id_project');
        if ($id_project) {
            // get the data by id
            $data = $this->Projectmodel->get_project($id_project);
            $result = array();
            if ($data) {
                // data is found              
                foreach ($data as $key => $value) {
                    $result['status'] = TRUE;
                    $result['projek'] = $value;
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
                    'message' => 'ID tidak ditemukan!'], REST_Controller::HTTP_OK);
            }
        } else {
            // required post params is missing
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, server sedang sibuk!'], REST_Controller::HTTP_OK);
        }
    }

    // GET LIST PROJECT LAPANGAN
    public function listprojectlap_get() {
        $id = $this->get('id_plapangan');
        $limit = $this->get('limit');
        if (!$id) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $count = $this->Projectmodel->count_project_lap($id);
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($count) {
                if ($limit >= $count) {
                    $data['status'] = FALSE;
                    $data['message'] = "Data terakhir telah diupdate";
                    $limit = $count;
                } else {
                    $data['status'] = TRUE;
                }
                $data['result'] = $this->Projectmodel->get_list_lap_project($id, $limit);
                if ($data) {
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
                        'message' => 'Data tidak ditemukan'
                            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                }
            }
        }
    }

    // GET LIST PROJECT SURVEI
    public function listprojectsur_get() {
        $id = $this->get('id_penyurvei');
        $limit = $this->get('limit');
        if (!$id) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID salah'], REST_Controller::HTTP_OK);
        } else {
            $count = $this->Projectmodel->count_project_sur($id);
            // Check if the users data store contains users (in case the database result returns NULL)
            if ($count) {
                if ($limit >= $count) {
                    $data['status'] = FALSE;
                    $data['message'] = "Data terakhir telah diupdate";
                    $limit = $count;
                } else {
                    $data['status'] = TRUE;
                }
                $data['result'] = $this->Projectmodel->get_list_sur_project($id, $limit);
                if ($data) {
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
                        'message' => 'Data tidak ditemukan'
                            ], REST_Controller::HTTP_NOT_FOUND); // NOT_FOUND (404) being the HTTP response code
                }
            }
        }
    }

    // ADD PROJECT
    public function addproject_post() {
        $id_plapangan = $this->post('plapangan');  
        $id_psurvei = $this->post('psurvei');
        $name_project = $this->post('nama_projek'); 
        
        $param = $this->input->post(); 
        $data = $this->security->xss_clean($param);
        
        if ($param) {
            $this->Projectmodel->insert_project($data);
            //set notification
            if($id_plapangan!=''){
                $check = $this->Projectmodel->get_reg_id($id_plapangan);
                if($check){
                    $title = 'Projek Baru';
                    $regId = $check[0]->reg_id;
                    $this->push_notification($title,$name_project,$regId);
                }
            }
            if($id_psurvei!=''){
                $check = $this->Projectmodel->get_reg_id($id_psurvei);
                if($check){
                    $title = 'Projek Baru';
                    $regId = $check[0]->reg_id;
                    $this->push_notification($title,$name_project,$regId);
                }
            }
            // user is not found with the credentials
            $this->set_response([
                'status' => TRUE,
                'message' => 'Data telah tersimpan'], REST_Controller::HTTP_OK);
        } else {
            // user is not found with the credentials
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, server sedang sibuk'], REST_Controller::HTTP_OK);
        }
    }

    // UPDATE PROJECT
    public function updateproject_post() {
        $id_project = $this->post('id_projek');
        $id_plapangan = $this->post('plapangan');
        $id_psurvei = $this->post('psurvei');
        $name_project = $this->post('nama_projek');   
        
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);
        //cek id plap old
        $check_worker = $this->Projectmodel->get_id_worker($id_project);
   
        if ($param) {
            //set notification
            $id_lap_old=$check_worker[0]->id_plapangan;
            if($id_plapangan!='' and $id_plapangan!=$id_lap_old){
                $check = $this->Projectmodel->get_reg_id($id_plapangan);
                if($check){
                    $title = 'Projek Baru';
                    $regId = $check[0]->reg_id;
                    $this->push_notification($title,$name_project,$regId);
                }
            }
            $id_sur_old=$check_worker[0]->id_penyurvei;
            if($id_psurvei!='' and $id_psurvei!=$id_sur_old){
                $check = $this->Projectmodel->get_reg_id($id_psurvei);
                if($check){
                    $title = 'Projek Baru';
                    $regId = $check[0]->reg_id;
                    $this->push_notification($title,$name_project,$regId);
                }
            }
            
            $edit = $this->Projectmodel->update_project($id_project, $data);
            if ($edit == true) {
                if (!empty($this->post('plapangan'))) {
                    $this->Projectmodel->set_worker_project($id_project, $data);
                }
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Data telah tersimpan'], REST_Controller::HTTP_OK);
            }
        } else {
            // user is not found with the credentials
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, server sedang sibuk'], REST_Controller::HTTP_OK);
        }
    }

    // UPDATE STATUS PROJECT
    public function updatestsproject_post() {
        $id_project = $this->post('id_projek');
        $status = (int) $this->post('sts_projek') + 1;
        if ($id_project && $status) {
            // get the data by id
            $data = $this->Projectmodel->update_status_projek($id_project, $status);

            if ($data) {
                // data is found              
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Status berhasil diupdate!'], REST_Controller::HTTP_OK);
            } else {
                // required post params is missing
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'ID tidak ditemukan!'], REST_Controller::HTTP_OK);
            }
        } else {
            // required post params is missing
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, server sedang sibuk!'], REST_Controller::HTTP_OK);
        }
    }

    // DELETE PROJECT
    public function deleteproject_post() {
        $id_project = $this->post('id_projek');
        if ($id_project) {
            // get the data by id
            $data = $this->Projectmodel->delete_project($id_project);
            //print_r($user);exit();
            if ($data) {
                // data is found   
                $this->delete_all_job($id_project);
                $this->set_response([
                    'status' => TRUE,
                    'message' => 'Data berhasil dihapus!'], REST_Controller::HTTP_OK);
            } else {
                // required post params is missing
                $this->set_response([
                    'status' => FALSE,
                    'message' => 'ID tidak ditemukan!'], REST_Controller::HTTP_OK);
            }
        } else {
            // required post params is missing
            $this->set_response([
                'status' => FALSE,
                'message' => 'Mohon maaf, server sedang sibuk!'], REST_Controller::HTTP_OK);
        }
    }

    /**
     * METHOD/FUNCTION SPINNER
     */
    //GET CODE SIGN
    public function getcode_get() {
        $id_jenis = $this->get('id_jenis');

        if (!$id_jenis) {
            $this->set_response([
                'status' => FALSE,
                'message' => 'ID/Kode salah'], REST_Controller::HTTP_OK);
        } else {
            $data ['result'] = $this->Projectmodel->get_code_sign($id_jenis);
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
                    'message' => 'Data tidak ditemukan'
                        ], REST_Controller::HTTP_OK); // NOT_FOUND (404) being the HTTP response code
            }
        }
    }

    /**
     * METHOD/FUNCTION HELPER
     */
    public function delete_all_job($id = '') {
        $data = $this->Projectmodel->get_img_job_by_id_pro($id);
        foreach ($data as $key => $value) {
            $data_img = explode('/', $value->foto);
            $name_img = $data_img[2];
            $this->delete_file($name_img);
        }
        $this->Projectmodel->delete_all_job($id);
    }

    public function delete_file($name = '') {
        $path = './uploads/job/';
        $path_thumb = './uploads/job/thumbs/';
        @unlink($path . $name);
        @unlink($path_thumb . $name);
    }

    public function push_notification($title = '', $message = '', $regid = '') {
        error_reporting(-1);
        ini_set('display_errors', 'On');

        $json = '';
        $response = '';        
             
        $firebase = new Firebase();
        $push = new Push();

         // optional payload
        $payload = array();
        $payload['team'] = 'Indonesia';
        $payload['score'] = '5.6';
        
        // notification title
        $tit = isset($title) ? $title : '';

        // notification message
        $mess = isset($message) ? $message : '';

        //set regid
        $reg= isset($regid) ? $regid : '';

        // set data push notification
        $push->setTitle($tit);
        $push->setMessage('"'.$mess.'"');
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);
        
        //get respon and json
        $json = $push->getPush();
        $response = $firebase->send($reg, $json);
       
    }

}
