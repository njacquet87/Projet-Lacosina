<!DOCTYPE html>
<html lang="fr">

<?php 
use App\Controllers\RecetteController;
use App\Controllers\CommentaireController;

$recetteController = new RecetteController();
$nbrReccettesAApprouver = $recetteController->nbrReccetteAApprouver();

$commentaireController = new CommentaireController();
$nbrCommentairesAApprouver = $commentaireController->nbrCommentairesAApprouver();
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>La Cosina</title>
    <!-- Bootstrap CSS and JS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.13.1/font/bootstrap-icons.min.css">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="./src/Views/js/recipes.js" defer></script>
    <script src="./src/Views/js/users.js" defer></script>
    <script src="./src/Views/js/search.js" defer></script>
</head>

<body>
    <!-- menu de navigation -->
    <nav class="navbar navbar-expand-lg bg-body-tertiary justify-content-between">

        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" href='?c=home'>Accueil</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href='?c=Recette&a=lister'>Recettes</a>
            </li>

            <li class="nav-item">
                <a class="nav-link" href='?c=Contact&a=ajouter'>Contact</a>
            </li>

            <!-- menu utilisateur -->

            <?php if (isset($_SESSION['identifiant'])): ?>
                <div class="vr"></div>

                <li class="nav-item dropdown">

                    <a class="nav-link dropdown-toggle" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                            Bienvenu <?php echo $_SESSION['identifiant']; 
                            if ($_SESSION['isAdmin'] == 1 && $nbrReccettesAApprouver > 0 && $nbrCommentairesAApprouver > 0) {?>
                                <span class="position-absolute top-1 start-100 translate-middle p-2 bg-danger border border-light rounded-circle"></span>
                            <?php } ?>
                    </a>
                    <ul class="dropdown-menu">
                        <li>
                            <a class="nav-link" href="?c=User&a=profil">Mon profil</a>
                        </li>

                        <?php if ($_SESSION['isAdmin'] == 1) { ?>
                            <li>
                                <a class="nav-link" href="?c=Recette&a=ajouter">Ajouter une recette</a>
                            </li>
                        <?php } else { ?>
                            <li>
                                <a class="nav-link" href="?c=Recette&a=ajouter">Proposer une recette</a>
                            </li>
                            <li>
                                <a class="nav-link" href="?c=Recette&a=enCoursValidation">Mes recettes en cours de validation</a>
                            </li>
                        <?php } ?>

                        <li>
                            <a class="nav-link" href="?c=Favori&a=getFavoris&x&id=<?php echo $_SESSION['id'] ?>">Mes recettes favorites</a>
                        </li>

                        <?php if ($_SESSION['isAdmin'] == 1) { ?>
                            <li>
                                <a class="nav-link" href="?c=Recette&a=aApprouver">Recettes à approuver   
                                    <?php if($nbrReccettesAApprouver > 0) { ?>
                                        <span class="badge text-bg-danger"><?php echo $nbrReccettesAApprouver ?></span>    
                                    <?php } ?>
                                </a>
                            </li>

                            <li>
                                <a class="nav-link" href="?c=Commentaire&a=aApprouver">Commentaires à approuver
                                    <?php if($nbrCommentairesAApprouver > 0) { ?>
                                        <span class="badge text-bg-danger"><?php echo $nbrCommentairesAApprouver ?></span>    
                                    <?php } ?>
                                </a>
                            </li>

                            <li>
                                <a class="nav-link" href="?c=Commentaire&a=listerCommentaires">Liste des commentaires</a>
                            </li>
                        <?php } ?>
                    </ul>
                </li>
            <?php endif; ?>
        </ul>

        <!-- bar de recherche -->

        <input type="search" id="search" placeholder="Rechercher une recette" style="border-radius: 5px; width: 20%;">

        <!-- menu de connexion -->

        <ul class="navbar-nav">
            <?php if(isset($_SESSION['identifiant'])) {?>
                <li class="nav-item">
                    <a class="btn btn-outline-dark" href='?c=User&a=deconnexion'>Déconnexion</a>
                </li>
            <?php } else { ?>
                <li class="nav-item ms-1">
                    <a class="btn btn-outline-dark" href="?c=User&a=inscription">Inscription</a>
                </li>

                <li class="nav-item ms-1">
                    <a class="btn btn-outline-dark" href='?c=User&a=connexion'>Connexion</a>
                </li>
            <?php } ?>
        </ul>
    </nav>

    <?php if(isset($_SESSION['message'])) : ?>
        <?php foreach ($_SESSION['message'] as $type => $message) { ?>
            
            <div class="alert alert-<?php echo $type; ?>">
                <?php echo $message; ?>
            </div>

    <?php } endif; unset($_SESSION['message']); ?>

    <!-- corps de la page -->
    <div class="container w-75 m-auto">