<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Izin extends Render_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('perizinan/IzinModel', 'Izin');
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');

        // Cek session
        $this->sesion->cek_session();
    }

    public function index()
    {
        // Page Settings
        $this->title                     = 'Data Perizinan';
        $this->content                     = 'perizinan-izin';
        $this->navigation                 = ['Data Perizinan', 'Izin'];
        $this->plugins                     = ['datatables', 'select2'];

        // // Breadcrumb setting
        $this->breadcrumb_1             = 'Dashboard';
        $this->breadcrumb_1_url         = base_url() . 'Santri';
        $this->breadcrumb_2             = 'Data Perizinan';
        $this->breadcrumb_2_url         = '#';
        $this->breadcrumb_3             = 'Izin';
        $this->breadcrumb_3_url = '#';

        // // Send data to view
        $this->data['records'] = $this->Izin->getData();
        $this->render();
    }

    public function cari()
    {
        $key = $this->input->post('q');
        // jika inputan ada
        if ($key) {
            $this->output_json([
                "results" => $this->Izin->cari($key)
            ]);
        } else {
            $this->output_json([
                "results" => []
            ]);
        }
    }
    // Delete data
    public function delete()
    {
        $id                             = $this->input->post('id');

        $exe                             = $this->Santri->delete($id);

        $this->output_json(
            [
                'id'             => $id
            ]
        );
    }

    public function insert()
    {
        $id_santri = $this->input->post('id_santri');
        $tanggal_izin = $this->input->post('tanggal_izin');
        $tanggal_selesai = $this->input->post('tanggal_selesai');
        $keterangan = $this->input->post('keterangan');

        $exe = $this->Izin->insert($id_santri, $tanggal_izin, $tanggal_selesai, $keterangan);

        $this->output_json($this->Izin->getData($exe['id']));
    }

    public function update()
    {
        $id_santri = $this->input->post('id_santri');
        $tingkat_id = $this->input->post('tingkat_id');
        $kelas_id = $this->input->post('kelas_id');
        $ruang_id = $this->input->post('ruang_id');
        $tahun_ajaran_id = $this->input->post('tahun_ajaran_id');
        $nama = $this->input->post('nama');
        $jenis_kelamin = $this->input->post('jenis_kelamin');
        $alamat = $this->input->post('alamat');
        $status = $this->input->post('status');
        $tanggal_lahir = $this->input->post('tanggal_lahir');
        $no_hp = $this->input->post('no_hp');

        $exe = $this->Santri->update($id_santri, $tingkat_id, $kelas_id, $ruang_id, $tahun_ajaran_id, $nama, $jenis_kelamin, $alamat, $status, $tanggal_lahir, $no_hp);

        $this->output_json($this->Santri->getData($exe['id']));
    }

    public function getDataDetail()
    {
        $this->output_json($this->Santri->getData($this->input->post('id')));
    }
}
