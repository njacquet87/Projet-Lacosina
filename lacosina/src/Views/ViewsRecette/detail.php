<h1><?php echo $recette['titre']; ?></h1>

<div style="width: 100%; display: relative;"><img src="<?php echo $recette['image']; ?>" alt="image" width="50%" height="50%" style="position: relative; left: 25%;"></div>

<h4>Description : </h4>
<div style="justify-content: center;"><?php echo $recette['description']; ?></div>

<h4>Type de la recette : </h4>
<?php echo $recette['type_plat'] ?>

<h4>Auteur : </h4>
<?php echo $recette['auteur']; ?>

<hr>

<?php if(isset($_SESSION['identifiant'])) { ?>
    <a href="?c=Recette&a=modifier&id=<?php echo $recette['id'];?>" class="btn btn-primary">Modifier la recette</a>

    <?php if($existe) { ?>
        <a href="?c=Favori&a=supprimer&recette_id=<?php echo $recette['id'];?>" class="btn btn-primary">Supprimer des favoris</a>
    <?php } else { ?>
        <a href="?c=Favori&a=ajouter&recette_id=<?php echo $recette['id'];?>" class="btn btn-primary">Ajouter aux favoris</a>
    <?php } ?>

<?php } ?>

<button id="btAjoutCommentaire" data-id="<?php echo $recette['id']?>" class="btn btn-primary">
    Ajouter un commentaire
</button>

<a href="?c=Recette&a=lister" class="btn btn-primary">Retour à la liste des recettes</a>

<h2>Commentaires</h2>

<div id="conteneurCommentaires">
        
    <?php if (count($commentaires) == 0) { ?>
        <p>Aucun commentaire sur cette recette</p>
    <?php } else { ?>
        <?php foreach ($commentaires as $commentaire) : ?>

            <div class="border border-dark rounded p-2 m-3">
                <p>Auteur : <?php echo $commentaire['pseudo']; ?></p>
                <p class="text-center"><?php echo $commentaire['commentaire']; ?></p>
                <p class="text-end">Le : <?php echo $commentaire['create_time']; ?></p>
            </div>
        
        <?php endforeach; ?>
            
    <?php } ?>
</div>
