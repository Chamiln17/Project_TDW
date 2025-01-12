<?php

namespace Models;
use Database;
use PDOException;

require_once "core/Database.php";


class MemberModel
{
    private Database $db;

    public function __construct()
    {
        $this->db = new Database();
    }
    public function getMember($userID){
        $this->db->connect();
        $query="SELECT first_name , last_name ,member_id FROM members where user_id = :user_id";

        $params=["user_id"=>$userID];
        $result =$this->db->query($query,$params);
        $this->db->disconnect();
        return $result;
    }
}