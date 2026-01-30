<?php 

namespace App\Controllers;

use App\Models\Commentaire;

class CommentaireController {

    private $commentaireModel;

    public function __construct() {
        $this->commentaireModel = new Commentaire();
    }

    public function listerCommentaires() {
        $commentaires = $this->commentaireModel->findAll();

        require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'ViewsRecette'.DIRECTORY_SEPARATOR.'listerCommentaires.php');
    }

    public function lister($id) {

        if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) {
            $commentaires = $this->commentaireModel->findBy(['recette_id' => $id]);
        } else {
            $commentaires = $this->commentaireModel->findBy(['recette_id' => $id, 'isApproved' => 1]);
        }

        return $commentaires;
    }

    public function ajouter() {
        $recette_id = $_GET['id'];

        if (isset($_SESSION['identifiant'])) {
            $pseudo = $_SESSION['identifiant'];   
        } else {
            $pseudo = "Anonyme";             
        }
        
        $commentaire = $_POST['commentaire'];

        if ($_SESSION['isAdmin'] ?? false) {
            $isApproved = 1;
        } else {
            $isApproved = 0;
        }

        $ajout = $this->commentaireModel->add($pseudo, $commentaire, $recette_id, $isApproved);
        header('Location: ?c=Recette&a=detail&id=' . $recette_id);
    }

    public function supprimer() {
        $id = $_GET['id'];

        $suppresion = $this->commentaireModel->findBy(['id' => $id]);

        if (count($suppresion) > 0) {
            $this->commentaireModel->delete($suppresion[0]['id']);
            $_SESSION['message'] = ['success' => 'Commentaire retiré'];
        }


    }

    public function aApprouver() {
        $commentaires = $this->commentaireModel->findBy(['isApproved' => 0]);

        require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'ViewsRecette'.DIRECTORY_SEPARATOR.'commentairesAapprouver.php');
    }

    public function approuver() {
        $id = $_GET['id'];

        $commentaire = $this->commentaireModel->find($id);

        if ($commentaire) {
            $this->commentaireModel->update($id, $commentaire['pseudo'], $commentaire['commentaire'], $commentaire['create_time'], $commentaire['recette_id'], 1);
        }

        header('Location: ?c=home');
    }

    public function nbrCommentairesAApprouver() {
        $commentaires = $this->commentaireModel->findBy(['isApproved' => 0]);

        return count($commentaires);
    }
}