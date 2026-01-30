<?php
namespace App\Models;

use PDO;

Class Recette {
    private $conn;

    function __construct() {
        $databse = new Database();
        $this->conn = $databse->getConnection();
    }

    public function findAll() {
        $query = "SELECT * FROM recettes";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $query = "SELECT * FROM recettes WHERE id = '$id'";
        $stmt = $this->conn->prepare($query);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function findBy(array $params) {
        $query = "SELECT * FROM recettes WHERE ". implode(' AND ',array_map(function($key) {
            return "$key = :$key";
        }, array_keys($params)));

        $stmt = $this->conn->prepare($query);

        foreach ($params as $key => $value) {
            $stmt->bindValue(":$key", $value);
        }

        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function add($titre, $description, $auteur, $image, $type_plat, $isApproved) {
        $query = "INSERT INTO recettes (titre, description, auteur, date_creation, image, type_plat, isApproved)
        VALUES (:titre, :description, :auteur , NOW(), :image, :type_plat, :isApproved)";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':auteur', $auteur);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':type_plat', $type_plat);
        $stmt->bindParam(':isApproved', $isApproved);

        $stmt->execute();

        return $this->conn->lastInsertId();
    }

    public function update($id, $titre, $description, $auteur, $image, $type_plat, $isApproved) {
        $query = "UPDATE recettes SET titre = :titre, description = :description, auteur =
        :auteur, image = :image, type_plat = :type_plat, isApproved = :isApproved WHERE id = :id";

        $stmt = $this->conn->prepare($query);

        $stmt->bindParam(':id', $id);
        $stmt->bindParam(':titre', $titre);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':auteur', $auteur);
        $stmt->bindParam(':image', $image);
        $stmt->bindParam(':type_plat', $type_plat);
        $stmt->bindParam(':isApproved', $isApproved);

        return $stmt->execute();
    }

    public function delete($id) {
        $query = "DELETE FROM recettes WHERE id = :id";

        $stmt = $this->conn->prepare($query);
        $stmt->bindParam(':id', $id);
        $stmt->execute();
        
        return $stmt->rowCount() > 0;
    }
}