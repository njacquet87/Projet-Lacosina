
document.addEventListener('DOMContentLoaded', () => {
    /*
    let profil_identifiant = document.getElementById('profil_identifiant');

    let profil_mail = document.getElementById('profil_mail');

    let modifier_profil = document.getElementById('bouton_modifier_profil');

    profil_identifiant.addEventListener('input', (event) => {
        modifier_profil.classList.remove('d-none');
    });

    profil_mail.addEventListener('input', (event) => {
        modifier_profil.classList.remove('d-none');
    });
    */

    let divFavoris = document.getElementById('favoris');

    if (divFavoris) {
        
        let id_utilisateur = divFavoris.dataset.id;

        fetch('?c=Favori&a=getFavoris&x&id=' + id_utilisateur)
            .then(reponse => reponse.json())
            .then(reponse => {
                JSON.stringify(reponse);
                divFavoris.innerHTML = "<ul>"
                divFavoris.innerHTML += reponse.map(fav => {
                    return "<li><a href='?c=detail&id="+fav.id+"'>"+fav.titre+"</a></li>";
                }).join("");
                divFavoris.innerHTML += "</ul>"
            })
    }
});