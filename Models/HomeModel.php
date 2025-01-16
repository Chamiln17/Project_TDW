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
        P.partner_id AS partnerId,
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
    public function get_favorite_partners($memberId)
    {
        $this->db->connect();
        $query = "
        SELECT 
            P.partner_id AS partnerId,
            P.name AS partnerName,
            C.category_name AS partnerCategory,
            P.logo AS partnerLogo,
            P.city AS city,
            P.offer AS offer
        FROM 
            partners AS P
        JOIN 
            categories AS C ON P.category_id = C.category_id
        JOIN 
            favorite_partners AS FP ON P.partner_id = FP.partner_id
        WHERE 
            FP.member_id = :member_id
    ";
        $params = [':member_id' => $memberId];
        $result = $this->db->query($query, $params);
        $this->db->disconnect();
        return $result;
    }

    public function getMemberID($user_id)
    {
        $this->db->connect();
        $query = "SELECT member_id FROM members WHERE user_id = :user_id";
        $memberId = $this->db->query($query, [':user_id' => $user_id]);
        $this->db->disconnect();
        return $memberId[0]['member_id'] ?? null;
    }

}