/**
 * app.js
 * Mission Control Dashboard Logic
 */

document.addEventListener('DOMContentLoaded', () => {
    fetchLatestMissions();
    setupMissionForm();
});

function setupMissionForm() {
    const btnNewMission = document.getElementById('btn-new-mission');
    const btnCancelMission = document.getElementById('btn-cancel-mission');
    const btnPostMission = document.getElementById('btn-post-mission');
    const formContainer = document.getElementById('new-mission-form');

    btnNewMission.addEventListener('click', () => {
        formContainer.style.display = 'block';
        btnNewMission.style.display = 'none';
    });

    btnCancelMission.addEventListener('click', () => {
        formContainer.style.display = 'none';
        btnNewMission.style.display = 'block';
        clearForm();
    });

    btnPostMission.addEventListener('click', async () => {
        const title = document.getElementById('mission-title').value;
        const content = document.getElementById('mission-content').value;

        if (!title || !content) {
            alert('Mission title and details are required.');
            return;
        }

        btnPostMission.disabled = true;
        btnPostMission.textContent = 'Deploying...';

        try {
            const response = await fetch('010_Infinityai/api_post_wrapper.php', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ title, content })
            });

            if (!response.ok) {
                const errorData = await response.json();
                throw new Error(errorData.error || `HTTP Error: ${response.status}`);
            }

            alert(`Extraction Successful: Mission "${title}" has been deployed to the global network.`);

            // 成功したのでフォームを閉じる
            formContainer.style.display = 'none';
            btnNewMission.style.display = 'block';
            clearForm();
            fetchLatestMissions(); // リストを更新
        } catch (error) {
            console.error('Failed to deploy mission:', error);
            alert(`Deployment failed: ${error.message}`);
        } finally {
            btnPostMission.disabled = false;
            btnPostMission.textContent = 'Deploy Intel';
        }
    });
}

function clearForm() {
    document.getElementById('mission-title').value = '';
    document.getElementById('mission-content').value = '';
}

async function fetchLatestMissions() {
    const container = document.getElementById('articles-container');
    const agentBadges = document.querySelectorAll('.agent .badge');

    // Set agents to "Analyzing" state
    agentBadges.forEach(badge => {
        if (badge.textContent !== 'Commanding' && badge.textContent !== 'Master') {
            badge.textContent = 'Analyzing...';
            badge.style.background = 'rgba(212, 175, 55, 0.2)';
            badge.style.color = '#d4af37';
        }
    });

    try {
        const response = await fetch('010_Infinityai/api_wrapper.php');

        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.status}`);
        }

        const articles = await response.json();

        // Reset agents to "Active" state
        agentBadges.forEach(badge => {
            if (badge.textContent !== 'Commanding' && badge.textContent !== 'Master') {
                badge.textContent = 'Active';
                badge.style.background = 'rgba(76, 175, 80, 0.2)';
                badge.style.color = '#4caf50';
            }
        });

        renderArticles(articles);
    } catch (error) {
        console.error('Failed to fetch missions:', error);

        // Set agents to "Error" state
        agentBadges.forEach(badge => {
            if (badge.textContent !== 'Commanding' && badge.textContent !== 'Master') {
                badge.textContent = 'Offline';
                badge.style.background = 'rgba(255, 107, 107, 0.2)';
                badge.style.color = '#ff6b6b';
            }
        });

        container.innerHTML = `
            <div class="error-message" style="color: #ff6b6b; padding: 1rem; background: rgba(255,107,107,0.1); border-radius: 8px;">
                <p><strong>Connection Error</strong></p>
                <p style="font-size: 0.9rem;">Unable to retrieve mission data.</p>
            </div>
        `;
    }
}

function renderArticles(articles) {
    const container = document.getElementById('articles-container');

    if (!articles || articles.length === 0) {
        container.innerHTML = '<p class="text-muted">No missions found at this time.</p>';
        return;
    }

    container.innerHTML = articles.map(article => `
        <div class="article-item">
            <h4 class="article-title">${article.title.rendered}</h4>
            <span class="article-date">${new Date(article.date).toLocaleDateString('ja-JP')}</span>
            <br>
            <a href="${article.link}" target="_blank" class="article-link">View Full Intel &rarr;</a>
        </div>
    `).join('');
}
