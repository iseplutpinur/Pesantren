<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TahunAjaranModel extends Render_Model
{
    public function getData()
    {
        return $this->db->get("santri_tahun_ajaran")->result_array();
    }
}
