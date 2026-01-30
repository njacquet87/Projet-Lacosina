<?php

namespace App\Controllers;

use App\Models\Recette;
use App\Models\Favori;

class FavoriController {
    private $FavorisModel;
    private $recetteModel;

    public function __construct() {
        $this->FavorisModel = new Favori();
        $this->recetteModel = new Recette();
    }

    public function ajouter(){
        $recette_id = $_GET['recette_id'];
        $id_utilisateur = $_SESSION['id'];

        $ajout = $this->FavorisModel->findBy(['user_id' => $id_utilisateur, 'recette_id' => $recette_id]);

        if (count($ajout) == 0){
            $this->FavorisModel->add($id_utilisateur, $recette_id);
            $_SESSION['message'] = ['success' => 'Recette ajoutée aux favoris'];
        } else {
            echo 'Le favori existe déjà.';
        }

    }

    public function supprimer() {
        $recette_id = $_GET['recette_id'];
        $id_utilisateur = $_SESSION['id'];

        $suppression = $this->FavorisModel->findBy(['user_id' => $id_utilisateur, 'recette_id' => $recette_id]);

        if (count($suppression) > 0){
            $favori_id = $suppression[0]['id'];
            $this->FavorisModel->delete($favori_id);
            $_SESSION['message'] = ['success' => 'Recette retirée des favoris'];
        } else {
            echo 'Le favori n\'existe pas.';
        }

    }

    public function getFavoris($id_utilisateur){

        $favoris = $this->FavorisModel->findBy(['user_id' => $id_utilisateur]);
        $recettesFavoris = [];

        foreach($favoris as $favori){
            $recette = $this->recetteModel->find($favori['recette_id']);
            $recettesFavoris[] = $recette; 
        }

        header('Content-Type: application/json');
        echo json_encode($recettesFavoris);
    }

    public function existe($id, $session_id) {
        $favori = $this->FavorisModel->findBy(['user_id' => $session_id, 'recette_id' => $id]);

        return count($favori) > 0;
    }
}