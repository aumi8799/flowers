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
                            @php
                                $totalPrice = 0;
                            @endphp

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
                        <h5>Pristatymo išlaidos:</h5>
                        <div class="mb-3">
                            <select class="form-select" id="delivery-city-select" onchange="updateShippingCost()">
                                <option value="" disabled selected>Pasirinkite miestą</option>
                                <option value="7">Vilnius - 7 €</option>
                                <option value="10">Kaunas - 10 €</option>
                            </select>
                        </div>
                        <div>
                            <strong>Pristatymo kaina: <span id="shipping-cost">7</span> €</strong>
                        </div>
                        <hr>
                        <div style="text-align: right;">
                            <h4 style="font-weight: normal; font-size: 1rem;">Viso: <span id="total-cost">{{ $totalPrice + 7 }}</span> €</h4>
                        </div>
                        <form action="" method="GET">
                            <button type="submit" class="add-to-cart-btn w-100 mt-4">Tęsti atsiskaitymą</button>
                        </form>
                        <div class="text-center">
                            @auth
                            <form action="{{ route('order.reserve') }}" method="POST">
                                @csrf
                                <input type="hidden" name="total_price" value="{{ $totalPrice + 7 }}">
                                <input type="hidden" id="delivery-city" name="delivery_city" value="">
                                <button type="submit" class="btn btn-success mt-3" id="reserve-order-btn" disabled>Rezervuoti užsakymą</button>
                            </form>
                            @else
                                <p class="mt-3" style="font-size: 1.1rem;">Jei norite rezervuoti prekę, prašome 
                                    <a href="{{ route('login') }}" class="text-success">prisijungti</a> 
                                    arba 
                                    <a href="{{ route('register') }}" class="text-success">užsiregistruoti</a>.
                                </p>
                            @endauth
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>

    <script>
        @if(isset($totalPrice))
            var totalPrice = @json($totalPrice);
        @else
            var totalPrice = 0;
        @endif

        function updateShippingCost() {
            const citySelect = document.getElementById('delivery-city-select');
            const city = citySelect.value;
            const shippingCost = parseInt(city);
            
            document.getElementById('shipping-cost').textContent = shippingCost;
            document.getElementById('total-cost').textContent = totalPrice + shippingCost;

            document.getElementById('delivery-city').value = city;
        }

        // Užtikrinti, kad mygtukas būtų neaktyvus, jei miestas nepasirinktas
        document.getElementById('delivery-city-select').addEventListener('change', function() {
            const city = this.value;
            if (city) {
                document.getElementById('delivery-city').value = city;
                document.getElementById('reserve-order-btn').disabled = false;
            } else {
                document.getElementById('reserve-order-btn').disabled = true;
            }
        });
    </script>
@endsection
