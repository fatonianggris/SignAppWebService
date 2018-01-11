<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Traffic extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here
        if ($this->session->userdata('signapps') == FALSE) {
            redirect('auth');
        }
        $this->load->model('Trafficmodel');
    }

    public function index() {
        $data['title'] = "Sign Apps";
        $data['nav'] = "Tambah Rambu Lalu Lintas";
        $data['act'] = "rambu";
        $this->template->load('template/template', 'input_sign', $data);
    }

    public function list_sign() {
        $data['title'] = "Sign Apps";
        $data['nav'] = "Daftar Data Rambu Lalu Lintas";
        $data['act'] = "rambu";
        $data['list'] = $this->Trafficmodel->get_all();
        $this->template->load('template/template', 'list_sign', $data);
    }

    public function add_sign() {
        $this->load->library('form_validation');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('jenis_rambu', 'Jenis Rambu', 'required');
        $this->form_validation->set_rules('kode_rambu', 'Kode Rambu', 'required');
        $this->form_validation->set_rules('nama_rambu', 'Nama Rambu', 'required');

        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('traffic/'); //folder, controller, method
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image
            if (!empty($_FILES['img'])) {

                $path = 'uploads/sign/';
                $path_thumb = 'uploads/sign/thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg';
                $config['max_size'] = 2048; //set limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = TRUE;

                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['pic'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['new_image'] = $path_thumb . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 100;
                    $img['weight'] = 100;

                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['pic_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('traffic/');
                    }
                } else {
                    $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                    redirect('traffic/');
                }
            }

            $input = $this->Trafficmodel->insert($data);
            if ($input == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                redirect('traffic/');
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('traffic/');
            }
        }
    }

    public function get_sign($id = '') {

        $data = array();
        $data['title'] = "Sign Apps";
        $data['nav'] = "Edit Rambu Lalu Lintas"; // ???
        $data['sign'] = $this->Trafficmodel->get_by_id($id); //?
        $cek = $this->Trafficmodel->get_by_id($id);
        if (empty($id)) {
            //add new data
            $this->template->load('template/template', 'input_sign', $data);
        } else if ($cek == FALSE) {
            $data['title'] = 'Sign Apps | Error 404 ';
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $this->template->load('template/template', 'edit_sign', $data);
        }
    }

    public function edit_sign($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();

        $data = $this->security->xss_clean($param);
        $data['pic'] = $data['image'];
        $data['pic_thumb'] = $data['image_thumb'];

        $data_img = explode('/', $data['image']);
        $img_name = $data_img[2];

        $this->form_validation->set_rules('kode_rambu', ' Kode Rambu', 'required');
        $this->form_validation->set_rules('nama_rambu', 'Nama Rambu', 'required');
        $this->form_validation->set_rules('jenis_rambu', 'Jenis Rambu', 'required');
        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('traffic/get_sign/' . $id);
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image
            if (!empty($_FILES['img']['tmp_name'])) {

                $this->delete_file($img_name); //delete existing file

                $path = 'uploads/sign/';
                $path_thumb = 'uploads/sign/thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg|gif';
                $config['max_size'] = 2048; //set without limit
                $config['overwrite'] = FALSE; //if have same name, add number
                $config['remove_spaces'] = TRUE; //change space into _
                $config['encrypt_name'] = TRUE;
                //initialize config upload
                $this->upload->initialize($config);

                if ($this->upload->do_upload('img')) {//if success upload data
                    $result['upload'] = $this->upload->data();
                    $name = $result['upload']['file_name'];
                    $data['pic'] = $path . $name;

                    $img['image_library'] = 'gd2';
                    $img['source_image'] = $path . $name;
                    $img['new_image'] = $path_thumb . $name;
                    $img['maintain_ratio'] = true;
                    $img['width'] = 100;
                    $img['weight'] = 100;

                    $this->image_lib->initialize($img);
                    if ($this->image_lib->resize()) {//if success to resize (create thumbs)
                        $data['pic_thumb'] = $path_thumb . $name;
                    } else {
                        $this->session->set_flashdata('flash_message', err_msg($this->image_lib->display_errors()));
                        redirect('traffic/get_sign/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                    redirect('traffic/get_sign/' . $id);
                }
            }
            // print_r($data);exit;    
            $edit = $this->Trafficmodel->update($id, $data);
            if ($edit == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                redirect('traffic/get_sign/' . $id);
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('traffic/get_sign/' . $id);
            }
        }
    }

    public function delete_sign() {
        $id = $this->input->post('id');
        $data = $this->Trafficmodel->get_img_by_id($id);
        $data_img = explode('/', $data[0]->foto);
        $name_img = $data_img[2];
        $delete = $this->Trafficmodel->delete($id);
        if ($delete == true) {
            $this->delete_file($name_img);
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi...');
        }
    }

    public function delete_file($name = '') {
        $path = './uploads/sign/';
        $path_thumb = './uploads/sign/thumbs/';
        @unlink($path . $name);
        @unlink($path_thumb . $name);
    }

}
