<?php
defined('BASEPATH') or exit('No direct script access allowed');

class HakAksesLevel extends Render_Controller
{
    function __construct()
    {
        parent::__construct();
        $this->load->model('pengaturan/HakAksesLevelModel', 'mod_hk');
        $this->load->model('pengaturan/levelModel', 'level');
        $this->default_template = 'templates/dashboard';
        $this->load->library('plugin');
        $this->load->helper('url');

        // Cek session
        $this->sesion->cek_session();
    }

    public function index()
    {
        // Page Settings
        $this->title                     = 'Pengaturan Hak Akses Level';
        $this->content                     = 'pengaturan-hakAkses';
        $this->navigation                 = ['Pengaturan', 'Level', 'Hak Akses'];
        $this->plugins                     = ['datatables'];

        // Breadcrumb setting
        $this->breadcrumb_1             = 'Pengaturan';
        $this->breadcrumb_1_url         = '#';
        $this->breadcrumb_2             = 'Level';
        $this->breadcrumb_2_url         = base_url() . 'pengaturan/level';
        $this->breadcrumb_3             = 'Hak Akses';
        $this->breadcrumb_3_url         = '#';

        // Send data to view
        $this->data['records']             = $this->hakAkses->getAllData();
        $this->data['level']             = $this->hakAkses->getDataLevel();
        $this->data['parent']             = $this->hakAkses->getDataParent();

        $this->render();
    }


    // Sub menu
    public function subMenu()
    {
        $menu                             = $this->input->post('menu');

        $exe                             = $this->hakAkses->getDataChild($menu);

        $this->output_json($exe);
    }


    // Get data detail
    public function getDataDetail()
    {
        $id                             = $this->input->post('id');

        $exe                             = $this->hakAkses->getAllData($id);

        $this->output_json(
            [
                'id'             => $exe[0]['rola_id'],
                'level'         => $exe[0]['rola_lev_id'],
                'menu'             => $exe[0]['parent_id'],
                'sub_menu'         => $exe[0]['menu_id'],
            ]
        );
    }


    // Insert data
    public function insert()
    {
        $level                             = $this->input->post('level');
        $menu                             = $this->input->post('menu');
        $sub_menu                         = $this->input->post('sub_menu');

        $exe                             = $this->hakAkses->insert($level, $menu, $sub_menu);

        $this->output_json(
            [
                'id'             => $exe['id'],
                'level'         => $exe['level'],
                'menu'             => $exe['parent'],
                'sub_menu'         => $exe['child'],
            ]
        );
    }


    // Update data
    public function update()
    {
        $id                             = $this->input->post('id');
        $level                             = $this->input->post('level');
        $menu                             = $this->input->post('menu');
        $sub_menu                         = $this->input->post('sub_menu');

        $exe                             = $this->hakAkses->update($id, $level, $menu, $sub_menu);

        $this->output_json(
            [
                'id'             => $id,
                'level'         => $exe['level'],
                'menu'             => $exe['parent'],
                'sub_menu'         => $exe['child'],
            ]
        );
    }


    // Delete data
    public function delete()
    {
        $id                             = $this->input->post('id');

        $exe                             = $this->hakAkses->delete($id);

        $this->output_json(
            [
                'id'             => $id
            ]
        );
    }

    public function hakakses($id)
    {
        $usr = $this->level->getDataDetail($id);
        // Page Settings
        $this->title                     = 'Pengaturan Hak Akses Level ' . $usr['lev_nama'];
        $this->content                     = 'pengaturan-level-hakakses';
        $this->navigation                 = ['Pengaturan', 'Level', 'Hak Akses'];
        $this->plugins                     = ['datatables'];

        // Breadcrumb setting
        $this->breadcrumb_1             = 'Pengaturan';
        $this->breadcrumb_1_url         = '#';
        $this->breadcrumb_2             = 'Level';
        $this->breadcrumb_2_url         = base_url() . 'pengaturan/level';
        $this->breadcrumb_3             = 'Hak Akses';
        $this->breadcrumb_3_url         = '#';

        // // Send data to view
        $this->data['records'] = $this->mod_hk->getDataDisplay($id);

        $this->render();
    }
}

/* End of file HakAkses.php */
/* Location: ./application/controllers/pengaturan/HakAkses.php */