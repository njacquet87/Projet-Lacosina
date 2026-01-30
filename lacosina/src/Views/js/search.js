let recipes = [];

function loadRecipes() {

    //utilisation de &x pour ne pas avoir le header et le footer en plus du JSON
    fetch('?c=Recette&a=listerJSON&x')
        .then(response => response.json())
        .then(data => {
            recipes = data;
        });
}

function filterRecipes() {
    let search = document.getElementById('search');
    const query = search.value.toLowerCase().trim();

    const filtered = recipes.filter(recipe => 
        recipe.titre.toLowerCase().includes(query)
    )

    displayRecipes(filtered);
}

function displayRecipes(recipes) {

    const resultsDiv = document.getElementById('results');
    resultsDiv.innerHTML = '';

    if (recipes.length === 0) {
        const result = document.createElement('p');
        result.textContent = 'Aucune recette trouvée.';
        resultsDiv.appendChild(result);
    } else {
        recipes.forEach(recipe => {
            const recipeDiv = document.createElement('div');
            recipeDiv.className = 'border border-2 border-dark rounded-2 p-3 mb-3';
            const title = document.createElement('h2');
            title.textContent = recipe.titre;

            const description = document.createElement('p');
            description.textContent = recipe.description;
            const link = document.createElement('a');

            link.href = `?c=Recette&a=detail&id=${recipe.id}`;
            link.textContent = 'Voir la recette';

            recipeDiv.appendChild(title);
            recipeDiv.appendChild(description);
            recipeDiv.appendChild(link);
            resultsDiv.appendChild(recipeDiv);
        })
    }
}

document.addEventListener('DOMContentLoaded', () => {
    loadRecipes();

    let search = document.getElementById('search');

    search.addEventListener('focus', () => {
        const container = document.querySelector('.container');

        // vider la div
        container.innerHTML = '';
        
        const title = document.createElement('h1');
        title.textContent = 'Résultats de la recherche';
        
        const resultsDiv = document.createElement('div');
        resultsDiv.id = 'results';
        
        container.appendChild(title);
        container.appendChild(resultsDiv);
        displayRecipes(recipes);
    });

    search.addEventListener('blur', () => {
        location.reload();
    });

    search.addEventListener('input', () => {
        filterRecipes();
    });
});