<?php

class Usermodel extends CI_Model {

    private $table_user = 'user';

    /**
     * METHOD/FUNCTION SPINNER
     */
    public function get_worker($id = '') {
        $this->db->select('id_user, username, nama_petugas');
        $this->db->where('id_posisi', $id);
        $sql = $this->db->get($this->table_user);
        return $sql->result();
    }

    /**
     * METHOD/FUNCTION USER CRUD
     */
    public function get_user($id = '') {

        $sql = $this->db->query("SELECT `id_user`, `id_posisi`, `username`, `nama_petugas`, `email`, `no_telp`, `alamat`,`foto` ,`foto_thumb`,DATE_FORMAT(cast(tanggal_user as date), '%d/%m/%Y') as tanggal_user FROM `user` WHERE id_user=$id");
        return $sql->result_array();
    }

    public function update_user($id = '', $value = '') {
        $this->db->trans_begin();
        $data = array(
            'nama_petugas' => $value['nama_petugas'],
            'email' => $value['email'],
            'id_posisi' => $value['id_posisi'],
            'no_telp' => $value['no_telp'],
            'alamat' => $value['alamat'],
            'foto' => $value['pic'],
            'foto_thumb' => $value['pic_thumb'],
        );

        $this->db->where('id_user', $id);
        $this->db->update($this->table_user, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update_pass($id = '', $value = '') {
        $passwd = md5($value['pass']);
        $this->db->trans_begin();
        $data = array(
            'password' => $passwd
        );
        $this->db->where('id_user', $id);
        $this->db->update($this->table_user, $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}
