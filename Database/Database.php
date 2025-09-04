<?php

namespace LH\Database;

use PDO;
use PDOException;
class Database{
    private $con;
    private $host='localhost';
    private $db_name='lemon_hive';
    private $username='root';
    private $password='mysql';
    public function __construct(){
        try{
            $pdo="mysql:host={$this->host};dbname={$this->db_name}";
            $this->con=new PDO($pdo, $this->username, $this->password);
            $this->con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }catch(PDOException $ex){
            die('Connecttion Error'.$ex->getMessage());
        }
    }
    public function getConnection(){
        return $this->con;
    }


}