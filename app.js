/**
 * app.js
 * Mission Control Dashboard Logic
 */

document.addEventListener('DOMContentLoaded', () => {
    fetchLatestMissions();
});

async function fetchLatestMissions() {
    const container = document.getElementById('articles-container');
    const agentBadges = document.querySelectorAll('.agent .badge');

    // Set agents to "Analyzing" state
    agentBadges.forEach(badge => {
        badge.textContent = 'Analyzing...';
        badge.style.background = 'rgba(212, 175, 55, 0.2)';
        badge.style.color = '#d4af37';
    });

    try {
        const response = await fetch('api_wrapper.php');

        if (!response.ok) {
            throw new Error(`HTTP Error: ${response.status}`);
        }

        const articles = await response.json();

        // Reset agents to "Active" state
        agentBadges.forEach(badge => {
            badge.textContent = 'Active';
            badge.style.background = 'rgba(76, 175, 80, 0.2)';
            badge.style.color = '#4caf50';
        });

        renderArticles(articles);
    } catch (error) {
        console.error('Failed to fetch missions:', error);

        // Set agents to "Error" state
        agentBadges.forEach(badge => {
            badge.textContent = 'Offline';
            badge.style.background = 'rgba(255, 107, 107, 0.2)';
            badge.style.color = '#ff6b6b';
        });

        container.innerHTML = `
            <div class="error-message" style="color: #ff6b6b; padding: 1rem; background: rgba(255,107,107,0.1); border-radius: 8px;">
                <p><strong>Connection Error</strong></p>
                <p style="font-size: 0.9rem;">Unable to retrieve mission data. Please ensure the API wrapper is accessible.</p>
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
