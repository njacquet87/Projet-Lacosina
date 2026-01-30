<h1>Liste des commentaires</h1>

    <div class="row">

        <?php if (count($commentaires) == 0) {
            echo 'Aucun commentaire';
        } else {

            foreach ($commentaires as $commentaire) : ?>

                <div class="col-4 p-2">
                    <a href="?c=Commentaire&a=supprimer&id=<?php echo $commentaire['id'] ?>">
                        <i class="bi bi-trash"></i>
                    </a>

                    <div class="border border-dark rounded p-1">
                        <p>Pseudo : <?php echo $commentaire['pseudo'] ?></p>
                        <p>Commentaire : <?php echo $commentaire['commentaire'] ?></p>
                        <p>Date de création : <?php echo $commentaire['create_time'] ?></p>
                    </div>

                </div>
        
            <?php endforeach; 
        }?>
    
    </div>

    <a href="?c=home" class="btn btn-primary">Retour à l'accueil</a>