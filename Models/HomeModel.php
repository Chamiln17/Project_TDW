<?php

namespace Models;
require_once "core/Database.php";

class HomeModel
{
    private $db;
    public function __construct()
    {
        $this->db = new \Database();
    }
    public function get_data()
    {
    }

}