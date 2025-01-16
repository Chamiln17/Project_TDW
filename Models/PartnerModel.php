<?php
namespace Models;
use Database;
use Exception;

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
        $this->db->beginTransaction();

        try {
            // Check if the email or username already exists
            $checkQuery = "
            SELECT user_id FROM users 
            WHERE email = ? OR username = ?
        ";
            $checkResult = $this->db->query($checkQuery, [
                $data['email'],
                $data['username']
            ]);

            if ($checkResult) {
                throw new Exception("Email or username already exists.");
            }

            // Insert the user
            $userQuery = "
            INSERT INTO users (username, password, role, email) 
            VALUES (?, ?, 'partner', ?)
        ";
            $userResult = $this->db->execute($userQuery, [
                $data['username'],
                password_hash($data['password'], PASSWORD_DEFAULT), // Hash the password
                $data['email']
            ]);

            if (!$userResult) {
                throw new Exception("Failed to create user.");
            }

            // Get the last inserted user ID
            $userId = $this->db->LastInsertId();

            // Insert the partner
            $partnerQuery = "
            INSERT INTO partners (user_id, name, category_id, city, offer, logo) 
            VALUES (?, ?, ?, ?, ?, ?)
        ";
            $partnerResult = $this->db->execute($partnerQuery, [
                $userId,
                $data['name'],
                $data['category_id'],
                $data['city'],
                $data['offer'],
                $data['logo']
            ]);

            if (!$partnerResult) {
                throw new Exception("Failed to create partner.");
            }

            $this->db->commit();
            return true;
        } catch (Exception $e) {
            $this->db->rollBack();
            throw $e; // Re-throw the exception to handle it in the controller
        } finally {
            $this->db->disconnect();
        }
    }

    public function updatePartner($id, $data) {
        $this->db->connect();
        $this->db->beginTransaction();

        try {
            // Debug: Log the partner_id
            error_log("Partner ID: " . $id);

            // Validate the partner_id
            if (empty($id)) {
                throw new Exception("Invalid partner_id.");
            }

            // Step 1: Delete dependent rows in the favorite_partners table
            $deleteFavoritePartnersQuery = "DELETE FROM favorite_partners WHERE partner_id = ?";
            $deleteFavoritePartnersResult = $this->db->execute($deleteFavoritePartnersQuery, [$id]);

            // Debug: Log the favorite_partners delete result
            error_log("Favorite Partners Delete Result: " . ($deleteFavoritePartnersResult ? "Success" : "Failure"));

            if (!$deleteFavoritePartnersResult) {
                throw new Exception("Failed to delete dependent rows in the favorite_partners table.");
            }

            // Step 2: Update the partner
            $partnerQuery = "
            UPDATE partners 
            SET name = ?, category_id = ?, city = ?, offer = ?, logo = ?
            WHERE partner_id = ?
        ";
            $partnerParams = [
                $data['name'],
                $data['category_id'],
                $data['city'],
                $data['offer'],
                $data['logo'],
                $id
            ];

            // Debug: Log the partner query and parameters
            error_log("Partner Query: " . $partnerQuery);
            error_log("Partner Params: " . print_r($partnerParams, true));

            $partnerResult = $this->db->execute($partnerQuery, $partnerParams);

            // Debug: Log the partner update result
            error_log("Partner Update Result: " . ($partnerResult ? "Success" : "Failure"));

            if (!$partnerResult) {
                throw new Exception("Failed to update partner.");
            }

            // Step 3: Update the associated user
            $userQuery = "
            UPDATE users 
            SET username = ?, email = ?, password = ?
            WHERE user_id = (SELECT user_id FROM partners WHERE partner_id = ?)
        ";
            $userParams = [
                $data['username'],
                $data['email'],
                password_hash($data['password'], PASSWORD_DEFAULT), // Hash the password
                $id
            ];

            // Debug: Log the user query and parameters
            error_log("User Query: " . $userQuery);
            error_log("User Params: " . print_r($userParams, true));

            $userResult = $this->db->execute($userQuery, $userParams);

            // Debug: Log the user update result
            error_log("User Update Result: " . ($userResult ? "Success" : "Failure"));

            if (!$userResult) {
                throw new Exception("Failed to update user.");
            }

            // Commit the transaction
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Rollback the transaction on error
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        } finally {
            // Disconnect from the database
            $this->db->disconnect();
        }
    }
    public function deletePartner($id) {
        $this->db->connect();
        $this->db->beginTransaction();

        try {
            // Debug: Log the partner_id
            error_log("Partner ID: " . $id);

            // Validate the partner_id
            if (empty($id)) {
                throw new Exception("Invalid partner_id.");
            }

            // Step 1: Delete dependent rows in the advantages table
            $deleteAdvantagesQuery = "DELETE FROM advantages WHERE partner_id = ?";
            $deleteAdvantagesResult = $this->db->execute($deleteAdvantagesQuery, [$id]);

            // Debug: Log the advantages delete result
            error_log("Advantages Delete Result: " . ($deleteAdvantagesResult ? "Success" : "Failure"));

            if (!$deleteAdvantagesResult) {
                throw new Exception("Failed to delete dependent rows in the advantages table.");
            }

            // Step 1.5: Delete dependent rows in the discounts table
            $deleteDiscountsQuery = "DELETE FROM discounts WHERE partner_id = ?";
            $deleteDiscountsResult = $this->db->execute($deleteDiscountsQuery, [$id]);

            // Debug: Log the discounts delete result
            error_log("Discounts Delete Result: " . ($deleteDiscountsResult ? "Success" : "Failure"));

            if (!$deleteDiscountsResult) {
                throw new Exception("Failed to delete dependent rows in the discounts table.");
            }

            // Step 1.75: Delete dependent rows in the favorite_partners table
            $deleteFavoritePartnersQuery = "DELETE FROM favorite_partners WHERE partner_id = ?";
            $deleteFavoritePartnersResult = $this->db->execute($deleteFavoritePartnersQuery, [$id]);

            // Debug: Log the favorite_partners delete result
            error_log("Favorite Partners Delete Result: " . ($deleteFavoritePartnersResult ? "Success" : "Failure"));

            if (!$deleteFavoritePartnersResult) {
                throw new Exception("Failed to delete dependent rows in the favorite_partners table.");
            }

            // Step 2: Fetch the user_id associated with the partner
            $userQuery = "SELECT user_id FROM partners WHERE partner_id = ?";
            $userResult = $this->db->query($userQuery, [$id]);

            // Debug: Log the user result
            error_log("User Result: " . print_r($userResult, true));

            // Check if the result is empty or invalid
            if (empty($userResult)) {
                throw new Exception("Failed to find associated user. No user found for partner_id: $id");
            }

            // Extract user_id from the first row of the result
            $userId = $userResult[0]['user_id'];

            // Debug: Log the user_id
            error_log("User ID: " . $userId);

            // Step 3: Delete the partner
            $partnerQuery = "DELETE FROM partners WHERE partner_id = ?";
            $partnerResult = $this->db->execute($partnerQuery, [$id]);

            // Debug: Log the partner delete result
            error_log("Partner Delete Result: " . ($partnerResult ? "Success" : "Failure"));

            if (!$partnerResult) {
                throw new Exception("Failed to delete partner.");
            }

            // Step 4: Delete the associated user
            $deleteUserQuery = "DELETE FROM users WHERE user_id = ?";
            $deleteUserResult = $this->db->execute($deleteUserQuery, [$userId]);

            // Debug: Log the user delete result
            error_log("User Delete Result: " . ($deleteUserResult ? "Success" : "Failure"));

            if (!$deleteUserResult) {
                throw new Exception("Failed to delete user.");
            }

            // Commit the transaction
            $this->db->commit();
            return true;
        } catch (Exception $e) {
            // Rollback the transaction on error
            $this->db->rollBack();
            error_log($e->getMessage());
            return false;
        } finally {
            // Disconnect from the database
            $this->db->disconnect();
        }
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

    public function getPartnerById($id) {
        $this->db->connect();
        $query = "SELECT * 
                 FROM partners p 
                 JOIN categories c ON p.category_id = c.category_id 
                 JOIN users u ON p.user_id = u.user_id  
                 WHERE p.partner_id = :id";
        $result=$this->db->query($query, ['id' => $id]);
        $this->db->disconnect();
        return $result;
    }

    public function getCities()
    {
        $this->db->connect();
        $query = "SELECT * FROM cities";
        $cities = $this->db->query($query);
        $this->db->disconnect();
        return $cities;
    }


}