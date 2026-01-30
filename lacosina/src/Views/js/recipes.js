document.addEventListener('DOMContentLoaded', () => {

    function actionRecipe() {    
        let recipes = document.querySelectorAll('.recipe');
        let icones = document.querySelectorAll('.recipefav');
            let icones_favoris = document.querySelectorAll('.recipefav-filled');    recipes.forEach(recipe => {

            recipe.addEventListener('mouseover', (event) => {
                recipe.style.backgroundColor = "lightgray";
                recipe.style.cursor = "pointer";
            });

            recipe.addEventListener("mouseout", (event) => {
                recipe.style.backgroundColor = "";
            });

            recipe.addEventListener('click', (event) => {
                event.preventDefault();
                let recipeId = recipe.dataset.id;
                window.open("?c=Recette&a=detail&id=" + recipeId, "_self");
            });
        });

        icones.forEach(icone => {
            icone.addEventListener('mouseover', (event) => {
                icone.style.cursor = "pointer";
            });

            icone.addEventListener('click', (event) => {
                event.preventDefault();
                let id = icone.dataset.id;

                fetch('?c=Favori&a=ajouter&recette_id=' + id)
                    .then(() => {
                        location.reload();
                    });
            });
        });

        icones_favoris.forEach(icone => {
            icone.addEventListener('mouseover', (event) => {
                icone.style.cursor = "pointer";
            });

            icone.addEventListener('click', (event) => {
                event.preventDefault();
                let id = icone.dataset.id;

                fetch('?c=Favori&a=supprimer&recette_id=' + id)
                    .then(() => {
                        location.reload();
                    });
            });
        });
    }

    actionRecipe();

    let btnFilter = document.querySelectorAll('#filter');
    let listeRecettes = document.getElementById('listeRecettes');

    btnFilter.forEach(button => {

        button.addEventListener('mouseover', (event) => {
            button.style.cursor = "pointer";
            button.classList.add('bg-primary-subtle');
        });

        button.addEventListener('mouseout', (event) => {   
            button.classList.remove('bg-primary-subtle');
        });

        button.addEventListener('click', (event) => {
            let filtre = button.dataset.id;

            console.log(filtre);
            fetch('?c=Recette&a=lister&filtre=' + filtre)
            .then(response => response.text())
            .then(html => {
                let parser = new DOMParser();
                let doc = parser.parseFromString(html, 'text/html');

                let divContent = doc.querySelector('#listeRecettes');

                document.getElementById('listeRecettes').innerHTML = divContent.innerHTML;
            })
            .then(() => {
                actionRecipe();
            });
        });
    });

    /* commentaires */

    let btnAjoutCommentaire = document.getElementById('btAjoutCommentaire');
    let divCommentaire = document.getElementById('conteneurCommentaires');

    if (btnAjoutCommentaire) {

        btnAjoutCommentaire.addEventListener('click', (event) => {

            let formComment = document.createElement('form');
            formComment.method = 'post';
            formComment.action = '?c=Commentaire&a=ajouter&id=' + btAjoutCommentaire.dataset.id;

            let textarea = document.createElement('textarea');
            textarea.name = 'commentaire';
            textarea.placeholder = 'Saisir le commentaire';
            textarea.rows = '4';
            textarea.classList.add('form-control');
            textarea.required = true;

            let submitButton = document.createElement('button');
            submitButton.type = 'submit';
            submitButton.textContent = 'Valider le commentaire';
            submitButton.classList.add('btn', 'btn-primary', 'mt-2');

            let divMessage = document.createElement('div');
            divMessage.classList.add('mb-3');
            divMessage.appendChild(textarea);
            divMessage.appendChild(submitButton);

            formComment.appendChild(divMessage);
            divCommentaire.prepend(formComment);

            btAjoutCommentaire.classList.add('d-none');
        });

    }


});
