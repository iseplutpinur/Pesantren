<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RuangModel extends Render_Model
{
    public function getData()
    {
        return $this->db->get("santri_ruang")->result_array();
    }

    public function delete($id)
    {
        $exe = $this->db->where('id', $id);
        $exe = $this->db->delete('santri_ruang');

        return $exe;
    }

    public function insert($nama)
    {
        $data['nama']  = $nama;

        $execute = $this->db->insert('santri_ruang', $data);
        $exe['id'] = $this->db->insert_id();

        return $exe;
    }
    public function update($id, $nama)
    {
        $data['nama']             = $nama;

        $execute                     = $this->db->where('id', $id);
        $execute                     = $this->db->update('santri_ruang', $data);
        return $execute;
    }
}
