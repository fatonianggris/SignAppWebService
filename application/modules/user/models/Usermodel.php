<?php

class Usermodel extends CI_Model {

    private $table = 'user';

    public function get_by_id($id = '') {
        $this->db->where('id_user', $id);
        $sql = $this->db->get($this->table);
        return $sql->result();
    }

    public function get_img_by_id($id = '') {
        $this->db->select('foto');
        $this->db->where('id_user', $id);
        $sql = $this->db->get($this->table);
        return $sql->result();
    }

    public function get_all() {
        $sql = $this->db->get($this->table);
        return $sql->result();
    }

    public function insert($value = '') {
        $passwd = md5($value['password']);
        $this->db->trans_begin();

        $data = array(
            'nama_petugas' => $value['nama_petugas'],
            'username' => $value['username'],
            'email' => $value['email'],
            'id_posisi' => $value['posisi'],
            'no_telp' => $value['no_telp'],
            'alamat' => $value['alamat'],
            'password' => $passwd,
            'foto' => $value['pic'],
            'foto_thumb' => $value['pic_thumb'],
        );
        $this->db->insert($this->table, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update_pass($id = '', $value = '') {
        $passwd = md5($value['password']);
        $this->db->trans_begin();
        $data = array(
            'password' => $passwd
        );
        $this->db->where('id_user', $id);
        $this->db->update($this->table, $data);
        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function update($id = '', $value = '') {
        $this->db->trans_begin();
        $data = array(
            'nama_petugas' => $value['nama_petugas'],
            'username' => $value['username'],
            'email' => $value['email'],
            'id_posisi' => $value['posisi'],
            'no_telp' => $value['no_telp'],
            'alamat' => $value['alamat'],
            'foto' => $value['pic'],
            'foto_thumb' => $value['pic_thumb'],
        );

        $this->db->where('id_user', $id);
        $this->db->update($this->table, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

    public function delete($value) {
        $this->db->trans_begin();

        $this->db->where('id_user', $value);
        $this->db->delete($this->table);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}
?>

