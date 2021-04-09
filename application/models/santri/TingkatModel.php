<?php
defined('BASEPATH') or exit('No direct script access allowed');

class TingkatModel extends Render_Model
{
    public function getData()
    {
        return $this->db->get("santri_tingkat")->result_array();
    }
}
