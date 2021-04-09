<?php
defined('BASEPATH') or exit('No direct script access allowed');

class KelasModel extends Render_Model
{
    public function getData()
    {
        return $this->db->get("santri_kelas")->result_array();
    }
}
