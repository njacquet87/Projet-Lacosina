<h1>Modifier la recette : <?php echo $recette['titre']; ?></h1>

<form action="?c=Recette&a=enregistrer&id=<?php echo $recette['id']; ?>" method="post" enctype="multipart/form-data">

    <div class="mb-3">
        <label for="titre" class="form-label">Titre de la recette</label>
        <input type="text" class="form-control" value="<?php echo $recette['titre']; ?>" name="titre" id="titre" required>
    </div>

    <div class="mb-3">
        <label for="description" class="form-label">Description de la recette</label>
        <textarea class="form-control" name="description" id="description" rows="3" required><?php echo $recette['description']; ?></textarea>
    </div>

    <div class="mb-3">
        <label for="type_plat" class="form-label">Type de plat</label>
        <select class="form-select" name="type_plat" id="type_plat" required>
            <option value="entree">Entrée</option>
            <option value="plat">Plat</option>
            <option value="dessert">Dessert</option>
        </select>
    </div>

    <div class="mb-3">
        <label for="auteur" class="form-label">Mail de l'auteur</label>
        <input type="email" class="form-control" value="<?php echo $recette['auteur']; ?>" name="auteur" id="auteur" required>
    </div>

    <div class="mb-3">
        <label for="image" class="from-label">Image de la recette <br> (pour la modifier merci de choisir la nouvelle image)</label>
        <img class="rounded w-25 mx-auto img-fluid" src="<?php echo $recette['image'] != '' ? $recette['image'] : 'upload/no_image.png'; ?>" alt="<?php echo $recette['titre']?>" class="card-img-top">
        <input type="file" class="from-control" name="image" id="image">
    </div>

    <div class="mb-3">
        <button type="submit" class="btn btn-primary" id="enregistrer">Modifier</button>
    </div>
    
</form>
