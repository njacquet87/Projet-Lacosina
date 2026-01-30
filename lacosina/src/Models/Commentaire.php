<?php

namespace App\Models;

use PDO;

class Commentaire {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function findAll() {
        $query = "SELECT * FROM comments";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $query = "SELECT * FROM comments WHERE id = '$id'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findBy(array $params) {
        $query = "SELECT * FROM comments WHERE " . implode(' AND ', array_map(function($key) {
            return "$key = :$key";
        }, array_keys($params)));

        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($pseudo, $commentaire, $recette_id, $isApproved) {
        $query = "INSERT INTO comments (pseudo, commentaire, create_time, recette_id, isApproved) 
        VALUES (:pseudo, :commentaire, NOW(), :recette_id, :isApproved)";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':commentaire', $commentaire);
        $stmt->bindParam(':recette_id', $recette_id);
        $stmt->bindParam(':isApproved', $isApproved);

        return $stmt->execute();
    }

    public function update($id, $pseudo, $commentaire, $create_time, $recette_id, $isApproved) {
        $query = "UPDATE comments 
                  SET pseudo = :pseudo, commentaire = :commentaire, create_time = :create_time, recette_id = :recette_id, isApproved = :isApproved
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':pseudo', $pseudo);
        $stmt->bindParam(':commentaire', $commentaire);
        $stmt->bindParam(':create_time', $create_time);
        $stmt->bindParam(':recette_id', $recette_id);
        $stmt->bindParam(':isApproved', $isApproved);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM comments WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}