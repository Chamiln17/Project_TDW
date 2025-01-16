<?php
namespace Models;
use Database;
require_once "core/Database.php";

class PartnerModel {
    private Database $db;

    public function __construct() {
        $this->db = new Database();
    }

    public function getPartnerDetails($partnerId) {
        $this->db->connect();
        $query = "SELECT p.*, c.category_name as categoryName,
                  CASE WHEN fp.favorite_id IS NOT NULL THEN 1 ELSE 0 END as isFavorite
                  FROM partners p
                  JOIN categories c ON p.category_id = c.category_id
                  LEFT JOIN favorite_partners fp ON p.partner_id = fp.partner_id 
                    AND fp.member_id = (SELECT member_id FROM members WHERE user_id = :user_id)
                  WHERE p.partner_id = :partner_id";

        $params = [
            ':partner_id' => $partnerId,
            ':user_id' => $_SESSION['user_id'] ?? null
        ];

        $result = $this->db->query($query, $params);
        $this->db->disconnect();
        return $result[0] ?? null;
    }

    public function getPartnerAdvantages($partnerId) {
        $this->db->connect();
        $query = "SELECT a.*, mt.type_name as membershipType
                 FROM advantages a
                 JOIN membership_types mt ON a.membership_type_id = mt.type_id
                 WHERE a.partner_id = :partner_id
                 AND CURRENT_DATE BETWEEN a.start_date AND a.end_date
                 ORDER BY a.start_date DESC";

        $params = [':partner_id' => $partnerId];
        $result = $this->db->query($query, $params);
        $this->db->disconnect();
        return $result;
    }

    public function getPartnerDiscounts($partnerId) {
        $this->db->connect();
        $query = "SELECT d.*, mt.type_name as membershipType
                 FROM discounts d
                 JOIN membership_types mt ON d.membership_type_id = mt.type_id
                 WHERE d.partner_id = :partner_id
                 AND CURRENT_DATE BETWEEN d.start_date AND d.end_date
                 ORDER BY d.discount_percentage DESC";

        $params = [':partner_id' => $partnerId];
        $result = $this->db->query($query, $params);
        $this->db->disconnect();
        return $result;
    }

    public function getFavoriteStatus($user_id, $partner_id): bool
    {
        try {
            $this->db->connect();

            // First get the member_id
            $member = $this->getMember($user_id);
            if (empty($member)) {
                return false;
            }

            $member_id = $member[0]['member_id'];

            // Check favorite status
            $this->db->connect();
            $status = $this->db->query(
                "SELECT COUNT(*) as is_favorite 
             FROM favorite_partners 
             WHERE member_id = :member_id 
             AND partner_id = :partner_id",
                [
                    ':member_id' => $member_id,
                    ':partner_id' => $partner_id
                ]
            );

            return !empty($status) && $status[0]['is_favorite'] > 0;
        } catch (\Exception $e) {
            // Log error if needed
            return false;
        } finally {
            $this->db->disconnect();
        }
    }
    public function addFavorite($member_id, $partner_id): array
    {
        $this->db->connect();

        // First check if favorite already exists
        if ($this->getFavoriteStatus($member_id, $partner_id)) {
            $this->db->disconnect();
            return [
                'success' => false,
                'message' => 'Ce partenaire est déjà dans vos favoris'
            ];
        }

        $query = "INSERT INTO favorite_partners (member_id, partner_id) 
              VALUES (:member_id, :partner_id)";

        $params = [
            ':member_id' => $member_id,
            ':partner_id' => $partner_id
        ];

        try {
            $this->db->connect();
            $result = $this->db->execute($query, $params);
            $this->db->disconnect();

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Partenaire ajouté aux favoris avec succès'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => "Erreur lors de l'ajout aux favoris"
                ];
            }
        } catch (\Exception $e) {
            $this->db->disconnect();
            return [
                'success' => false,
                'message' => "Une erreur est survenue lors de l'ajout aux favoris"
            ];
        }
    }

    public function removeFavorite($member_id, $partner_id): array
    {
        $this->db->connect();

        // First check if favorite exists
        if (!$this->getFavoriteStatus($member_id, $partner_id)) {
            $this->db->disconnect();
            return [
                'success' => false,
                'message' => "Ce partenaire n'est pas dans HAHA vos favoris"
            ];
        }

        $query = "DELETE FROM favorite_partners 
              WHERE member_id = :member_id 
              AND partner_id = :partner_id";

        $params = [
            ':member_id' => $member_id,
            ':partner_id' => $partner_id
        ];

        try {
            $this->db->connect();
            $result = $this->db->execute($query, $params);
            $this->db->disconnect();

            if ($result) {
                return [
                    'success' => true,
                    'message' => 'Partenaire retiré des favoris avec succès'
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Erreur lors du retrait des favoris'
                ];
            }
        } catch (\Exception $e) {
            $this->db->disconnect();
            return [
                'success' => false,
                'message' => 'Une erreur est survenue lors du retrait des favoris'
            ];
        }
    }

    public function getMember($userID) {
        $this->db->connect();
        $query = "SELECT member_id From members m 
                JOIN users u ON m.user_id = u.user_id
              WHERE m.user_id = :user_id";
        $params = ["user_id" => $userID];
        $result = $this->db->query($query, $params);
        $this->db->disconnect();
        return $result;
    }
    public function getAllPartners($filters = []) {
        $this->db->connect();

        $query = "
            SELECT 
                P.partner_id,
                P.name,
                P.city,
                C.category_id,
                C.category_name,
                P.offer,
                P.logo
            FROM partners P
            JOIN categories C ON P.category_id = C.category_id
            WHERE 1=1
        ";

        // Apply filters
        if (!empty($filters['city'])) {
            $query .= " AND P.city = '" . $filters['city'] . "'";
        }
        if (!empty($filters['category'])) {
            $query .= " AND C.category_id = " . $filters['category'];
        }

        // Apply sorting
        if (!empty($filters['sort'])) {
            $query .= " ORDER BY " . $filters['sort'] . " " . ($filters['order'] ?? 'ASC');
        }

        $this->partners = $this->db->query($query);
        $this->db->disconnect();
        return $this->partners;
    }

    public function addPartner($data) {
        $this->db->connect();
        $query = "
            INSERT INTO partners (name, category_id, city, offer, logo) 
            VALUES (?, ?, ?, ?, ?)
        ";
        $result = $this->db->execute($query, [
            $data['name'],
            $data['category_id'],
            $data['city'],
            $data['offer'],
            $data['logo']
        ]);
        $this->db->disconnect();
        return $result;
    }

    public function updatePartner($id, $data) {
        $this->db->connect();
        $query = "
            UPDATE partners 
            SET name = ?, category_id = ?, city = ?, offer = ?, logo = ?
            WHERE partner_id = ?
        ";
        $result = $this->db->execute($query, [
            $data['name'],
            $data['category_id'],
            $data['city'],
            $data['offer'],
            $data['logo'],
            $id
        ]);
        $this->db->disconnect();
        return $result;
    }

    public function deletePartner($id) {
        $this->db->connect();
        $query = "DELETE FROM partners WHERE partner_id = ?";
        $result = $this->db->execute($query, [$id]);
        $this->db->disconnect();
        return $result;
    }

    public function getPartnerStats() {
        $this->db->connect();
        $query = "
            SELECT 
                C.category_name,
                COUNT(P.partner_id) as partner_count,
                AVG(P.offer) as avg_discount
            FROM partners P
            JOIN categories C ON P.category_id = C.category_id
            GROUP BY C.category_name
        ";
        $stats = $this->db->query($query);
        $this->db->disconnect();
        return $stats;
    }

}