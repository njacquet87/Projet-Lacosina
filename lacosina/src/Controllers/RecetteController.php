<?php

namespace App\Controllers;

use App\Models\Recette;
use App\Controllers\FavoriController;

class RecetteController {

    private $recetteModel;

    public function __construct() {
        $recetteModel = new Recette();
        $this->recetteModel = $recetteModel;
    }


    public function ajouter() {
        require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'ViewsRecette'.DIRECTORY_SEPARATOR.'ajout.php');
    }

    public function enregistrer() {
        $id = isset($_GET['id']) ? $_GET['id'] : null;
        $titre = $_POST['titre'];
        $description = $_POST['description'];
        $auteur = $_POST['auteur'];
        $image = isset($_FILES['image']) ? $_FILES['image'] : null;
        $type_plat = $_POST['type_plat'];

        $imagePath = null;

        if ($image && $image['error'] === UPLOAD_ERR_OK) {
            $uploadDir = '/lacosina/uplaod/';

            if(!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $imagePath = $uploadDir.basename($image['name']);
            move_uploaded_file($image['tmp_name'], $imagePath);
            $imagePath = 'upload/'.basename($image['name']);

        }
 
        if ($_FILES['image']['error'] == 4) {
            $recipe = $this->recetteModel->find($id);
            //si l'image n'est pas renseignée on met l'image par defaut
            $imagePath = isset($recipe['image']) ? $recipe['image'] : '/lacosina/upload/no_image.png';
        } else {
            $image = $_FILES['image']['name'];
            $target_dir = "upload/";
            $target_file = $target_dir.basename($_FILES['image']['name']);
            move_uploaded_file($_FILES['image']['tmp_name'], $target_file);
        }

        $isApproved = 0;

        if ($_SESSION['isAdmin'] == 1) {
            $isApproved = 1;
        }

        if (isset($id)) {
            $ajoutOk = $this->recetteModel->update($id,$titre, $description, $auteur, $imagePath, $type_plat, $isApproved);
        } else {
            $ajoutOk = $this->recetteModel->add($titre, $description, $auteur, $imagePath, $type_plat, $isApproved);
        }

        if($ajoutOk) {
            require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'ViewsRecette'.DIRECTORY_SEPARATOR.'enregistrer.php');
        } else {
            echo 'Erreur lors de l\'enregistrement de la recette.';
        }
    }

    public function lister() {

        $filtre = isset($_GET['filtre']) ? $_GET['filtre'] : null;

        //affiche toutes les recettes si admin, sinon seulement les recettes approuvées

        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
            if ($filtre && in_array($filtre, ['entrée', 'plat', 'dessert'])) {
                $recettes = $this->recetteModel->findBy(['type_plat' => $filtre]);
            } else {
                $recettes = $this->recetteModel->findAll();
            }
        } else {
            if ($filtre && in_array($filtre, ['entrée', 'plat', 'dessert'])) {
                $recettes = $this->recetteModel->findBy(['type_plat' => $filtre, 'isApproved' => 1]);
            } else {
                $recettes = $this->recetteModel->findBy(['isApproved' => 1]);
            }
        }

        require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'ViewsRecette'.DIRECTORY_SEPARATOR.'liste.php');
    }

    public function listerParId() {
        $recette = $this->recetteModel->find($_GET['id']);

        require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'ViewsRecette'.DIRECTORY_SEPARATOR.'liste.php');
    }

    public function detail($id) {

        $favoriController = new FavoriController();
        $existe = $favoriController->existe($id, isset($_SESSION['id']) ? $_SESSION['id']:null);

        $recette = $this->recetteModel->find($id);

        $commentaireModel = new CommentaireController();
        $commentaires = $commentaireModel->lister($recette['id']);

        require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'ViewsRecette'.DIRECTORY_SEPARATOR.'detail.php');
    }

    public function modifier() {
        $recette = $this->recetteModel->find($_GET['id']);

        require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'ViewsRecette'.DIRECTORY_SEPARATOR.'modifier.php');
    }

    public function supprimer() {
        $id = $_GET['id'];

        $recettes = $this->recetteModel->find($id);

        if (count($recettes) > 0) {
            $this->recetteModel->delete($id);
        }

    }

    public function listerJSON() {
        header('Content-Type: application/json');
        
        $recettes = $this->recetteModel->findAll();
        
        echo json_encode($recettes);
        exit;
    }

    public function aApprouver() {
        $recettes = $this->recetteModel->findBy(['isApproved' => 0]);

        require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'ViewsRecette'.DIRECTORY_SEPARATOR.'aApprouver.php');
    }

    public function nbrReccetteAApprouver() {
        $recettes = $this->recetteModel->findBy(['isApproved' => 0]);

        return count($recettes);
    }

    public function approuver() {
        $id = $_GET['id'];

        $recette = $this->recetteModel->find($id);

        if ($recette) {
            $this->recetteModel->update($id, $recette['titre'], $recette['description'], $recette['auteur'], $recette['image'], $recette['type_plat'], 1);
        }

        header('Location: ?c=home');
    }

    public function nonValidesPourUtilisateur() {
        $recettes = $this->recetteModel->findBy(['auteur' => $_SESSION['mail'], 'isApproved' => 0]);

        require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'ViewsRecette'.DIRECTORY_SEPARATOR.'enCoursValidation.php');
    }

    public function recettesParId($id) {
        $recettes = $this->recetteModel->find($id);

        return $recettes;
    }
}
?>