<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Project extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here
        if ($this->session->userdata('signapps') == FALSE) {
            redirect('auth');
        }
        $this->load->model('Projectmodel');
        $this->load->library("Pdf");
        $this->load->library("firebase/Firebase");
        $this->load->library("firebase/Push");
        $this->load->library("firebase/config");
        $this->load->library('user_agent');
        //$this->db->cache_delete('android', 'job');
        //$this->output->clear_all_cache();
    }

    public function index() {
        $data['title'] = "Sign Apps";
        $data['nav'] = "Tambah Projek Baru";
        $data['act'] = "projek";
        $data['lapworker'] = $this->Projectmodel->get_lap_worker();
        $data['surworker'] = $this->Projectmodel->get_sur_worker();
        $this->template->load('template/template', 'input_project', $data);
    }

    public function loadData() {
        $loadType = $_POST['loadType'];
        $loadId = $_POST['loadId'];

        $result = $this->Projectmodel->getData($loadType, $loadId);
        $HTML = "";

        if ($result->num_rows() > 1) {
            foreach ($result->result() as $list) {
                $HTML.="<option value='" . $list->name . "'>" . $list->name . "</option>";
            }
        } elseif ($result->num_rows() == 1) {
            foreach ($result->result() as $list) {
                $HTML.="<option value='" . $list->name . "'>" . $list->name . "</option>";
            }
        }
        echo $HTML;
    }

    public function input_job($id = '') {
        $cek = $this->Projectmodel->get_by_id_project($id);
        $data['title'] = "Sign Apps";
        $data['nav'] = "Tambah Tugas Baru";
        $data['act'] = "projek";

        if (empty($id) or $cek == FALSE) {
            //add new data
            $data['title'] = 'Sign Apps| Error 404 ';
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $data['id'] = $id;
            $this->template->load('template/template', 'input_job', $data);
        }
    }

    public function list_project() {
        $data['title'] = "Sign Apps";
        $data['nav'] = "Daftar Data Projek";
        $data['act'] = "projek";
        $data['project'] = $this->Projectmodel->get_project();
        $this->template->load('template/template', 'list_project', $data);
    }

    public function list_job($id = '') {
        $data['title'] = "Sign Apps";
        $data['nav'] = "Daftar Data Tugas";
        $data['act'] = "projek";
        $data['job'] = $this->Projectmodel->get_all_job($id);
        $cek = $this->Projectmodel->get_by_id_project($id);
        if (empty($id) or $cek == FALSE) {
            //add new data
            $data['title'] = 'Sign Apps | Error 404 ';
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $data['id'] = $id;
            $this->template->load('template/template', 'list_job', $data);
        }
    }

    public function add_job($id = '') {
        $this->load->library('form_validation');

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);
        $cek = $this->Projectmodel->get_by_id_project($id);
        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
        $this->form_validation->set_rules('sisi_jalan', 'Sisi Jalan', 'required');
        $this->form_validation->set_rules('kode_rambu', 'Kode Rambu', 'required');
        $this->form_validation->set_rules('jenis_rambu', 'Jenis Rambu', 'required');
        $this->form_validation->set_rules('lebar_jalan', 'Lebar Jalan', 'required');
        $this->form_validation->set_rules('lebar_bahu', 'Lebar Bahu Jalan', 'required');
        $this->form_validation->set_rules('lat', 'Latitude', 'required');
        $this->form_validation->set_rules('long', 'Longtitude', 'required');
        $data['plapangan'] = $cek[0]->id_plapangan;
        $data['psurvei'] = $cek[0]->id_penyurvei;

        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('project/input_job/' . $id); //folder, controller, method
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image
            if (!empty($_FILES['img'])) {

                $path = 'uploads/job/';
                $path_thumb = 'uploads/job/thumbs/';
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
                        redirect('project/input_job/' . $id);
                    }
                }
            }
            $input = $this->Projectmodel->insert_job($id, $data);
            if ($input == true or ! empty($id) or $cek != FALSE) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                redirect('project/input_job/' . $id);
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('project/input_job/' . $id);
            }
        }
    }

    public function add_project() {
        $this->load->library('form_validation');

        $id_plapangan = $_POST['plapangan'];
        $id_psurvei = $_POST['psurvei'];
        $name_project = $_POST['nama_projek'];

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('nama_daerah', 'Nama Daerah', 'required');
        $this->form_validation->set_rules('nama_projek', 'Nama Projek', 'required');
        $this->form_validation->set_rules('projek_mulai', 'Projek Mulai', 'required');
        $this->form_validation->set_rules('psurvei', 'Nama Petugas Survei', 'required');
        $this->form_validation->set_rules('proses_prj', 'Status Projek', 'required');

        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('project/'); //folder, controller, method
        } else {
            $input = $this->Projectmodel->insert_project($data);
            if ($input == true) {
                //set notification
                if ($id_plapangan != '') {
                    $check = $this->Projectmodel->get_reg_id($id_plapangan);
                    if ($check) {
                        $title = 'Projek Baru';
                        $regId = $check[0]->reg_id;
                        $this->push_notification($title, $name_project, $regId);
                    }
                }
                if ($id_psurvei != '') {
                    $check = $this->Projectmodel->get_reg_id($id_psurvei);
                    if ($check) {
                        $title = 'Projek Baru';
                        $regId = $check[0]->reg_id;
                        $this->push_notification($title, $name_project, $regId);
                    }
                }
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                redirect('project/');
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('project/');
            }
        }
    }

    public function get_job($id = '') {

        $data = array();
        $data['title'] = "Sign Apps";
        $data['nav'] = "Edit Tugas"; // ???
        $data['job'] = $this->Projectmodel->get_by_id_job($id); //?
        $cek = $this->Projectmodel->get_by_id_job($id);
        if ($cek == FALSE or empty($id)) {
            $data['title'] = 'Sign Apps | Error 404 ';
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $this->template->load('template/template', 'edit_job', $data);
        }
    }

    public function get_project($id = '') {

        $data = array();
        $data['title'] = "Sign Apps";
        $data['nav'] = "Edit Projek"; // ???
        $data['project'] = $this->Projectmodel->get_by_id_project($id); //?
        $cek = $this->Projectmodel->get_by_id_project($id);
        $data['lapworker'] = $this->Projectmodel->get_lap_worker();
        $data['surworker'] = $this->Projectmodel->get_sur_worker();
        if ($cek == FALSE or empty($id)) {
            $data['title'] = 'Sign Apps | Error 404 ';
            $this->load->view('error_404', $data);
        } else {
            //edit data with id
            $this->template->load('template/template', 'edit_project', $data);
        }
    }

    public function edit_job($id = '') {

        $this->load->library('form_validation');
        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('lokasi', 'Lokasi', 'required');
        $this->form_validation->set_rules('sisi_jalan', 'Sisi Jalan', 'required');
        $this->form_validation->set_rules('kode_rambu', 'Kode Rambu', 'required');
        $this->form_validation->set_rules('jenis_rambu', 'Jenis Rambu', 'required');
        $this->form_validation->set_rules('lebar_jalan', 'Lebar Jalan', 'required');
        $this->form_validation->set_rules('lebar_bahu', 'Lebar Bahu Jalan', 'required');
        $this->form_validation->set_rules('lat', 'Latitude', 'required');
        $this->form_validation->set_rules('long', 'Longtitude', 'required');

        $data['pic'] = $data['image'];
        $data['pic_thumb'] = $data['image_thumb'];

        $data_img = explode('/', $data['image']);
        $img_name = $data_img[2];

        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('project/get_job/' . $id);
        } else {
            $this->load->library('upload'); //load library upload file
            $this->load->library('image_lib'); //load library image
            if (!empty($_FILES['img']['tmp_name'])) {

                $this->delete_file($img_name); //delete existing file

                $path = 'uploads/job/';
                $path_thumb = 'uploads/job/thumbs/';
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
                        redirect('user/get_job/' . $id);
                    }
                } else {
                    $this->session->set_flashdata('flash_message', warn_msg($this->upload->display_errors()));
                    redirect('user/get_job/' . $id);
                }
            }
            $edit = $this->Projectmodel->update_job($id, $data);
            if ($edit == true) {
                $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                redirect('project/get_job/' . $id);
            } else {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                redirect('project/get_job/' . $id);
            }
        }
    }

    public function edit_project($id = '') {
        $this->load->library('form_validation');

        $id_plapangan = $_POST['plapangan'];
        $id_psurvei = $_POST['psurvei'];
        $name_project = $_POST['nama_projek'];

        $param = $this->input->post();
        $data = $this->security->xss_clean($param);

        $this->form_validation->set_rules('nama_daerah', 'Nama Daerah', 'required');
        $this->form_validation->set_rules('nama_projek', 'Nama Projek', 'required');
        $this->form_validation->set_rules('projek_mulai', 'Projek Mulai', 'required');
        $this->form_validation->set_rules('proses_prj', 'Status Projek', 'required');
        $this->form_validation->set_rules('psurvei', 'Nama Petugas Survei', 'required');
        //cek id plap old
        $check_id = $this->Projectmodel->get_id_worker($id);
        if ($this->form_validation->run() == FALSE) {
            //
            $this->session->set_flashdata('flash_message', warn_msg(validation_errors()));
            redirect('project/get_project/' . $id);
        } else {
            if ($_POST['plapangan'] == $_POST['psurvei']) {
                $this->session->set_flashdata('flash_message', err_msg('Maaf, Petugas tidak boleh mengerjakan survei dan lapangan secara bersamaan...'));
                redirect('project/get_project/' . $id);
            } else {
                $edit = $this->Projectmodel->update_project($id, $data);
                //set notification
                $id_lap_old = $check_id[0]->id_plapangan;
                if (!empty($id_plapangan) and $id_plapangan != $id_lap_old) {
                    $check = $this->Projectmodel->get_reg_id($id_plapangan);
                    if ($check) {
                        $title = 'Projek Baru';
                        $regId = $check[0]->reg_id;
                        $this->push_notification($title, $name_project, $regId);
                    }
                }
                $id_sur_old = $check_id[0]->id_penyurvei;
                if (!empty($id_psurvei) and $id_psurvei != $id_sur_old) {
                    $check = $this->Projectmodel->get_reg_id($id_psurvei);
                    if ($check) {
                        $title = 'Projek Baru';
                        $regId = $check[0]->reg_id;
                        $this->push_notification($title, $name_project, $regId);
                    }
                }
                if ($edit == true) {
                    if (!empty($id_plapangan)) {
                        $this->Projectmodel->set_worker($id, $data);
                    }
                    $this->session->set_flashdata('flash_message', succ_msg('Berhasil, Data Telah Tersimpan..'));
                    redirect('project/get_project/' . $id);
                } else {
                    $this->session->set_flashdata('flash_message', err_msg('Maaf, Terjadi kesalahan...'));
                    redirect('project/get_project/' . $id);
                }
            }
        }
    }

    public function delete_job() {
        $id = $this->input->post('id');
        $data = $this->Projectmodel->get_img_by_id_job($id);
        $data_img = explode('/', $data[0]->foto);
        $name_img = $data_img[2];
        $delete = $this->Projectmodel->delete_job($id);
        if ($delete == true) {
            $this->delete_file($name_img);
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_project() {
        $id = $this->input->post('id');
        $delete = $this->Projectmodel->delete_project($id);
        if ($delete == true) {
            $this->delete_all_job($id);
            echo '1|' . succ_msg('Berhasil, Data Telah Terhapus..');
        } else {
            echo '0|' . err_msg('Maaf, Terjadi kesalahan, Coba lagi....');
        }
    }

    public function delete_file($name = '') {
        $path = './uploads/job/';
        $path_thumb = './uploads/job/thumbs/';
        @unlink($path . $name);
        @unlink($path_thumb . $name);
    }

    public function delete_all_job($id = '') {
        $data = $this->Projectmodel->get_all_job($id);
        foreach ($data as $key => $value) {
            $data_img = explode('/', $value->foto);
            $name_img = $data_img[2];
            $this->delete_file($name_img);
        }
        $this->Projectmodel->delete_all_job($id);
    }

    public function create_report($id = '') {

        $pdfArray = array();

        $data = $this->Projectmodel->get_all_job($id);
        $data1 = $this->Projectmodel->get_all_project($id);
        $cek = $this->Projectmodel->get_by_id_project($id);
        if (empty($id) or $cek == FALSE) {
            //add new data
            $data['title'] = 'Sign Apps | Error 404 ';
            $this->load->view('error_404', $data);
        } else {
            // create new PDF document
            $pdf = new Pdf(PDF_PAGE_ORIENTATION, PDF_UNIT, PDF_PAGE_FORMAT, true, 'UTF-8', false);

            // set document information
            $pdf->SetCreator(PDF_CREATOR);
            $pdf->SetAuthor(PDF_HEADER_TITLE);
            $pdf->SetTitle('Daftar Rincian Penempatan/Perawatan Rambu Lalu Lintas');
            $pdf->SetSubject('Laporan Proyek');

            // set default header data
            $pdf->SetHeaderData(PDF_HEADER_LOGO, PDF_HEADER_LOGO_WIDTH, PDF_HEADER_TITLE, PDF_HEADER_STRING);

            // set header and footer fonts
            $pdf->setHeaderFont(Array(PDF_FONT_NAME_MAIN, '', PDF_FONT_SIZE_MAIN));
            $pdf->setFooterFont(Array(PDF_FONT_NAME_DATA, '', PDF_FONT_SIZE_DATA));

            // set default monospaced font
            $pdf->SetDefaultMonospacedFont(PDF_FONT_MONOSPACED);

            // set margins
            $pdf->SetMargins(PDF_MARGIN_LEFT, PDF_MARGIN_TOP, PDF_MARGIN_RIGHT);
            $pdf->SetHeaderMargin(PDF_MARGIN_HEADER);
            $pdf->SetFooterMargin(PDF_MARGIN_FOOTER);

            // set auto page breaks
            $pdf->SetAutoPageBreak(TRUE, PDF_MARGIN_BOTTOM);

            // set image scale factor
            $pdf->setImageScale(PDF_IMAGE_SCALE_RATIO);

            // set some language-dependent strings (optional)
            if (@file_exists(dirname(__FILE__) . '/lang/eng.php')) {
                require_once(dirname(__FILE__) . '/lang/eng.php');
                $pdf->setLanguageArray($l);
            }
            // set font
            $pdf->SetFont('helvetica', 'B', 12);

            // add a page
            $pdf->AddPage('L', 'A4');
            //$pdf->Cell(0, 0, 'Proyek Jalan Malang', 1, 1, 'C');

            $pdf->SetFont('helvetica', '', 8);
            // Table with rowspans and THEAD
            $theader = '<h1 align="center">DAFTAR RINCIAN PEMASANGAN/PERAWATAN RAMBU LALU LINTAS <br/><font size="10"> PROYEK "' . @strtoupper($data1[0]->nama_projek) . '" TAHUN ' . substr($data1[0]->tgl_mulai, 0, 4) . '</font></h2>
                <br></br>
            <table border="1" style="width:100%">
            <thead>                  
             <tr style="background-color:#D0D0D0;">
              <td width="3%"><b>No.</b></td>
              <td width="15%"><b>Lokasi Jalan</b></td>
              <td width="14%"><b>Sisi Jalan</b></td>
              <td width="8%"><b>Status Rambu</b></td>
              <td width="6%"><b>Jenis Rambu</b></td>
              <td width="5%"><b>Kode Rambu</b></td>
              <td width="20%"><b>Nama Rambu</b></td>
              <td width="4%"><b>Lebar Jalan</b></td>
              <td width="4%"><b>Lebar Bahu</b></td>
              <td width="7%"><b>Latitude</b></td>
              <td width="7%"><b>Longtitude</b></td>
              <td width="7%"><b>Terpasang/Terawat</b></td>
             </tr>
            </thead>';
            array_push($pdfArray, $theader);
            $i = 1;
            foreach ($data as $key => $value) {
                if ($value->status_rambu == 1) {
                    $status = 'Pemasangan';
                } else if ($value->status_rambu == 2) {
                    $status = 'Perawatan';
                }
                if ($value->id_jenis_rambu == 1) {
                    $jenis = 'Peringatan';
                } else if ($value->id_jenis_rambu == 2) {
                    $jenis = 'Larangan';
                } else if ($value->id_jenis_rambu == 3) {
                    $jenis = 'Perintah';
                } else if ($value->id_jenis_rambu == 4) {
                    $jenis = 'Petunjuk';
                }
                if ($value->status_pasang == 1) {
                    $stspasang = 'Selesai';
                } else if ($value->status_pasang == 0) {
                    $stspasang = 'Belum';
                }

                $tcontent = '<tbody><tr>
                        <td width="3%">' . $i . '</td>
                        <td width="15%">' . ucwords($value->lokasi_jalan) . '</td>
                        <td width="14%">' . ucwords($value->sisi_jalan) . '</td>
                        <td width="8%">' . $status . '</td>
                        <td width="6%">' . $jenis . '</td>
                        <td width="5%">' . $value->kode_rambu . '</td>
                        <td width="20%">' . $value->nama_rambu . '</td>
                        <td width="4%">' . $value->lebar_jalan . ' M</td>
                        <td width="4%">' . $value->lebar_bahu_jalan . ' M</td>
                        <td width="7%">' . $value->lat . '</td>
                        <td width="7%">' . $value->long . '</td>
                        <td width="7%">' . $stspasang . '</td>
                       </tr></tbody>';
                $i++;
                array_push($pdfArray, $tcontent);
            }
            if ($data1[0]->status_projek == 0) {
                $stsprojek = '<b>Dalam Proses Survei</b>';
            } else if ($data1[0]->status_projek == 1) {
                $stsprojek = '<b>Dalam Proses Survei Selesai</b>';
            } else if ($data1[0]->status_projek == 2) {
                $stsprojek = '<b>Dalam Proses Lapangan</b> (rawat/pasang)';
            } else {
                $stsprojek = '<b>Projek Selesai</b>';
            }
            $tbot = '<tfoot>
             <tr style="background-color:#F0F0F0;">
              <td width="100%"><font size="8"><b>Catatan :</b> 
                  <br/> Status Projek : ' . @$stsprojek . '
                  <br/> Petugas Lapangan : ' . ucwords(@$data1[0]->nama_plapangan) . ' 
                  <br/> Petugas Survei : ' . ucwords(@$data1[0]->nama_penyurvei) . '
                  <br/> Nama Daerah : ' . ucwords(@$data1[0]->nama_daerah) . '
                  <br/> Masa Projek : ' . @$data1[0]->tgl_mulai . ' s/d ' . @$data1[0]->tgl_selesai . '
                  </font>
              </td>
             </tr>    
            </tfoot></table>';
            array_push($pdfArray, $tbot);
            $table = implode(" ", $pdfArray);

            $tbl = <<<EOD
                {$table}
EOD;
            $pdf->writeHTML($tbl, true, false, false, false, '');

// ---------------------------------------------------------
//Close and output PDF document
          
            if ($this->agent->is_browser('Safari')) {               
                $pdf->Output('Laporan_proyek_' . @$data1[0]->nama_projek . '_' . $data1[0]->tgl_mulai . ' sd ' . @$data1[0]->tgl_selesai . '.pdf', 'D');
            } else {              
                $pdf->Output('Laporan_proyek_' . @$data1[0]->nama_projek . '_' . $data1[0]->tgl_mulai . ' sd ' . @$data1[0]->tgl_selesai . '.pdf', 'I');
            }
        }
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
        $reg = isset($regid) ? $regid : '';

        // set data push notification
        $push->setTitle($tit);
        $push->setMessage('"' . $mess . '"');
        $push->setIsBackground(FALSE);
        $push->setPayload($payload);

        //get respon and json
        $json = $push->getPush();
        $response = $firebase->send($reg, $json);
    }

}
