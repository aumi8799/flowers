@extends('layouts.app')

@section('title', 'Pirkinių krepšelis')

@section('content')
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray">
                <h1 class="display-4 fw-bolder">Jūsų pirkinių krepšelis</h1>
            </div>
        </div>
    </header>

    <div class="container my-5">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @php $totalPrice = 0; @endphp

        @if(empty($cart))
            <div class="text-center my-5">
                <img src="{{ asset('images/cart-empty.png') }}" alt="Tuščias krepšelis" class="img-fluid" style="max-width: 150px;">
                <p class="mt-3">Krepšelyje nėra produktų</p>
            </div>
        @else
            <div class="row">
                <div class="col-md-8">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Prekė</th>
                                <th></th>
                                <th>Kiekis</th>
                                <th>Suma</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalPrice = 0; @endphp

                            @foreach($cart as $id => $item)
                                @php
                                    $itemTotal = $item['price'] * $item['quantity'];
                                    $totalPrice += $itemTotal;
                                @endphp
                                <tr>
                                    <td>
                                        <img src="{{ asset('images/products/' . $item['image']) }}" alt="{{ $item['name'] }}" class="img-fluid" style="max-width: 80px; height: 80px;">
                                    </td>
                                    <td class="align-middle">{{ $item['name'] }}</td>
                                    <td class="align-middle">{{ $item['quantity'] }}</td>
                                    <td class="align-middle">{{ $itemTotal }} €</td>
                                    <td class="align-middle">
                                        <form action="{{ route('cart.remove', $id) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" style="background: none; border: none; padding: 0;">
                                                <img src="{{ asset('images/trash-icon.png') }}" alt="Šiukšlių dėžė" style="width: 20px; height: 20px;">
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="col-md-4">
                    <div class="border p-3 rounded">
                        <h4 style="font-weight: normal; font-size: 1.2rem;">Kaina už prekes: {{ $totalPrice }} €</h4>
                        <hr>
                        <h5 class="mb-3">Pirkėjo duomenys:</h5>

                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="first-name" class="form-label">Vardas</label>
                                    <input type="text" class="form-control form-control-sm" id="first-name" name="first_name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="last-name" class="form-label">Pavardė</label>
                                    <input type="text" class="form-control form-control-sm" id="last-name" name="last_name" required>
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="phone" class="form-label">Telefono numeris</label>
                                <div class="input-group input-group-sm">
                                    <span class="input-group-text">+370</span>
                                    <input type="text" class="form-control" id="phone" name="phone" required maxlength="8" pattern="\d{8}">
                                </div>
                            </div>

                            <div class="mb-3">
                                <label for="email" class="form-label">El. paštas</label>
                                <input type="email" class="form-control form-control-sm" id="email" name="email" required>
                            </div>

                            <div class="mb-3">
                                <label for="delivery-city-select" class="form-label">Miestas</label>
                                <select class="form-select form-select-sm" id="delivery-city-select" onchange="updateShippingCost()" required>
                                    <option value="" disabled selected>Pasirinkite miestą</option>
                                    <option value="7">Vilnius - 7 €</option>
                                    <option value="10">Kaunas - 10 €</option>
                                </select>
                            </div>

                            <div class="mb-3">
                                <label for="delivery-address" class="form-label">Pristatymo adresas</label>
                                <input type="text" class="form-control form-control-sm" id="delivery-address" name="delivery_address" required>
                            </div>

                            <div class="mb-3">
                                <label for="postal-code" class="form-label">Pašto kodas</label>
                                <input type="text" class="form-control form-control-sm" id="postal-code" name="postal_code" required>
                            </div>

                            <div class="mb-3">
                                <label for="notes" class="form-label">Pastabos</label>
                                <textarea class="form-control form-control-sm" id="notes" name="notes" rows="2"></textarea>
                            </div>


                        <div>
                            <strong>Pristatymo kaina: <span id="shipping-cost">0</span> €</strong>
                        </div>
                        <hr>
                        <div style="text-align: right;">
                            <h4 style="font-weight: normal; font-size: 1rem;">Viso: <span id="total-cost">{{ $totalPrice }}</span> €</h4>
                        </div>

                        <!-- Checkout button -->
                        <a  href="#"
                            class="btn btn-dark w-100 mt-4"
                            onclick="return validateCheckout()"
                            id="checkout-button"
                            style="pointer-events: none; opacity: 0.5;">
                            Tęsti atsiskaitymą
                        </a>


                        <!-- Order reservation (prisijungusiems) -->
                        <div class="text-center">
                        @auth
                            <form action="{{ route('order.reserve') }}" method="POST">
                                @csrf
                                <input type="hidden" name="total_price" id="hidden-total-price" value="{{ $totalPrice }}">
                                <input type="hidden" id="delivery-city" name="delivery_city" value="">
                                <button type="submit" class="btn btn-success mt-3" id="reserve-order-btn" disabled>
                                    Rezervuoti užsakymą
                                </button>
                            </form>
                            @else
                                <p class="mt-3" style="font-size: 1.1rem;">Jei norite rezervuoti ar nusipirkti prekę, prašome 
                                    <a href="{{ route('login') }}" class="text-success">prisijungti</a> 
                                    arba 
                                    <a href="{{ route('register') }}" class="text-success">užsiregistruoti</a>.
                                </p>
                            @endauth

                        </div>
                    </div>
                </div>
            </div>


         <script>
            let totalPrice = @json($totalPrice); // Bendra krepšelio kaina be pristatymo

            function updateShippingCost() {
                const citySelect = document.getElementById('delivery-city-select');
                const city = citySelect.value;

                if (!city) return; // Jei miestas nepasirinktas – nieko nedarom

                const shippingCost = parseInt(city); // Iš value paimam kainą (7 arba 10)
                const updatedTotal = totalPrice + shippingCost;

                // 🧾 Atnaujinam tekstus DOM'e
                document.getElementById('shipping-cost').textContent = shippingCost;
                document.getElementById('total-cost').textContent = updatedTotal;

                // 💾 Paslėpti laukeliai, kad serveris gautų tikslų totalą ir miestą
                document.getElementById('hidden-total-price').value = updatedTotal;
                document.getElementById('delivery-city').value = city;

                // 🧭 Checkout mygtuko nuoroda
                const checkoutButton = document.getElementById('checkout-button');
                checkoutButton.href = `/checkout?total=${updatedTotal}&city=${city}`;
                checkoutButton.style.pointerEvents = 'auto';
                checkoutButton.style.opacity = '1';

                // ✅ Rezervavimo mygtuko aktyvavimas (jei rodomas)
                const reserveBtn = document.getElementById('reserve-order-btn');
                if (reserveBtn) {
                    reserveBtn.disabled = false;
                }
            }

            function validateCheckout() {
                const city = document.getElementById('delivery-city-select').value;
                if (!city) {
                    alert("Prašome pasirinkti miestą pristatymui.");
                    return false;
                }
                return true;
            }

            // Paleidžiam automatiškai jei miestas jau pasirinktas
            window.addEventListener('DOMContentLoaded', function () {
                const citySelect = document.getElementById('delivery-city-select');
                if (citySelect.value) {
                    updateShippingCost(); // paleidžia funkciją ir aktyvuoja mygtuką
                }
            });
         </script>
      @endif
      </div>

@endsection
