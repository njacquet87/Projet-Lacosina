<?php if (count($recettes) == 0) { ?>
    <p>Aucune recette en attente d'approbation.</p> 
<?php } else { ?>

    <h1 class="mt-5 mb-5">Mes recettes en cours de validation</h1>

    <div style="justify-content: center; align-items: center; display: flex; flex-direction: column;">
        <div class="row border bg-light fw-bold py-2 text-center" style="width: 80%;">

            <div class="col border-end">
                <p>Titre</p>
            </div>

            <div class="col border-end">
                <p>Description</p>
            </div>

        </div>

        <?php foreach ($recettes as $recette) : ?>
            <div class="row border py-2 text-center justify-content-center" style="width: 80%; align-items: center;">

                <div class="col height-max-content border-end">
                    <a href="?c=Recette&a=detail&id=<?php echo $recette['id'] ?>"><?php echo $recette['titre'] ?></a>
                </div>

                <div class="col height-max-content border-end" style="overflow-y: auto; height: 70px;">
                    <p><?= $recette['description']; ?></p>
                </div>

            </div>
        <?php endforeach; ?>        
    </div>

<?php } ?>
