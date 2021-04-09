<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SantriModel extends Render_Model
{
    public function getData($id = null)
    {
        $this->db->select('santri.id_santri, santri.nama, santri.jenis_kelamin, santri.tanggal, santri.alamat, santri.no_hp, santri.status, santri_ruang.nama as ruang, santri_tahun_ajaran.nama as tahun_ajaran, santri_tingkat.nama as tingkat, santri_kelas.nama as kelas');
        $this->db->from('santri');
        $this->db->join('santri_tingkat', 'santri_tingkat.id = santri.tingkat_id');
        $this->db->join('santri_kelas', 'santri_kelas.id = santri.kelas_id');
        $this->db->join('santri_ruang', 'santri_ruang.id = santri.ruang_id');
        $this->db->join('santri_tahun_ajaran', 'santri_tahun_ajaran.id = santri.tahun_ajaran_id');
        if ($id) {
            $this->db->where('santri.id_santri', $id);
            return $this->db->get()->row_array();
        } else {
            return $this->db->get()->result_array();
        }
    }

    public function delete($id)
    {
        $exe = $this->db->where('id_santri', $id);
        $exe = $this->db->delete('santri');

        return $exe;
    }
}