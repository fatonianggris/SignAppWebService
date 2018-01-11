<?php

class Trafficmodel extends CI_Model {

    private $table = 'traffic_sign';

    public function get_by_id($id = '') {
        $this->db->where('id_rambu', $id);
        $sql = $this->db->get($this->table);
        return $sql->result();
    }

    public function get_img_by_id($id = '') {
        $this->db->select('foto');
        $this->db->where('id_rambu', $id);
        $sql = $this->db->get($this->table);
        return $sql->result();
    }

    public function get_all() {
        $sql = $this->db->get($this->table);
        return $sql->result();
    }

    public function count() {
        $sql = $this->db->get($this->table);
        return $sql->num_rows();
    }

    public function insert($value = '') {
        $this->db->trans_begin();

        $data = array(
            'id_jenis_rambu' => $value['jenis_rambu'],
            'kode_rambu' => $value['kode_rambu'],
            'nama_rambu' => $value['nama_rambu'],
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

    public function update($id = '', $value = '') {
        $this->db->trans_begin();

        $data = array(
            'id_jenis_rambu' => $value['jenis_rambu'],
            'kode_rambu' => $value['kode_rambu'],
            'nama_rambu' => $value['nama_rambu'],
            'foto' => $value['pic'],
            'foto_thumb' => $value['pic_thumb'],
        );

        $this->db->where('id_rambu', $id);
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

        $this->db->where('id_rambu', $value);
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

