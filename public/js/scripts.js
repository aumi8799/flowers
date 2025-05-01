document.addEventListener('DOMContentLoaded', function () {
    let currentPage = 1;
    const loadMoreButton = document.getElementById('load-more');
    const productList = document.getElementById('product-list');
    const orderList = document.getElementById('order-list');

    if (!loadMoreButton) return;

    loadMoreButton.addEventListener('click', function () {
        currentPage++;
        loadMoreItems(currentPage);
    });

    function loadMoreItems(page) {
        const url = new URL(window.location.href);
        url.searchParams.set('page', page);

        fetch(url)
            .then(response => response.text())
            .then(data => {
                const newContent = document.createElement('div');
                newContent.innerHTML = data;

                const newProductItems = newContent.querySelector('.product-list')?.children || [];
                const newOrderItems = newContent.querySelector('.order-list')?.children || [];

                if (productList) {
                    Array.from(newProductItems).forEach(item => productList.appendChild(item));
                    if (newProductItems.length === 0) loadMoreButton.style.display = 'none';
                }

                if (orderList) {
                    Array.from(newOrderItems).forEach(item => orderList.appendChild(item));
                    if (newOrderItems.length === 0) loadMoreButton.style.display = 'none';
                }
            })
            .catch(error => console.error('Klaida užkraunant daugiau duomenų:', error));
    }
});
