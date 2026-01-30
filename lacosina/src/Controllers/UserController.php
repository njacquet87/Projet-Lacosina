<?php

namespace App\Controllers;

use App\Models\User;

class userController {

    private $userModel;

    public function __construct() {
        $userModel = new User();
        $this->userModel = $userModel;
    }

    public function inscription() {
        require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'ViewsUser'.DIRECTORY_SEPARATOR.'inscription.php');
    }

    public function enregistrer() {
        $identifiant = $_POST['identifiant'];
        $password = $_POST['password'];
        $password = password_hash($password, PASSWORD_DEFAULT);
        $mail = $_POST['mail'];

        $ajoutOk = $this->userModel->add($identifiant, $password, $mail);

        if($ajoutOk) {
            require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'ViewsUser'.DIRECTORY_SEPARATOR.'enregistrer.php');
        } else {
            echo 'Erreur lors de l\'enregistrement de l\'utilisateur.';
        }

    }

    public function connexion() {
        require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views'.DIRECTORY_SEPARATOR.'ViewsUser'.DIRECTORY_SEPARATOR.'connexion.php');
    }

    public function verifieConnexion() {
        
        $identifiant = $_POST['identifiant'];
        $password = $_POST['password'];
        
        $user = $this->userModel->findBy(['identifiant' => $identifiant])[0];

        if ($user && password_verify($password, $user['password'])) {
            $_SESSION['id'] = $user['id'];
            $_SESSION['identifiant'] = $user['identifiant'];
            $_SESSION['mail'] = $user['mail'];
            $_SESSION['isAdmin'] = $user['isAdmin'];

            header("location: ?c=home");
        } else {
            echo 'Identifiant ou mot de passe incorrect.';
        }

    }

    public function deconnexion() {
        session_destroy();
        header("location: ?c=home");
    }

    public function profil() {
        $identifiant = $_SESSION['identifiant'];
        
        $user = $this->userModel->findBy(['identifiant' => $identifiant])[0];
        require_once(__DIR__.DIRECTORY_SEPARATOR.'..'.DIRECTORY_SEPARATOR.'Views' . DIRECTORY_SEPARATOR . 'ViewsUser' . DIRECTORY_SEPARATOR . 'profil.php');
    }
}