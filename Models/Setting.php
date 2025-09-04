<?php

namespace LH\Models;

use LH\Database\Database;
use PDO;
use PDOException;

class Setting
{
    private $con;

    public function __construct()
    {
        $db = new Database();
        $this->con = $db->getConnection();
    }

    public function getMaxPost()
    {
        $query = "select setting_value from setting where setting_key= :setting_key";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(':setting_key', 'post_limit');
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['setting_value'] : null;
    }

    public function updateMaxPostSetting($maxPostNo)
    {
        try {
            $query = "UPDATE setting SET setting_value = :setting_value WHERE setting_key = 'post_limit'";
            $stmt = $this->con->prepare($query);
            $stmt->bindValue(':setting_value', $maxPostNo, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {
            
            error_log("DB error: " . $e->getMessage());
            return false;
        }
    }
}
