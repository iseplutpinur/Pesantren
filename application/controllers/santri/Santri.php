<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Santri extends Render_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('santri/SantriModel', 'Santri');
        $this->load->model('santri/KelasModel', 'Kelas');
        $this->load->model('santri/TahunAjaranModel', 'TahunAjaran');
        $this->load->model('santri/TingkatModel', 'Tingkat');
        $this->load->model('santri/RuangModel', 'Ruang');
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');

        // Cek session
        $this->sesion->cek_session();
    }

    public function index()
    {

        // Page Settings
        $this->title                     = 'Santri';
        $this->content                     = 'santri-santri';
        $this->navigation                 = ['santri', 'Santri'];
        $this->plugins                     = ['datatables'];

        // // Breadcrumb setting
        $this->breadcrumb_1             = 'Dashboard';
        $this->breadcrumb_1_url         = base_url() . 'santri';
        $this->breadcrumb_2             = 'Santri';
        $this->breadcrumb_2_url         = '#';
        $this->breadcrumb_3             = 'Santri';
        $this->breadcrumb_3_url = '#';

        // // Send data to view
        $this->data['records'] = $this->Santri->getData();
        $this->data['Kelas'] = $this->Kelas->getData();
        $this->data['TahunAjaran'] = $this->TahunAjaran->getData();
        $this->data['Tingkat'] = $this->Tingkat->getData();
        $this->data['Ruang'] = $this->Ruang->getData();
        $this->render();
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
}
