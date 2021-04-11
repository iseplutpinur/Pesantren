<?php
defined('BASEPATH') or exit('No direct script access allowed');

class IzinModel extends Render_Model
{
    public function getData($id = null)
    {
        $this->db->select('izin.*, santri.nama');
        $this->db->from('izin');
        $this->db->join('santri', 'izin.id_santri = santri.id_santri');
        if ($id) {
            $this->db->where('izin.id', $id);
            return $this->db->get()->row_array();
        } else {
            return $this->db->get()->result_array();
        }
    }

    public function cari($key)
    {
        $this->db->select('santri.id_santri as id, santri.nama as text');
        $this->db->from('santri');
        $this->db->like('santri.nama', $key);
        return $this->db->get()->result_array();
    }



    public function delete($id)
    {
        $exe = $this->db->where('id_santri', $id);
        $exe = $this->db->delete('santri');

        return $exe;
    }

    public function insert($id_santri, $tanggal_izin, $tanggal_selesai, $keterangan)
    {
        $data['id_santri'] = $id_santri;
        $data['tanggal_izin'] = $tanggal_izin;
        $data['tanggal_selesai'] = $tanggal_selesai;
        $data['keterangan'] = $keterangan;

        $execute = $this->db->insert('izin', $data);
        $exe['id'] = $this->db->insert_id();

        return $exe;
    }

    public function update($id_santri, $tingkat_id, $kelas_id, $ruang_id, $tahun_ajaran_id, $nama, $jenis_kelamin, $alamat, $status, $tanggal_lahir, $no_hp)
    {
        $id = $id_santri;
        $data['tingkat_id'] = $tingkat_id;
        $data['kelas_id'] = $kelas_id;
        $data['kelas_id'] = $kelas_id;
        $data['ruang_id'] = $ruang_id;
        $data['tahun_ajaran_id'] = $tahun_ajaran_id;
        $data['nama'] = $nama;
        $data['jenis_kelamin'] = $jenis_kelamin;
        $data['alamat'] = $alamat;
        $data['status'] = $status;
        $data['tanggal_lahir'] = $tanggal_lahir;
        $data['no_hp'] = $no_hp;

        $execute                     = $this->db->where('id_santri', $id);
        $execute                     = $this->db->update('santri', $data);
        $exe['id']                     = $id;

        return $exe;
    }
}
