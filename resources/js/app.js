import './bootstrap';

// Ajax funkcija pridėti prekę į krepšelį
$(document).ready(function() {
    // Kai vartotojas paspaudžia "Pridėti į krepšelį"
    $('.add-to-cart').on('click', function(e) {
        e.preventDefault();

        var productId = $(this).data('id');
        var productName = $(this).data('name');
        var productPrice = $(this).data('price');

        // Ajax užklausa
        $.ajax({
            url: '/cart/add',
            method: 'POST',
            data: {
                _token: $('meta[name="csrf-token"]').attr('content'),
                id: productId,
                name: productName,
                price: productPrice
            },
            success: function(response) {
                if (response.success) {
                    // Parodyti pranešimą apie sėkmingą pridėjimą
                    alert(response.message);

                    // Atvaizduoti krepšelio prekių skaičių
                    $('.cart-count').text(response.cartCount);
                }
            }
        });
    });
});
