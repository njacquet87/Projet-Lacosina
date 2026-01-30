<?php 
use App\Controllers\FavoriController;
?>

<body>

    <h1>Recettes</h1>

    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex gap-3 justify-content-center">
                <div class="card filter-card bg-primary-subtle" data-id="toutes" id="filter" style="cursor: pointer;">
                    <div class="card-body text-center">
                        <p>Toutes les recettes</p>
                    </div>
                </div>

                <div class="card filter-card" data-id="entrée" id="filter" style="cursor: pointer;">
                    <div class="card-body text-center" >
                        <p>Entrées</p>
                    </div>
                </div>

                <div class="card filter-card" data-id="plat" id="filter" style="cursor: pointer;">
                    <div class="card-body text-center">
                        <p>Plats</p>
                    </div>
                </div>

                <div class="card filter-card" data-id="dessert" id="filter" style="cursor: pointer;">
                    <div class="card-body text-center">
                        <p>Desserts</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="listeRecettes">

        <?php foreach ($recettes as $recette) : ?> 

            <div class="col-4 p-2">
                <a href="?c=Recette&a=modifier&id=<?php echo $recette['id'] ?>">
                    <i class="bi bi-pencil-square"></i>
                </a>

                <?php 
                $favoriController = new FavoriController();
                $existe = $favoriController->existe(
                    $recette['id'], 
                    isset($_SESSION['id']) ? $_SESSION['id'] : null
                );

                if($existe) { ?>
                    <span class="recipefav-filled" data-id="<?php echo $recette['id'] ?>"><i class="bi bi-heart-fill"></i></span>
                <?php } else { ?>
                    <span class="recipefav" data-id="<?php echo $recette['id'] ?>"><i class="bi bi-heart"></i></span>
                <?php } ?>

                <?php if (isset($_SESSION['isAdmin']) && $_SESSION['isAdmin'] == 1) { ?>
                    <a href="?c=Recette&a=supprimer&id=<?php echo $recette['id'] ?>">
                        <i class="bi bi-trash"></i>
                    </a>
                <?php } ?>

                <div class="recipe card" data-id="<?php echo $recette['id']; ?>">

                    <div class="card-body">
                        <h2 class="card-title"><?php echo $recette['titre']; ?></h2>
                        <p class="card-img">
                            <img src="<?php echo $recette['image']; ?>" alt="image" width="50%" height="50%">
                        </p>
                        <p class="card-text"><?php echo $recette['description']; ?></p>
                        Auteur : 
                        <a href="mailto:<?php echo $recette['auteur']; ?>">
                            <?php echo $recette['auteur'] ?>
                        </a>
                    </div>
                
                </div>
            </div>
        
        <?php endforeach; ?>
    
    </div>

    <a href="?c=home" class="btn btn-primary">Retour à l'accueil</a>

</body>
