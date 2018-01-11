<?php

class Authmodel extends CI_Model {

    private $table = 'user';

    // check login
    public function check_login($username = '', $password = '') {
        $pass = md5($password);
        $this->db->select('id_user, id_posisi, nama_petugas,email,alamat,no_telp,foto_thumb');
        $this->db->where('username', $username);
        $this->db->where('password', $pass);
        $sql = $this->db->get($this->table);
        return $sql->result();
    }

    // set reg id
    public function set_reg_id($id_user = '', $reg_id = '') {
        $this->db->trans_begin();

        $data = array(
            'reg_id' => $reg_id,
        );
        $this->db->where('id_user', $id_user);
        $this->db->update($this->table, $data);

        if ($this->db->trans_status() === false) {
            $this->db->trans_rollback();
            return false;
        } else {
            $this->db->trans_commit();
            return true;
        }
    }

}
