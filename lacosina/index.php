<?php

ob_start();
session_start();

require 'vendor/autoload.php';

use App\Controllers\RecetteController;
use App\Controllers\ContactController;
use App\Controllers\UserController;
use App\Controllers\FavoriController;
use App\Controllers\CommentaireController;


use Monolog\Logger;
use Monolog\Handler\StreamHandler;
use Monolog\Handler\FirePHPHandler;

$logger = new Logger('lacosina');

$logger->pushHandler(new StreamHandler(__DIR__. DIRECTORY_SEPARATOR . 'log'.DIRECTORY_SEPARATOR .'app.log', Logger::DEBUG));
$logger->pushHandler(new FirePHPHandler());



if (!isset($_GET['x']))
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'ViewsGeneral' . DIRECTORY_SEPARATOR . 'header.php');



$controller = isset($_GET['c']) ? $_GET['c'] : 'home';
$action = isset($_GET['a']) ? $_GET['a'] : 'lister';

switch ($controller) {

    case 'home':
        require_once(__DIR__ . DIRECTORY_SEPARATOR . 'src'. DIRECTORY_SEPARATOR . 'Controllers'. DIRECTORY_SEPARATOR . 'homeController.php');
        break;

    case 'Contact':

        $contactController = new ContactController();

        switch ($action) {

            case 'ajouter' :
                $contactController->ajouter();
                break;

            case 'enregistrer' :
                $contactController->enregistrer();
                break;
            
            default:
                $_SESSION['message'] = ['danger' => 'Page non trouvée'];
                header('Location: ?c=home');
                break;

        }

        break;

    case 'Recette':

        $recetteController = new RecetteController();

        switch ($action) {

            case 'lister' :
                $recetteController->lister();
                break;

            case 'ajouter' :
                $logger->info("l'utilisateur ".$_SESSION['identifiant']. " à ajouté une recette");

                $recetteController->ajouter();
                break;

            case 'enregistrer' :
                $recetteController->enregistrer();
                break;

            case 'detail' :
                $recetteController->detail($_GET['id']);
                break;

            case 'modifier' :
                $logger->info("l'utilisateur ".$_SESSION['identifiant']. " à modifié une recette");

                $recetteController->modifier();
                break;
                
            case 'supprimer' : 
                $logger->info("l'utilisateur ".$_SESSION['identifiant']. " à supprimé une recette");

                $recetteController->supprimer();
                header('Location: ?c=Recette&a=lister');
                break;

            case 'listerJSON' :
                $recetteController->listerJSON();
                exit;
                break;
            
            case 'aApprouver' :
                $recetteController->aApprouver();
                break;

            case 'approuver' :
                $logger->info("l'administrateur ".$_SESSION['identifiant']. " à approuvé une recette");
                $recetteController->approuver();
                break;
                
            case 'enCoursValidation' : 
                $recetteController->nonValidesPourUtilisateur();
                break;

            default:
                $_SESSION['message'] = ['danger' => 'Page non trouvée'];
                header('Location: ?c=home');
                break;

        }

        break;
    
    case 'User' :

        $userController = new UserController();

        switch ($action) {

            case 'inscription' :
                $userController->inscription();
                break;
    
            case 'enregistrer' :
                $userController->enregistrer();
                break;

            case 'connexion' :
                $userController->connexion();
                break;

            case 'connecter' : 
                $logger->info("l'utilisateur ".$_POST['identifiant']. " s'est connecté");

                $userController->verifieConnexion();
                break;

            case 'deconnexion' :
                $logger->info("l'utilisateur ".$_SESSION['identifiant']. " s'est déconnecté");

                $userController->deconnexion();
                break;

            case 'profil' :
                $userController->profil();
                break;

            default:
                $_SESSION['message'] = ['danger' => 'Page non trouvée'];
                header('Location: ?c=home');
                break;

        }

        break;

    case 'Favori' :

        $favoriController = new FavoriController();

        switch ($action) {

            case 'ajouter' :
                $favoriController->ajouter();
                header('Location: ?c=Recette&a=lister');
                break;

            case 'supprimer' :
                $favoriController->supprimer();
                header('Location: ?c=Recette&a=lister');
                break;
                
            case 'getFavoris':
                $id = isset($_GET['id']) ? (int)$_GET['id'] : (isset($_SESSION['id']) ? $_SESSION['id'] : 0);

                $favoriController->getFavoris($id);
                
                break;
            
            default:
                $_SESSION['message'] = ['danger' => 'Page non trouvée'];
                header('Location: ?c=home');
                break;

        }

        break;

    case 'Commentaire' :

        $commentaireController = new CommentaireController();

        switch ($action) {

            case 'ajouter' :
                $commentaireController->ajouter();
                break;

            case 'supprimer' :
                $commentaireController->supprimer();
                header('Location: ?c=Commentaire&a=listerCommentaires');
                break;

            case 'listerCommentaires' :
                $commentaireController->listerCommentaires();
                break;

            case 'aApprouver' :
                $commentaireController->aApprouver();
                break;
            
            case 'approuver' :
                $logger->info("l'administrateur ".$_SESSION['identifiant']. " à approuvé un commentaire");
                $commentaireController->approuver();
                break;

            default:
                $_SESSION['message'] = ['danger' => 'Page non trouvée'];
                header('Location: ?c=home');
                break;
            
        }

        break;
            
    default:
        $_SESSION['message'] = ['danger' => 'Page non trouvée'];
        header('Location: ?c=home');
        break;
}


if (!isset($_GET['x']))
    require_once(__DIR__ . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'Views' . DIRECTORY_SEPARATOR . 'ViewsGeneral' . DIRECTORY_SEPARATOR . 'footer.php');

ob_end_flush();