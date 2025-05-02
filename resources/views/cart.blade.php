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
                                <th>Atvirukas</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalPrice = 0; @endphp

                            @foreach($cart as $key => $item)

                            @if(isset($item['type']) && $item['type'] === 'subscription')
                                @php
                                    $itemTotal = $item['price'];
                                    $totalPrice += $itemTotal;
                                @endphp
                                <tr>
                                    <td>
                                <strong>Gėlių prenumerata</strong><br>
                                    </td>
                                    <td class="align-middle">
                                        <br>
                                        Kategorija: {{ ucfirst($item['category']) }}<br>
                                        Dydis: {{ $item['size'] }}<br>
                                        Trukmė: {{ $item['duration'] }} mėn.
                                    </td>
                                    <td class="align-middle">1</td>
                                    <td class="align-middle">{{ $itemTotal }} €</td>
                                    <td class="align-middle"></td>
                                    <td class="align-middle">
                                        <form action="{{ route('cart.remove', $key) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" style="background: none; border: none; padding: 0;">
                                                <img src="{{ asset('images/trash-icon.png') }}" alt="Šiukšlių dėžė" style="width: 20px; height: 20px;">
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @elseif(isset($item['type']) && $item['type'] === 'giftcoupon')
                                    {{-- Dovanų kupono rodymas --}}
                                    @php
                                        $totalPrice += $item['price'];
                                    @endphp
                                    <tr>
                                        <td><strong>Dovanų kuponas</strong></td>
                                        <td></td>
                                        <td>1</td>
                                        <td>{{ number_format($item['price'], 2) }} €</td>
                                        <td>–</td>
                                        <td>
                                            <form action="{{ route('cart.remove', $key) }}" method="POST">
                                                @csrf
                                                <button type="submit" style="background: none; border: none; padding: 0;">
                                                    <img src="{{ asset('images/trash-icon.png') }}" alt="Ištrinti" style="width: 20px; height: 20px;">
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                @else
                                @php
                                    $itemTotal = $item['price'] * $item['quantity'];
                                    $totalPrice += $itemTotal;
                                @endphp
                                <tr>
                                <td>
                                       @if (is_array($item) && array_key_exists('image', $item) && !empty($item['image']))
                                            <img src="{{ asset('images/products/' . $item['image']) }}" alt="{{ $item['name'] }}" class="img-fluid" style="max-width: 80px; height: 80px;">
                                        @else
                                            <img src="{{ asset('images/default-bouquet.png') }}" alt="Individuali puokštė" class="img-fluid" style="max-width: 80px; height: 80px;">
                                        @endif

                                    </td>
                                    <td class="align-middle">{{ $item['name'] }}</td>
                                    <td class="align-middle">{{ $item['quantity'] }}</td>
                                    <td class="align-middle">{{ $itemTotal }} €</td>
                                    <td class="align-middle">
                                        @if(isset($item['postcard']) && !empty($item['postcard']))
                                            <i class="fas fa-check-circle" style="color: green; font-size: 1.5rem;"></i>
                                        @else
                                            <i class="fas fa-times-circle" style="color: gray; font-size: 1.5rem;"></i>
                                        @endif
                                    </td>

                                    <td class="align-middle">
                                        <form action="{{ route('cart.remove', $key) }}" method="POST" style="display: inline;">
                                            @csrf
                                            <button type="submit" style="background: none; border: none; padding: 0;">
                                                <img src="{{ asset('images/trash-icon.png') }}" alt="Šiukšlių dėžė" style="width: 20px; height: 20px;">
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                            @endif
                        @endforeach
                        @php
                                $discount = session('gift_coupon_discount', 0);
                                $totalPrice -= $discount;
                                if ($totalPrice < 0) $totalPrice = 0;
                            @endphp
                        </tbody>
                    </table>
                </div>

                <div class="col-md-4">
                    <div class="border p-3 rounded">
                        <h4 style="font-weight: normal; font-size: 1.2rem;">Kaina už prekes: {{ $totalPrice }} €</h4>
                        <form action="{{ route('cart.apply_coupon') }}" method="POST" class="mb-3">
                            @csrf
                            <label for="coupon_code" class="form-label">Turite dovanų kuponą?</label>
                            <div class="input-group">
                                <input type="text" name="coupon_code" id="coupon_code" class="form-control" placeholder="Įveskite kupono kodą" required>
                                <button class="btn btn-outline-primary" type="submit">Panaudoti</button>
                            </div>
                            @if(session('coupon_error'))
                                <div class="text-danger mt-2">{{ session('coupon_error') }}</div>
                            @endif
                            @if(session('coupon_success'))
                                <div class="text-success mt-2">{{ session('coupon_success') }}</div>
                            @endif
                        </form>

                        <hr>
                        <h5 class="mb-3">Įveskite pirkėjo duomenis ir pristatymo adresą:</h5>

                        <!-- Vardas ir Pavardė vienoje eilutėje -->
                        <div class="row mb-3">
                            <div class="col-md-6">
                                <label for="first-name" class="form-label">Vardas</label>
                                <input type="text" class="form-control" id="first-name" name="first_name" required>
                            </div>
                            <div class="col-md-6">
                                <label for="last-name" class="form-label">Pavardė</label>
                                <input type="text" class="form-control" id="last-name" name="last_name" required>
                            </div>
                        </div>

                        <!-- Telefonas -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">Telefonas</label>
                            <input type="tel" class="form-control" id="phone" name="phone" pattern="[0-9]{3}[0-9]{3}[0-9]{3}" required placeholder="Pvz.: 860123456">
                        </div>

                        <!-- El. paštas -->
                        <div class="mb-3">
                            <label for="email" class="form-label">El. paštas</label>
                            <input type="email" class="form-control" id="email" name="email" required placeholder="Pavyzdys@mail.com">
                        </div>

                        <!-- Pristatymo adresas -->
                        <div class="mb-3">
                            <label for="delivery_address" class="form-label">Pristatymo adresas</label>
                            <input type="text" class="form-control" id="delivery_address" name="delivery_address" required>
                        </div>

                        <!-- Pašto kodas -->
                        <div class="mb-3">
                            <label for="postal-code" class="form-label">Pašto kodas</label>
                            <input type="text" class="form-control" id="postal-code" name="postal_code" required>
                        </div>
                        <!-- Pristatymo data -->
                        <div class="mb-3">
                            <label for="delivery_date" class="form-label">Pristatymo data</label>
                            <input 
                                type="text" 
                                id="delivery_date" 
                                name="delivery_date" 
                                class="form-control" 
                                placeholder="Pasirinkite datą" 
                                required
                            >
                        </div>

                        <div class="mb-3">
                            <label for="delivery_time" class="form-label">Pageidaujamas pristatymo laikas</label>
                            <select class="form-select" id="delivery_time" name="delivery_time" required>
                                <option value="">Pasirinkite laiką</option>
                                <option value="10:00 - 12:00">10:00 – 12:00</option>
                                <option value="12:00 - 15:00">12:00 – 15:00</option>
                                <option value="15:00 - 18:00">15:00 – 18:00</option>
                            </select>
                        </div>

                        <!-- Pastabos -->
                        <div class="mb-3">
                            <label for="notes" class="form-label">Pastabos</label>
                            <textarea class="form-control" id="notes" name="notes" rows="3"></textarea>
                        </div>

                        <!-- Miestas ir Pristatymo kaina -->
                        <div class="mb-3">
                            <label for="delivery-city-select" class="form-label">Miestas</label>
                            <select class="form-select form-select-sm" id="delivery-city-select" onchange="updateShippingCost()" required>
                                <option value="" disabled selected>Pasirinkite miestą</option>
                                <option value="7">Vilnius - 7 €</option>
                                <option value="10">Kaunas - 10 €</option>
                            </select>
                        </div>

                        <!-- Pristatymo kaina -->
                        <div>
                            <strong>Pristatymo kaina: <span id="shipping-cost">0</span> €</strong>
                        </div>
                        <hr>
                        <!-- Pristatymo video pasirinkimas -->
                        <div class="form-check mb-3">
                            <input class="form-check-input" type="checkbox" id="delivery-video" name="delivery_video" >
                            <label class="form-check-label" for="delivery-video">
                                Noriu gauti pristatymo vaizdo įrašą (+5 Eur)
                            </label>
                        </div>

                        <hr>
                        <div style="text-align: right;">
                           @if(session('gift_coupon_discount'))
    <p>Nuolaida: -{{ session('gift_coupon_discount') }} € (kuponas)</p>
@endif
<h4 style="font-weight: normal; font-size: 1rem;">Viso: <span id="total-cost">{{ $totalPrice }}</span> €</h4>

                        </div>

                        <!-- Checkout button -->
                        <a  href="#" class="btn btn-dark w-100 mt-4" onclick="return validateCheckout()" id="checkout-button" style="pointer-events: none; opacity: 0.5;">Tęsti atsiskaitymą</a>

                        <!-- Order reservation (prisijungusiems) -->
                        <div class="text-center">
                        @auth
                            <div id="reservation-section" style="display: none;">
                                <form action="{{ route('order.reserve') }}" method="POST">
                                    @csrf
                                    <input type="hidden" name="total_price" id="hidden-total-price" value="{{ $totalPrice }}">
                                    <input type="hidden" id="delivery-city" name="delivery_city" value="">
                                    <input type="hidden" name="first_name" id="hidden-first-name" value="">
                                    <input type="hidden" name="last_name" id="hidden-last-name" value="">
                                    <input type="hidden" name="phone" id="hidden-phone" value="">
                                    <input type="hidden" name="email" id="hidden-email" value="">
                                    <input type="hidden" name="delivery_address" id="hidden-delivery-address" value="">
                                    <input type="hidden" name="postal_code" id="hidden-postal-code" value="">
                                    <input type="hidden" name="delivery_date" id="hidden-delivery-date" value="">
                                    <input type="hidden" name="delivery_time" id="hidden-delivery-time" value="">
                                    <input type="hidden" name="notes" id="hidden-notes" value="">
                                    <input type="hidden" name="delivery_video" id="hidden-video" value="">
                                    <button type="submit" class="btn btn-success mt-3" id="reserve-order-btn" disabled onclick="return validateCheckout()">
                                        Rezervuoti užsakymą
                                    </button>

                                    <p class="mt-3" style="font-size: 1.1rem;">Rezervacijos laikas 30 min</p>
                                </form>
                            </div>

                            <div id="subscription-warning" class="alert alert-danger mt-3" style="display: none;">
                                Krepšelyje yra prenumerata. Prenumeratų rezervuoti negalima.<br>
                                Pašalinkite prenumeratą, jei norite rezervuoti kitus produktus.
                            </div>
                        @else
                            <p class="mt-3" style="font-size: 1.1rem;">
                                Jei norite rezervuoti ar nusipirkti prekę, prašome 
                                <a href="{{ route('login') }}" class="text-success">prisijungti</a> 
                                arba 
                                <a href="{{ route('register') }}" class="text-success">užsiregistruoti</a>.
                            </p>
                        @endauth

                            </div>


                        </div>
                    </div>
                </div>
            </div>

            @php
    $hasSubscription = collect($cart)->contains(function ($item) {
        return isset($item['type']) && $item['type'] === 'subscription';
    });
@endphp

<script>
    let totalPrice = @json($totalPrice); 
    let cartHasSubscription = @json($hasSubscription);

    function updateShippingCost() {
    const citySelect = document.getElementById('delivery-city-select');
    const city = citySelect.value;
    const firstName = document.getElementById('first-name').value;
    const lastName = document.getElementById('last-name').value;
    const phone = document.getElementById('phone').value;
    const email = document.getElementById('email').value;
    const deliveryAddress = document.getElementById('delivery_address').value;
    const postalCode = document.getElementById('postal-code').value;
    const deliveryDate = document.getElementById('delivery_date').value;
    const deliveryTime = document.getElementById('delivery_time').value;
    const notes = document.getElementById('notes').value;

    const shippingCost = parseInt(city || 0);
    const videoCheckbox = document.getElementById('delivery-video');
    const videoCost = videoCheckbox && videoCheckbox.checked ? 5 : 0;
    document.getElementById('hidden-video').value = videoCheckbox.checked ? 1 : 0;

    const updatedTotal = totalPrice + shippingCost + videoCost;

    document.getElementById('shipping-cost').textContent = shippingCost;
    document.getElementById('total-cost').textContent = updatedTotal;

    document.getElementById('hidden-total-price').value = updatedTotal;
    document.getElementById('delivery-city').value = city;
    document.getElementById('hidden-first-name').value = firstName;
    document.getElementById('hidden-last-name').value = lastName;
    document.getElementById('hidden-phone').value = phone;
    document.getElementById('hidden-email').value = email;
    document.getElementById('hidden-delivery-address').value = deliveryAddress;
    document.getElementById('hidden-postal-code').value = postalCode;
    document.getElementById('hidden-delivery-date').value = deliveryDate;
    document.getElementById('hidden-delivery-time').value = deliveryTime;
    document.getElementById('hidden-notes').value = notes;

    const checkoutButton = document.getElementById('checkout-button');
    checkoutButton.href = `/checkout?total=${updatedTotal}&city=${city}&first_name=${firstName}&last_name=${lastName}&phone=${phone}&email=${email}&delivery_address=${deliveryAddress}&postal_code=${postalCode}&delivery_date=${deliveryDate}&delivery_time=${deliveryTime}&notes=${notes}&delivery_video=${document.getElementById('hidden-video').value}`;

    const allFieldsFilled = firstName && lastName && phone && email && deliveryAddress && postalCode && city && deliveryDate && deliveryTime;

    checkoutButton.style.pointerEvents = allFieldsFilled ? 'auto' : 'none';
    checkoutButton.style.opacity = allFieldsFilled ? '1' : '0.5';

    const reserveBtn = document.getElementById('reserve-order-btn');
    if (reserveBtn) {
        reserveBtn.disabled = cartHasSubscription;
    }

    const reservationSection = document.getElementById('reservation-section');
    const subscriptionWarning = document.getElementById('subscription-warning');
    if (reservationSection && subscriptionWarning) {
        reservationSection.style.display = cartHasSubscription ? 'none' : 'block';
        subscriptionWarning.style.display = cartHasSubscription ? 'block' : 'none';
    }
}


    function validateCheckout() {
        const requiredFields = [
            { id: 'first-name', message: 'Įveskite vardą' },
            { id: 'last-name', message: 'Įveskite pavardę' },
            { id: 'phone', message: 'Įveskite telefoną' },
            { id: 'email', message: 'Įveskite el. paštą' },
            { id: 'delivery_address', message: 'Įveskite pristatymo adresą' },
            { id: 'postal-code', message: 'Įveskite pašto kodą' },
            { id: 'delivery-city-select', message: 'Pasirinkite miestą' },
            { id: 'delivery_date', message: 'Pasirinkite pristatymo datą' },
            { id: 'delivery_time', message: 'Pasirinkite pristatymo laiką' },
        ];

        let isValid = true;

        document.querySelectorAll('.error-text').forEach(e => e.remove());
        requiredFields.forEach(field => {
            const input = document.getElementById(field.id);
            input.classList.remove('field-error');
        });

        for (const field of requiredFields) {
            const input = document.getElementById(field.id);
            if (!input || !input.value.trim()) {
                input.classList.add('field-error');
                const errorMsg = document.createElement('div');
                errorMsg.className = 'error-text';
                errorMsg.textContent = field.message;
                input.parentElement.appendChild(errorMsg);
                isValid = false;
            }
        }

        return isValid;
    }

    window.addEventListener('DOMContentLoaded', function () {
        updateShippingCost();

        const fieldsToWatch = [
            'first-name', 'last-name', 'phone', 'email',
            'delivery_address', 'postal-code', 'delivery_date', 'delivery_time',
            'delivery-city-select'
        ];

        fieldsToWatch.forEach(id => {
            const el = document.getElementById(id);
            if (el) {
                el.addEventListener('change', updateShippingCost);
                el.addEventListener('input', updateShippingCost);
            }
        });

        const videoCheckbox = document.getElementById('delivery-video');
        if (videoCheckbox) {
            videoCheckbox.addEventListener('change', updateShippingCost);
        }

        flatpickr("#delivery_date", {
            dateFormat: "Y-m-d",
            minDate: new Date().fp_incr(2),
            disable: [
                function(date) {
                    return date.getDay() === 0;
                }
            ],
            locale: {
                firstDayOfWeek: 1
            }
        });
    });
</script>


      @endif
      </div>

@endsection

