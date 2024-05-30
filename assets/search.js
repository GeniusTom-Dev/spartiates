document.addEventListener("DOMContentLoaded", function () {
    function setupSearch(inputId, cardContainerSelector, cardSelector, nameSelector) {
        const searchInput = document.getElementById(inputId);
        const resultContainer = document.querySelector(cardContainerSelector);
        const cards = resultContainer.querySelectorAll(cardSelector);

        searchInput.addEventListener('input', function () {
            const query = searchInput.value.toLowerCase();

            cards.forEach(card => {
                const name = card.querySelector(nameSelector).textContent.toLowerCase();
                if (name.includes(query)) {
                    card.style.display = 'flex';
                } else {
                    card.style.display = 'none';
                }
            });
        });
    }

    if (document.getElementById('searchSpartan')) {
        setupSearch('searchSpartan', '.result', '.spartan-card', '.spartan-name');
    }

    if (document.getElementById('searchQuestion')) {
        setupSearch('searchQuestion', '.result', '.question-card', '.question-text');
    }
});
