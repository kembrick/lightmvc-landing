<?php

namespace application\models;

use application\core\Model;

class Landing extends Model
{

    public function getInfoblocks(): array
    {
        return $this->db->fetchUnique('SELECT name, front_infoblocks.* FROM front_infoblocks');
    }

    public function getButtons(): array
    {
        return $this->db->row('SELECT * FROM front_buttons ORDER BY ord');
    }

    public function getBanners(): array
    {
        return $this->db->row('SELECT * FROM front_slider ORDER BY ord');
    }

    public function getSettings(): array
    {
        return $this->db->pairColumn('SELECT name, val FROM front_settings');
    }

}