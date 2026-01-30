<?php 
use App\Controllers\RecetteController;

if (count($commentaires) == 0) { ?>
    <p>Aucun commentaires en attente d'approbation.</p>
<?php } else { ?>

    <h1 class="mt-5 mb-5">Commentaires à approuver</h1>

    <!-- première ligne -->

    <div class="row border bg-light fw-bold py-2 text-center">

        <div class="col border-end">
            <p>Écrit par</p>
        </div>

        <div class="col border-end">
            <p>Commentaire</p>
        </div>

        <div class="col border-end">
            <p>Date</p>
        </div>

        <div class="col border-end">
            <p>Recette liée</p>
        </div>

        <div class="col">
            <p>Action</p>
        </div>
    </div>

    <!-- lignes des commentaires -->

    <?php foreach ($commentaires as $commentaire) : ?>
        <div class="row border py-2 text-center justify-content-center">

            <div class="col height-max-content border-end">
                <p><?php echo $commentaire['pseudo']; ?></p>
            </div>

            <div class="col height-max-content border-end">
                <p><?php echo $commentaire['commentaire']; ?></p>
            </div>

            <div class="col height-max-content border-end">
                <p><?php echo $commentaire['create_time']; ?></p>
            </div>

            <div class="col height-max-content border-end">
                <?php
                    // récupérer le titre de la recette associée
                    $recetteController = new RecetteController();
                    $recette = $recetteController->recettesParId($commentaire['recette_id']);
                    if ($recette) { ?>
                        <a href="?c=Recette&a=detail&id=<?php echo $recette['id']; ?>"><?php echo $recette['titre']; ?></a>
                    <?php } else { ?>
                        <p>recette non trouvée</p>
                    <?php } ?>
            </div>

            <div class="col">
                <a href="?c=Commentaire&a=approuver&id=<?php echo $commentaire['id']; ?>" class="btn btn-success btn-sm">Approuver</a>
            </div>

        </div>
    <?php endforeach; ?>

<?php } ?>
