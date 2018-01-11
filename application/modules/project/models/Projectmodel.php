<?php

class Projectmodel extends CI_Model {

    private $table_job = 'data_project';
    private $table_project = 'project';
    private $table_user = 'user';
    private $table_sign = 'traffic_sign';

    public function get_project() {
        $sql = $this->db->query('SELECT p.id_projek, p.deskripsi, p.nama_projek, p.nama_daerah,DATE_FORMAT(tgl_mulai, "%d-%m-%Y") as tgl_mulai, DATE_FORMAT(tgl_selesai, "%d-%m-%Y") as tgl_selesai,p.status_projek, u.id_user, u.nama_petugas as nama_plapangan,count(d.id_penyurvei) as total_data from project p left join user u on p.id_plapangan= u.id_user left join data_project d on p.id_projek = d.id_projek group by p.id_projek ORDER BY tanggal_buat DESC');
        return $sql->result();
    }

    public function get_lap_worker() {
        $this->db->where('id_posisi', 3);
        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    public function get_sur_worker() {
        $this->db->where('id_posisi', 1);
        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    public function get_all_job($id = '') {
        $sql = $this->db->query("SELECT
                (SELECT nama_petugas from user join project where id_user=id_plapangan and id_projek='$id') as nama_plapangan, 
                (SELECT nama_petugas from user join project where id_user=id_penyurvei and id_projek='$id') as nama_penyurvei,
                `id_tugas`, `id_projek`, `nama_rambu`, `lokasi_jalan`, `kode_rambu`, `id_jenis_rambu`, `lebar_jalan`, `lebar_bahu_jalan`, `sisi_jalan`, `lat`, `long`,`keterangan`, `foto`, `foto_thumb`, `tanggal`,status_pasang, `status_rambu` 
                from data_project where id_projek='$id' ORDER BY tanggal DESC");
        return $sql->result();
    }

    function getData($loadType, $loadId) {
        if ($loadType == "code") {
            $fieldList = 'id_rambu,kode_rambu as name';
            $fieldName = 'id_jenis_rambu';
            $this->db->where($fieldName, $loadId);
        } else {
            $fieldList = 'id_rambu,nama_rambu as name';
            $fieldName = 'id_jenis_rambu';
            $fieldCode = 'kode_rambu';
            $this->db->where($fieldName, $loadType);
            $this->db->where($fieldCode, $loadId);
        }

        $this->db->select($fieldList);
        $this->db->from($this->table_sign);
        $query = $this->db->get();
        return $query;
    }

    public function get_img_by_id_job($id = '') {
        $this->db->select('foto');
        $this->db->where('id_tugas', $id);
        $sql = $this->db->get($this->table_job);
        return $sql->result();
    }

    public function get_by_id_project($id = '') {
        $sql = $this->db->query("SELECT (SELECT nama_petugas from user join project where id_user=id_plapangan and id_projek='$id') as nama_plapangan,
                                (SELECT nama_petugas from user join project where id_user=id_penyurvei and id_projek='$id') as nama_penyurvei,
                                id_projek, deskripsi,id_plapangan,id_penyurvei, nama_projek, nama_daerah, tgl_mulai, tgl_selesai, status_projek 
                                from project  
                                where id_projek='$id'");
        return $sql->result();
    }

    public function get_by_id_job($id = '') {
        $this->db->where('id_tugas', $id);
        $sql = $this->db->get($this->table_job);
        return $sql->result();
    }

    public function get_all_project($id = '') {
        $sql = $this->db->query("SELECT (SELECT nama_petugas from user join project where id_user=id_plapangan and id_projek='$id') as nama_plapangan,
                                (SELECT nama_petugas from user join project where id_user=id_penyurvei and id_projek='$id') as nama_penyurvei,
                                id_projek, deskripsi,id_plapangan,id_penyurvei, nama_projek, nama_daerah, tgl_mulai, tgl_selesai, status_projek 
                                from project  
                                where id_projek='$id'");
        return $sql->result();
    }

    public function count_job() {
        $sql = $this->db->get($this->table_job);
        return $sql->num_rows();
    }

    public function count_project() {
        $sql = $this->db->get($this->table_project);
        return $sql->num_rows();
    }

    public function insert_job($id = '', $value = '') {
        $this->db->trans_begin();
        // $user = $this->session->userdata('papb');

        $data = array(
            'id_penyurvei' => $value['psurvei'],
            'id_projek' => $id,
            'id_plapangan' => $value['plapangan'],
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

    public function insert_project($value = '') {
        $this->db->trans_begin();
        //$user = $this->session->userdata('papb');
        $data = array(
            'id_penyurvei' => $value['psurvei'],
            'id_plapangan' => $value['plapangan'],
            'nama_projek' => $value['nama_projek'],
            'nama_daerah' => $value['nama_daerah'],
            'status_projek' => $value['proses_prj'],
            'tgl_mulai' => $value['projek_mulai'],
            'tgl_selesai' => $value['projek_selesai'],
            'deskripsi' => $value['desc'],
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

    public function update_job($id = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'nama_rambu' => $value['nama_rambu'],
            'lokasi_jalan' => $value['lokasi'],
            'kode_rambu' => $value['kode_rambu'],
            'id_jenis_rambu' => $value['jenis_rambu'],
            'lebar_jalan' => $value['lebar_jalan'],
            'lebar_bahu_jalan' => $value['lebar_bahu'],
            'sisi_jalan' => $value['sisi_jalan'],
            'lat' => $value['lat'],
            'long' => $value['long'],
            'status_rambu' => $value['status_rambu'],
            'status_pasang' => $value['sts_pasang'],
            'keterangan' => $value['keterangan'],
            'foto' => $value['pic'],
            'foto_thumb' => $value['pic_thumb'],
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
            'deskripsi' => $value['desc'],
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

    public function set_worker($id = '', $value = '') {
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

    public function delete_job($value) {
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

    //get reg id
    public function get_reg_id($id_user = '') {
        $this->db->select('reg_id');
        $this->db->where('id_user', $id_user);
        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    //get id lap/sur project
    public function get_id_worker($id_projek = '') {
        $this->db->select('id_plapangan,id_penyurvei');
        $this->db->where('id_projek', $id_projek);
        $sql = $this->db->get($this->table_project);
        return $sql->result();
    }

}
