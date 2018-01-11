<?php

class Berandamodel extends CI_Model {

    /**
     * GET DATA BERANDA
     */
    public function get_beranda_worker($id = '') {

        $sql = $this->db->query("SELECT
                                (SELECT count(id_projek) from project where status_projek=3 and id_plapangan=$id) as pro_lap_selesai, 
                                (SELECT count(id_projek) from project where id_plapangan=$id) as tot_lap, 
                                (SELECT count(id_projek) from project where status_projek=3 and id_penyurvei=$id) as pro_sur_selesai, 
                                (SELECT count(id_projek) from project where id_penyurvei=$id) as tot_sur, 
                                (SELECT count(id_tugas) from data_project where id_penyurvei=$id) as tot_job_survei, 
                                (SELECT count(id_tugas) from data_project where id_plapangan=$id) as tot_job_lapangan, 
                                (SELECT count(id_tugas) from data_project where status_pasang=1 and id_plapangan=$id) as tot_job_lap_terpasang, 
                                id_user, id_posisi, nama_petugas, alamat,foto_thumb from user where id_user=$id");
        return $sql->result_array();
    }
    
//     public function get_beranda_admin($id = '') {
//
//        $sql = $this->db->query("SELECT (SELECT count(id_projek) from project where status_projek=3) as pro_selesai, 
//                               (SELECT count(id_projek) from project where not status_projek=3) as pro_blm_selesai, 
//                               (SELECT count(id_projek) from project ) as tot_project, 
//                               (SELECT count(id_tugas) from data_project where status_pasang=1) as job_selesai, 
//                               (SELECT count(id_tugas) from data_project where status_pasang=0) as job_blm_selesai, 
//                               (SELECT count(id_tugas) from data_project ) as tot_job, 
//                                id_user, id_posisi, nama_petugas, alamat,foto_thumb from user where id_user=$id");
//        return $sql->result_array();
//    }
}
