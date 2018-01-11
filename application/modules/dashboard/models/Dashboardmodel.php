<?php

class Dashboardmodel extends CI_Model {

    public function get_all() {
        $sql = $this->db->query('select (select count(id_projek) from project) as projek, (select count(id_tugas) from data_project) as tugas, (select count(id_user) from user) as user, (select count(id_rambu) from traffic_sign) as rambu, (select projek+tugas+user+rambu) as total_data');
        return $sql->result();
    }

    public function get_sign() {
        $sql = $this->db->query('SELECT t.foto_thumb, d.lokasi_jalan, d.lat,d.long from data_project d join traffic_sign t where t.kode_rambu = d.kode_rambu');
        return $sql->result();
    }

}

?>