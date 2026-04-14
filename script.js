let trendChart = null;

async function fetchJson(url){
    const response = await fetch(url);
    return await response.json();
}

async function loadCategories(){
    const categories = await fetchJson('get_data.php?action=categories');
    const select = document.getElementById("categorie");

    select.innerHTML = '<option value="">-- Choisir une catégorie --</option>';

    categories.forEach(category =>{
        const option = document.createElement('option');
        option.value = category;
        option.textContent = formatLabel(category);
        select.appendChild(option);
    });
}

async function handleCategoryChange(){
    const categorie = document.getElementById('categorie').value;
    const paysSelect = document.getElementById('pays');
    const indicateurSelect = document.getElementById('indicateur');

    paysSelect.innerHTML = '<option value="">-- Choisir un pays --</option>';
    indicateurSelect.innerHTML = '<option value="">-- Choisir un indicateur --</option>';
    indicateurSelect.disabled = true;

    if(!categorie){
        paysSelect.disabled = true;
        return;
    }

    const paysList = await fetchJson(`get_data.php?action=pays&categorie=${encodeURIComponent(categorie)}`);
    paysSelect.disabled = false;

    paysList.forEach(pays =>{
        const option = document.createElement('option');
        option.value = pays;
        option.textContent = pays;
        paysSelect.appendChild(option);
    });
}

async function handleCountryChange(){
    const categorie = document.getElementById('categorie').value;
    const pays = document.getElementById('pays').value;
    const indicateurSelect = document.getElementById('indicateur');

    indicateurSelect.innerHTML = '<option value="">-- Choisir un indicateur --</option>';

    if(!categorie || !pays){
        indicateurSelect.disabled = true;
        return;
    }

    const indicateurs = await fetchJson(`get_data.php?action=indicateurs&categorie=${encodeURIComponent(categorie)}&pays=${encodeURIComponent(pays)}`);

    indicateurSelect.disabled = false;

    indicateurs.forEach(indicateur =>{
        const option = document.createElement('option');
        option.value = indicateur;
        option.textContent = formatLabel(indicateur);
        indicateurSelect.appendChild(option);
    });
}

async function loadValues(){
    const categorie = document.getElementById('categorie').value;
    const pays = document.getElementById('pays').value;
    const indicateur = document.getElementById('indicateur').value;

    if (!categorie || !pays || !indicateur) {
        alert('Veuillez choisir une catégorie, un pays et un indicateur.');
        return;
    }

    const data = await fetchJson(`get_data.php?action=values&categorie=${encodeURIComponent(categorie)}&pays=${encodeURIComponent(pays)}&indicateur=${encodeURIComponent(indicateur)}`);

    if (data.error) {
        alert(data.error);
        return;
    }

    renderChart(data.annees, data.valeurs, data.indicateur, data.pays, data.categorie);

    document.getElementById('comments-section').style.display = 'block';
    loadComments(categorie, pays, indicateur);
}

function renderChart(annees, valeurs, indicateur, pays, categorie){
    const ctx = document.getElementById("trendChart").getContext('2d');

    if(trendChart){
        trendChart.destroy();
    }

    trendChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels : annees,
            datasets : [{
                label: `${formatLabel(indicateur)} - ${pays}`,
                data: valeurs,
                borderWidth: 2,
                tension: 0.3,
                fill: false
            }]
        },
        options: {
            responsive: true,
            plugins: {
                legend: {
                    display: true
                }
            },
            scales: {
                y: {
                    beginAtZero: false
                }
            }
        }
    });
    
    document.getElementById('chart-title').textContent = `${formatLabel(categorie)} - ${pays} - ${formatLabel(indicateur)}`;

    document.getElementById('data-info').innerHTML = `
        <p><strong>Catégorie :</strong> ${formatLabel(categorie)}</p>
        <p><strong>Pays :</strong> ${pays}</p>
        <p><strong>Indicateur :</strong> ${formatLabel(indicateur)}</p>
    `;
}

function formatLabel(text) {
    return text
        .replaceAll('_', ' ')
        .replace(/\b\w/g, char => char.toUpperCase());
}

async function loadComments(categorie, pays, indicateur){
    const comments = await fetchJson(`get_comments.php?categorie=${encodeURIComponent(categorie)}&pays=${encodeURIComponent(pays)}&indicateur=${encodeURIComponent(indicateur)}`);

    const listDiv = document.getElementById("comments-list");
    if(!comments.length){
        listDiv.innerHTML = "<p><em>Aucun commentaire pour le moment.</em></p>";
        return;
    }
    listDiv.innerHTML = comments.map(comment => `
        <div class="comment-item">
            <strong>${escapeHtml(comment.user)}</strong>
            <small>${comment.date}</small>
            <p>${escapeHtml(comment.text)}</p>
        </div>
    `).join('');
}

async function submitComment(e){
    e.preventDefault();

    const text = document.getElementById('comment-text').value.trim();
    const categorie = document.getElementById('categorie').value;
    const pays = document.getElementById('pays').value;
    const indicateur = document.getElementById('indicateur').value;
    const msgDiv = document.getElementById('comment-msg');

    if(!text){
        msgDiv.innerHTML = "<span style='color:red;'>Lecommentaire est vide.</span>";
        return;
    }

    const response = await fetch('add_comment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({ text, categorie, pays, indicateur })
    });
    const result = await response.json();

    if(result.status === 'success'){
        msgDiv.innerHTML = "<span style='color:green;'>Commentaire ajouté.</span>";
        document.getElementById('comment-text').value = '';
        await loadComments(categorie, pays, indicateur);
        setTimeout(() => {
            msgDiv.innerHTML = '';
        }, 3000);
    }else{
        msgDiv.innerHTML = `<span style='color:red;'>Erreur : ${result.message}</span>`;
    }
}

function escapeHtml(text){
    const div = document.createElement('div');
    div.textContent = text;
    return div.innerHTML;
}

function setupMapClicks(){
    const points = document.querySelectorAll(".map-point");

    points.forEach(point =>{
        point.addEventListener('click', async()=>{
            const country = point.dataset.country;

            const paysSelect = document.getElementById('pays');
            const categorie = document.getElementById('categorie').value;
            const indicateur = document.getElementById('indicateur').value;

            document.getElementById('selected-country-info').innerHTML = `
                <p><strong>Pays sélectionné :</strong>${country}</p>
            `;
            if(!categorie){
                alert("Choisissez d'abord une catégorie.");
                return;
            }

            //recharger les pays selon la catégorie choisie
            await handleCategoryChange();

            //selectionner automatiquement le pays choisi
            paysSelect.value = country;

            //recharger les indicateurs pour ce pays
            await handleCountryChange();

            //si un indicateur est deja choisi, on affiche directement
            if(indicateur){
                document.getElementById("indicateur").value = indicateur;
                loadValues();
            }
        });
    });
}

document.addEventListener("DOMContentLoaded", ()=>{
    loadCategories();

    document.getElementById('categorie').addEventListener('change', handleCategoryChange);
    document.getElementById('pays').addEventListener('change', handleCountryChange);
    document.getElementById('btn-load').addEventListener('click', loadValues);
    document.getElementById('comment-form').addEventListener('submit', submitComment);

    setupMapClicks();
});
