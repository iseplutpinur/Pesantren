<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Santri extends Render_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('santri/SantriModel', 'santri');
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
        $this->breadcrumb_3_url         = '#';

        // // Send data to view
        $this->data['records'] = $this->santri->getData();
        $this->render();
    }
}
