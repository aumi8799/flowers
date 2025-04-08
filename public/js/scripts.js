// 'Rodyti daugiau' mygtuko veiksmas
document.addEventListener('DOMContentLoaded', function() {
    let currentPage = 1;
    const loadMoreButton = document.getElementById('load-more');
    const productList = document.getElementById('product-list');

    loadMoreButton.addEventListener('click', function() {
        // Didiname puslapį ir siunčiame AJAX užklausą
        currentPage++;
        loadMoreProducts(currentPage);
    });

    function loadMoreProducts(page) {
        const url = new URL(window.location.href); // Paimam esamą URL
        url.searchParams.set('page', page); // Pridedam puslapio parametrą

        // Atlikti AJAX užklausą
        fetch(url)
            .then(response => response.text())
            .then(data => {
                const newProducts = document.createElement('div');
                newProducts.innerHTML = data;

                // Rasti naujai užkrautus produktus
                const newProductItems = newProducts.querySelector('.product-list').children;
                
                // Įterpti naujus produktus
                Array.from(newProductItems).forEach(item => {
                    productList.appendChild(item);
                });

                // Jei nėra daugiau produktų, paslėpti mygtuką
                if (newProducts.querySelector('.product-item') === null) {
                    loadMoreButton.style.display = 'none';
                }
            })
            .catch(error => console.error('Klaida užkraunant produktus:', error));
    }
});
