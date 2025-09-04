<?php

namespace LH\Models;

use LH\Database\Database;
use PDO;
use PDOException;

class Blog
{
    private $con;

    public function __construct()
    {
        $db = new Database();
        $this->con = $db->getConnection();
    }

    public function getAllPosts($limit = 10, $offset = 0)
    {
        $query = "Select * from blogs order by created_at desc limit :limit offset :offset";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->bindValue(':offset', $offset, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function totalPost()
    {
        $query = "select count(id) as total from blogs";
        $stmt = $this->con->prepare($query);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row['total'] : 0;
    }

    public function getPostById($id)
    {
        $query = "select * from blogs where id=:id";
        $stmt = $this->con->prepare($query);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);
        return $row ? $row : null;
    }

    public function detePost($id)
    {
        try {
            $query = "SELECT image FROM blogs WHERE id = :id";
            $stmt = $this->con->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            $row = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($row && !empty($row['image'])) {
                $imagePath = __DIR__ . '/../uploads/' . $row['image'];

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }
            $query = "delete from blogs where id=:id";
            $stmt = $this->con->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            return true;
        } catch (PDOException $e) {

            error_log("DB error: " . $e->getMessage());
            return false;
        }
    }

    public function storePost($title, $description, $image)
    {
        $admin = new Admin();
        $author = $admin->getAdminName();
        try {
            $query = "insert into blogs (title, author, description, image, created_at) values(:title, :author, :description, :image, :created_at)";
            $stmt = $this->con->prepare($query);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':author', $author);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':image', $image);
            $stmt->bindValue(':created_at', date('Y-m-d H:i:s'));
            $stmt->execute();

            return true;
        } catch (PDOException $e) {

            error_log("DB error: " . $e->getMessage());
            return false;
        }
    }
    public function deleteImage($id)
    {
        try {
            $query = "SELECT image FROM blogs WHERE id = :id";
            $stmt = $this->con->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row && !empty($row['image'])) {
                $imagePath = __DIR__ . '/../uploads/' . $row['image'];

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }

            $query = "update blogs set image=null where id=:id";
            $stmt = $this->con->prepare($query);
            $stmt->bindValue(':id', $id, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("DB error: " . $e->getMessage());
            return false;
        }
    }
    public function updatePostWithImage($postid, $title, $description, $fileName)
    {
        try {
            $query = "SELECT image FROM blogs WHERE id = :id";
            $stmt = $this->con->prepare($query);
            $stmt->bindValue(':id', $postid, PDO::PARAM_INT);
            $stmt->execute();

            $row = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($row && !empty($row['image'])) {
                $imagePath = __DIR__ . '/../uploads/' . $row['image'];

                if (file_exists($imagePath)) {
                    unlink($imagePath);
                }
            }


            $query = "update blogs set title=:title, description=:description, image=:image where id=:id";
            $stmt = $this->con->prepare($query);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':image', $fileName);
            $stmt->bindValue(':id', $postid, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("DB error: " . $e->getMessage());
            return false;
        }
    }
    public function updatePostWithoutImage($postid, $title, $description)
    {
        try {
            $query = "SELECT image FROM blogs WHERE id = :id";
            $stmt = $this->con->prepare($query);
            $stmt->bindValue(':id', $postid, PDO::PARAM_INT);
            $stmt->execute();


            $query = "update blogs set title=:title, description=:description where id=:id";
            $stmt = $this->con->prepare($query);
            $stmt->bindValue(':title', $title);
            $stmt->bindValue(':description', $description);
            $stmt->bindValue(':id', $postid, PDO::PARAM_INT);
            $stmt->execute();
            return true;
        } catch (PDOException $e) {
            error_log("DB error: " . $e->getMessage());
            return false;
        }
    }
}
