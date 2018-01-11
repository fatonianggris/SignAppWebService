<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard extends MX_Controller {

    public function __construct() {
        parent::__construct();
        //Do your magic here
        if ($this->session->userdata('signapps') == FALSE) {
            redirect('auth');
        } 
        $this->load->model('Dashboardmodel');
    }

    public function index() {
        $data['title'] = "Sign Apps";
        $data['nav'] = "Beranda";
        $data['beranda'] = $this->Dashboardmodel->get_all();
        $this->template->load('template/template', 'dashboard', $data);
    }
    public function signmap() {
        $data['title'] = "Sign Apps";
        $data['nav'] = "Peta Rambu";
        $data['sign'] = $this->Dashboardmodel->get_sign();
        $this->template->load('template/template', 'signmap', $data);
    }
}
