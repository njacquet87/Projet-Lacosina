<?php

namespace App\Models;

use PDO;

class User {

    private $conn;

    public function __construct() {
        $database = new Database();
        $this->conn = $database->getConnection();
    }

    public function findAll() {
        $query = "SELECT * FROM users";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $query = "SELECT * FROM users WHERE id = '$id'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findBy(array $params) {
        $query = "SELECT * FROM users WHERE " . implode(' AND ', array_map(function($key) {
            return "$key = :$key";
        }, array_keys($params)));

        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($identifiant, $password, $mail, $isAdmin = 0 ) {
        $query = "INSERT INTO users (identifiant, password, mail, create_time, isAdmin)
                  VALUES (:identifiant, :password, :mail, NOW(), :isAdmin)";
        
        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':identifiant', $identifiant);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':isAdmin', $isAdmin);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function update($id, $identifiant, $password, $mail, $isAdmin) {
        $query = "UPDATE users 
                  SET identifiant = :identifiant, password = :password, mail = :mail, isAdmin = :isAdmin 
                  WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':identifiant', $identifiant);
        $stmt->bindParam(':password', $password);
        $stmt->bindParam(':mail', $mail);
        $stmt->bindParam(':isAdmin', $isAdmin);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM users WHERE id = :id";
        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        return $stmt->rowCount() > 0;
    }
}