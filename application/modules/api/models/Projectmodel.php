<?php

class Projectmodel extends CI_Model {

    private $table_job = 'data_project';
    private $table_project = 'project';
    private $table_sign = 'traffic_sign';
    private $table_user = 'user';

    /**
     * METHOD/FUNCTION JOBS CRUD
     */
    public function get_job($id = '') {
        $sql = $this->db->query("SELECT (SELECT nama_petugas from user join data_project where id_user=id_plapangan and id_tugas=$id) as nama_plapangan, (SELECT nama_petugas from user join data_project where id_user=id_penyurvei and id_tugas=$id) as nama_penyurvei, p.nama_projek, r.foto_thumb, t.id_tugas, t.id_projek, t.id_penyurvei, t.id_plapangan, t.nama_rambu, t.lokasi_jalan, t.kode_rambu, t.id_jenis_rambu, t.lebar_jalan, t.lebar_bahu_jalan, t.sisi_jalan, t.lat, t.long, t.keterangan, t.foto_thumb as image,t.status_rambu,t.status_pasang FROM data_project t JOIN project p JOIN traffic_sign r WHERE t.kode_rambu=r.kode_rambu AND t.id_projek=p.id_projek AND t.id_tugas=$id");
        return $sql->result_array();
    }

    public function get_list_job($id = '', $limit = '') {
        $sql = $this->db->query("SELECT p.id_tugas,p.id_projek,id_plapangan,id_penyurvei, SUBSTR(p.nama_rambu,1,29) as nama_rambu, SUBSTR(p.lokasi_jalan,1,37) as lokasi_jalan,t.foto_thumb as foto_rambu, DATE_FORMAT(cast(p.tanggal as date), '%d/%m/%Y') as tgl_buat, set_pasang(p.status_pasang) as status_pasang,set_status_rambu(p.status_rambu) as status_rambu from data_project p join traffic_sign t where p.id_jenis_rambu=t.id_jenis_rambu and p.kode_rambu=t.kode_rambu and p.id_projek=$id ORDER BY tanggal LIMIT $limit");
        return $sql->result_array();
    }

     public function get_img_job_by_id_pro($id = '') {
        $sql = $this->db->query("SELECT `foto` from data_project where id_projek=$id");
        return $sql->result();
    }
    
    public function count_job($id = '') {
        $this->db->where('id_projek', $id);
        $sql = $this->db->get($this->table_job);
        return $sql->num_rows();
    }

    public function insert_job($id_pro = '', $id_lap = '', $id_sur = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'id_projek' => $id_pro,
            'id_penyurvei' => $id_sur,
            'id_plapangan' => $id_lap,
            'nama_rambu' => $value['nama_rambu'],
            'lokasi_jalan' => $value['lokasi'],
            'kode_rambu' => $value['kode_rambu'],
            'id_jenis_rambu' => $value['jenis_rambu'],
            'lebar_jalan' => $value['lebar_jalan'],
            'lebar_bahu_jalan' => $value['lebar_bahu'],
            'sisi_jalan' => $value['sisi_jalan'],
            'lat' => $value['lat'],
            'long' => $value['long'],
            'keterangan' => $value['keterangan'],
            'status_rambu' => $value['status_rambu'],
            'foto' => $value['pic'],
            'foto_thumb' => $value['pic_thumb'],
        );
        $this->db->insert($this->table_job, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update_job($id_job = '', $id_pro = '', $id_lap = '', $id_sur = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'id_projek' => $id_pro,
            'id_penyurvei' => $id_sur,
            'id_plapangan' => $id_lap,
            'nama_rambu' => $value['nama_rambu'],
            'lokasi_jalan' => $value['lokasi'],
            'kode_rambu' => $value['kode_rambu'],
            'id_jenis_rambu' => $value['jenis_rambu'],
            'lebar_jalan' => $value['lebar_jalan'],
            'lebar_bahu_jalan' => $value['lebar_bahu'],
            'sisi_jalan' => $value['sisi_jalan'],
            'lat' => $value['lat'],
            'long' => $value['long'],
            'keterangan' => $value['keterangan'],
            'status_rambu' => $value['status_rambu'],
            'foto' => $value['pic'],
            'foto_thumb' => $value['pic_thumb'],
        );

        $this->db->where('id_tugas', $id_job);
        $this->db->update($this->table_job, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update_status_job($id = '', $status = '') {
        $this->db->trans_begin();

        $data = array(
            'status_pasang' => $status,
        );
        $this->db->where('id_tugas', $id);
        $this->db->update($this->table_job, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function delete_job($value = '') {
        $this->db->trans_begin();

        $this->db->where('id_tugas', $value);
        $this->db->delete($this->table_job);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    /**
     * METHOD/FUNCTION SPINNER 
     */
    function get_code_sign($id_jenis = '') {
        $this->db->select('kode_rambu,nama_rambu');
        $this->db->where('id_jenis_rambu', $id_jenis);
        $sql = $this->db->get($this->table_sign);
        return $sql->result();
    }

    /**
     * METHOD/FUNCTION PROJECT CRUD
     */
    public function get_project($id = '') {
        $sql = $this->db->query("SELECT (SELECT nama_petugas from user join project where id_user=id_plapangan and id_projek=$id) as nama_plapangan, (SELECT nama_petugas from user join project where id_user=id_penyurvei and id_projek=$id) as nama_penyurvei,id_projek ,id_penyurvei,id_plapangan, nama_daerah, nama_projek, status_projek, deskripsi,DATE_FORMAT(tgl_mulai, '%d/%l/%Y') as tgl_mulai,DATE_FORMAT(tgl_selesai, '%d/%l/%Y') as tgl_selesai from project where id_projek=$id ORDER BY tanggal_buat ASC");
        return $sql->result_array();
    }

    public function get_list_lap_project($id = '', $limit = '') {
        $sql = $this->db->query("SELECT fu.nama_petugas as nama_psurvei, tu.nama_petugas as nama_plapangan,`id_projek`, `id_penyurvei`, `id_plapangan`, `nama_daerah`, SUBSTR(nama_projek,1,23) as nama_projek, `status_projek`, `deskripsi`,DATE_FORMAT(cast(tgl_mulai as date), '%d/%m/%Y') as tanggal_mulai,DATE_FORMAT(cast(tgl_selesai as date), '%d/%m/%Y') as tanggal_selesai FROM project p left JOIN user fu ON fu.id_user = p.id_penyurvei and p.id_plapangan=$id LEFT JOIN user tu ON tu.id_user = p.id_plapangan WHERE p.id_plapangan=$id ORDER BY tanggal_buat ASC LIMIT $limit");
        return $sql->result_array();
    }

    public function get_list_sur_project($id = '',$limit='') {
        $sql = $this->db->query("SELECT fu.nama_petugas as nama_psurvei, tu.nama_petugas as nama_plapangan,`id_projek`, `id_penyurvei`, `id_plapangan`, `nama_daerah`, SUBSTR(nama_projek,1,23) as nama_projek, `status_projek`, `deskripsi`,DATE_FORMAT(cast(tgl_mulai as date), '%d/%m/%Y') as tanggal_mulai,DATE_FORMAT(cast(tgl_selesai as date), '%d/%m/%Y') as tanggal_selesai FROM project p LEFT JOIN user fu ON fu.id_user = p.id_penyurvei and p.id_penyurvei=$id LEFT JOIN user tu ON tu.id_user = p.id_plapangan WHERE p.id_penyurvei=$id ORDER BY tanggal_buat ASC LIMIT $limit");
        return $sql->result_array();
    }

    public function count_project_lap($id = '') {
        $this->db->where('id_plapangan', $id);
        $this->db->where('status_projek', 2);
        $this->db->or_where('status_projek', 3); 
        $sql = $this->db->get($this->table_project);
        return $sql->num_rows();
    }

    public function count_project_sur($id = '') {
        $this->db->where('id_penyurvei', $id);
        $sql = $this->db->get($this->table_project);
        return $sql->num_rows();
    }

    public function insert_project($value = '') {
        $this->db->trans_begin();

        $data = array(
            'id_penyurvei' => $value['psurvei'],
            'id_plapangan' => $value['plapangan'],
            'nama_projek' => $value['nama_projek'],
            'nama_daerah' => $value['nama_daerah'],
            'status_projek' => $value['proses_prj'],
            'tgl_mulai' => $value['projek_mulai'],
            'tgl_selesai' => $value['projek_selesai'],
            'deskripsi' => $value['keterangan'],
        );
        $this->db->insert($this->table_project, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update_status_projek($id = '', $status = '') {
        $this->db->trans_begin();

        $data = array(
            'status_projek' => $status,
        );
        $this->db->where('id_projek', $id);
        $this->db->update($this->table_project, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function get_by_id_project($id = '') {
        $this->db->where('id_projek', $id);
        $sql = $this->db->get($this->table_project);
        return $sql->result();
    }

    public function update_project($id = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'nama_projek' => $value['nama_projek'],
            'nama_daerah' => $value['nama_daerah'],
            'id_plapangan' => $value['plapangan'],
            'status_projek' => $value['proses_prj'],
            'id_penyurvei' => $value['psurvei'],
            'tgl_mulai' => $value['projek_mulai'],
            'tgl_selesai' => $value['projek_selesai'],
            'deskripsi' => $value['keterangan'],
        );

        $this->db->where('id_projek', $id);
        $this->db->update($this->table_project, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function set_worker_project($id = '', $value = '') {
        $this->db->trans_begin();
        $data = array(
            'id_plapangan' => $value['plapangan'],
        );
        $this->db->where('id_projek', $id);
        $this->db->update($this->table_job, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function delete_project($value) {
        $this->db->trans_begin();

        $this->db->where('id_projek', $value);
        $this->db->delete($this->table_project);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
 /**
     * METHOD/FUNCTION HELPER
     */
    public function get_img_by_id_job($id = '') {
        $this->db->select('foto');
        $this->db->where('id_tugas', $id);
        $sql = $this->db->get($this->table_job);
        return $sql->result();
    }
    
     public function delete_all_job($value = '') {
        $this->db->trans_begin();

        $this->db->where('id_projek', $value);
        $this->db->delete($this->table_job);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }
    //get reg id
    public function get_reg_id($id_user=''){
       $this->db->select('reg_id');
        $this->db->where('id_user', $id_user);
        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }
     //get id lap/sur project
    public function get_id_worker($id_projek=''){
        $this->db->select('id_plapangan,id_penyurvei');
        $this->db->where('id_projek', $id_projek);
        $sql = $this->db->get($this->table_project);
        return $sql->result();
    }
}
