<?php

class Authmodel extends CI_Model {

    private $table = 'user';

    public function get_user($value = '') {
        $passwd = md5($value['password']);
        $this->db->where('username', $value['username']);
        $this->db->where('password', $passwd);
        $sql = $this->db->get($this->table);
        return $sql->result();
    }
}
