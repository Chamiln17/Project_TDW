<?php

namespace Models;
require_once "core/Database.php";

class HomeModel
{
    private $db;
    private $news;
    private $partners;
    private $totalPartners;
    public function __construct()
    {
        $this->db = new \Database();
    }

    public  function get_news()
    {
        $this->db->connect();
        $this->news = $this->db->query("SELECT * FROM news");
        $this->db->disconnect();
        return $this->news;
    }
    public function get_partners()
    {
        $this->db->connect();

        $this->partners = $this->db->query("
    SELECT 
        P.name AS partnerName,
        C.category_name AS partnerCategory,
        P.logo AS partnerLogo,
        P.city AS city,
        P.offer AS offer
    FROM 
        partners AS P
    JOIN 
        categories AS C ON P.category_id = C.category_id
");

        return $this->partners;
    }
    public function getTotalPartners()
    {   $this->db->connect();
        $this->totalPartners=$this->db->query("SELECT COUNT(*) AS total FROM partners");
        $this->db->disconnect();
        return $this->totalPartners[0]['total'];
    }

}