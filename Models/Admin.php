<?php

namespace LH\Models;

use LH\Database\Database;
use PDO;

class Admin
{
    private $con;
    public function __construct()
    {
        $db = new Database();
        $this->con = $db->getConnection();
    }

    public function verify($username, $password)
    {
        $query = "SELECT password, id FROM admin WHERE username = :username";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(':username', $username);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['password'])) {
            $_SESSION['admin_id']=$row['id'];
            $_SESSION['loginerror'] = null;
            return true;
        } else {
            $_SESSION['loginerror'] = "Username and Password doesn't match.";
            return false;
        }
    }
    public function getAdminName(){
        $query = "SELECT name FROM admin WHERE id = :id";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(':id', $_SESSION['admin_id'], PDO::PARAM_INT);
        $stmt->execute();
        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row['name'];
    }
}
