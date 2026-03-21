async function fetchTendances() {
    const response = await fetch('get_tendances.php');
    const data = await response.json();
    
    const display = document.getElementById('results');
    display.innerHTML = data.map(t => `
        <div class="card">
            <h3>${t.titre}</h3>
            <p>${t.description}</p>
            <small>Source: ${t.source} | Date: ${t.date_publication}</small>
            
            <div class="comment-section">
                <h4>Commentaires :</h4>
                <div id="comments_list_${t.id}">Chargement des commentaires...</div>

                <form onsubmit="submitComment(event, ${t.id})" class="comment-form">
                    <input type="hidden" id="user_${t.id}" value="1">
                    <textarea id="text_${t.id}" placeholder="Votre commentaire..." required></textarea>
                    <button type="submit">Commenter</button>
                </form>
                <div id="msg_${t.id}" class="msg"></div>
            </div>
        </div>
    `).join('');

    data.forEach(t => loadComments(t.id));
}


async function loadComments(tendanceId) {
    const response = await fetch(`get_comments.php?tendance_id=${tendanceId}`);
    const comments = await response.json();
    const listDiv = document.getElementById(`comments_list_${tendanceId}`);

    if (comments.length === 0) {
        listDiv.innerHTML = "<p style='font-size: 0.9em; color: gray;'><em>Aucun commentaire pour le moment.</em></p>";
        return;
    }

    listDiv.innerHTML = comments.map(c => `
        <div class="comment-item">
            <strong>${c.first_name} ${c.name}</strong> <small>(${c.date_heure})</small>
            <p>${c.text}</p>
        </div>
    `).join('');
}

async function submitComment(event, tendanceId) {
    event.preventDefault();

    const text = document.getElementById(`text_${tendanceId}`).value;
    const id_user = document.getElementById(`user_${tendanceId}`).value;
    const msgDiv = document.getElementById(`msg_${tendanceId}`);

    const response = await fetch('add_comment.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json'
        },
        body: JSON.stringify({
            text: text,
            tendance_id: parseInt(tendanceId),
            id_user: parseInt(id_user)
        })
    });

    const result = await response.json();

    if (result.status === 'success') {
        msgDiv.innerHTML = '<span style="color: green;">Commentaire ajouté !</span>';
        document.getElementById(`text_${tendanceId}`).value = '';
        loadComments(tendanceId);
        setTimeout(() => msgDiv.innerHTML = '', 3000);
    } else {
        msgDiv.innerHTML = `<span style="color: red;">Erreur : ${result.message}</span>`;
    }
}
