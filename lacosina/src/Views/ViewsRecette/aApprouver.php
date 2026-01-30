<?php if (count($recettes) == 0) { ?>
    <p>Aucune recette en attente d'approbation.</p>
<?php } else { ?>

    <h1 class="mt-5 mb-5">Recettes à approuver</h1>

    <!-- première ligne du tableau -->

    <div class="row border bg-light fw-bold py-2 text-center">

        <div class="col border-end">
            <p>Titre</p>
        </div>

        <div class="col border-end">
            <p>Description</p>
        </div>

        <div class="col border-end">
            <p>Auteur</p>
        </div>

        <div class="col">
            <p>Action</p>
        </div>
    </div>

    <!-- lignes des recettes -->

    <?php foreach ($recettes as $recette) : ?>
        <div class="row border py-2 text-center justify-content-center">

            <div class="col height-max-content border-end">
                <p><?php echo $recette['titre']; ?></p>
            </div>

            <div class="col height-max-content border-end" style="overflow-y: auto; height: 150px;">
                <p><?php echo $recette['description']; ?></p>
            </div>

            <div class="col height-max-content border-end">
                <p><?php echo $recette['auteur']; ?></p>
            </div>

            <div class="col">
                <a href="?c=Recette&a=approuver&id=<?php echo $recette['id']; ?>" class="btn btn-success btn-sm">Approuver</a>
            </div>

        </div>
    <?php endforeach; ?>

<?php } ?>
