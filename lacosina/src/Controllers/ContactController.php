<?php

namespace App\Controllers;

use App\Models\Contact;

class ContactController {

    private $contactModel;

    public function __construct() {
        $contactModel = new Contact();
        $this->contactModel = $contactModel;
    }

    public function ajouter() {
        require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'ViewsContact'.DIRECTORY_SEPARATOR.'contact.php');
    }

    public function enregistrer() {
        $nom = $_POST['nom'];
        $mail = $_POST['mail'];
        $description = $_POST['description'];

        $ajoutOk = $this->contactModel->add($nom, $mail, $description);

        if($ajoutOk) {
            require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'ViewsGeneral'.DIRECTORY_SEPARATOR.'enregistrer.php');
        } else {
            echo 'Erreur lors de l\'enregistrement de la recette.';
        }
    }
}
?>