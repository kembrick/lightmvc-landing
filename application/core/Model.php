<?php

namespace application\core;

use application\lib\Db;
use application\lib\Common;

abstract class Model
{

    public Db $db;

    public function __construct()
    {
        $this->db = new Db;
    }


}