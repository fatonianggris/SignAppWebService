<?php

class User extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here
        if ($this->session->userdata('signapps') == FALSE) {
            redirect('auth');
        }
        $this->load->model('Usermodel');
    }

    public function index() {
        $data['title'] = "Sign Apps";
        $data['nav'] = "Tambah Petugas Baru";
        $data['act'] = "petugas";
        $this->template->load('template/template', 'input_user', $data);
    }

    public function get_user($id = '') {

        $data['title'] = "Sign Apps";
        $data['nav'] = "Pengaturan Akun";
        $data['setting'] = $this->Usermodel->get_by_id($id);
        $cek = $this->Usermodel->get_by_id($id);
        if ($cek == FALSE or empty($id)) {
            $data['title'] = 'Sign Apps | Error 404 ';
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $this->template->load('template/template', 'edit_user', $data);
        }
    }

    public function list_user() {
        $data['title'] = "Sign Apps";
        $data['nav'] = "Daftar Data Petugas";
        $data['act'] = "petugas";
        $data['list'] = $this->Usermodel->get_all();
        $this->template->load('template/template', 'list_user', $data);
    }

    public function add_user() {
        $this->load->library('form_validation');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('posisi', 'Posisi', 'required');
        $this->form_validation->set_rules('no_telp', 'Nomor HP/Telp', 'required');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|matches[cf_passwd]');
        $this->form_validation->set_rules('cf_passwd', 'Password Konfirmasi', 'required|min_length[4]');

        if ($this->form_validation->run() == FALSE) {
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('user/'); //folder, controller, method
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image
            if (!empty($_FILES['img'])) {

                $path = 'uploads/user/';
                $path_thumb = 'uploads/user/thumbs/';
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
                        redirect('user/');
                    }
                } else {
                    $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                    redirect('user/');
                }
            }

            $input = $this->Usermodel->insert($data);
            if ($input == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan..'));
                redirect('user/');
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('user/');
            }
        }
    }

    public function edit_user($id = '') {

        $this->load->library('form_validation');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('nama_petugas', 'Nama Petugas', 'required');
        $this->form_validation->set_rules('username', 'Username', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('posisi', 'Posisi', 'required');
        $this->form_validation->set_rules('no_telp', 'Nomor HP/Telp', 'required');

        $data['pic'] = $data['image'];
        $data['pic_thumb'] = $data['image_thumb'];

        $data_img = explode('/', $data['image']);
        $img_name = $data_img[2];

        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('user/get_user/' . $id);
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image
            if (!empty($_FILES['img']['tmp_name'])) {

                $this->delete_file($img_name); //delete existing file

                $path = 'uploads/user/';
                $path_thumb = 'uploads/user/thumbs/';
                //config upload file
                $config['upload_path'] = $path;
                $config['allowed_types'] = 'jpg|png|jpeg';
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
                        redirect('user/get_user/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                    redirect('user/get_user/' . $id);
                }
            }
            $edit = $this->Usermodel->update($id, $data);
            if ($edit == true) {
                if (!empty($_POST['password'])) {
                    $this->change_pass($id);
                } else {
                    $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan...'));
                    redirect('user/get_user/' . $id);
                }
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('user/get_user/' . $id);
            }
        }
    }

    public function change_pass($id = '') {
        $this->load->library('form_validation');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('password', 'Password', 'required|min_length[4]|matches[cf_passwd]');
        $this->form_validation->set_rules('cf_passwd', 'Password Konfirmasi', 'required|min_length[4]');

        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('user/get_user/' . $id);
        } else {

            $edit = $this->Usermodel->update_pass($id, $data);
            if ($edit == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data telah tersimpan...'));
                redirect('user/get_user/' . $id);
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('user/get_user/' . $id);
            }
        }
    }

    public function delete_user() {
        $id = $this->input->post('id');
        $data = $this->Usermodel->get_img_by_id($id);
        $data_img = explode('/', $data[0]->foto);
        $name_img = $data_img[2];
        $delete = $this->Usermodel->delete($id);
        if ($delete == true) {
            $this->delete_file($name_img);
            echo '1|' . succ_msg('Berhasil, User telah terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_file($name = '') {
        $path = './uploads/user/';
        $path_thumb = './uploads/user/thumbs/';
        @unlink($path . $name);
        @unlink($path_thumb . $name);
    }

}
