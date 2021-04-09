<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RuangModel extends Render_Model
{
    public function getData()
    {
        return $this->db->get("santri_ruang")->result_array();
    }
}
