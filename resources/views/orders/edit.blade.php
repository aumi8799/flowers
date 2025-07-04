@extends('layouts.app')

@section('title', 'Redaguoti užsakymą')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Redaguoti užsakymą #{{ $order->id }}</h1>
        </div>
    </div>
</header>

<div class="container my-5">
    @if(session('error'))
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <form action="{{ route('orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="row">
        <div class="col-md-8">
    {{-- Produktai --}}
    @if($order->items->count())
        <h5 class="mt-4 text-primary">
            <i class="fas fa-shopping-basket me-2"></i> Produktai
        </h5>
        <div class="bg-light p-3 mb-4 rounded border border-primary shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-primary">
                        <tr>
                            <th>Prekė</th>
                            <th>Pavadinimas</th>
                            <th>Kiekis</th>
                            <th>Suma</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->items as $item)
                            <tr>
                                <td>
                                    <img src="{{ asset('images/products/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid" style="max-width: 80px; height: 80px;">
                                </td>
                                <td class="align-middle">{{ $item->product->name }}</td>
                                <td class="align-middle">
                                    <input type="number" name="quantities[{{ $item->id }}]" value="{{ $item->quantity }}" min="1" class="form-control quantity-input" data-price="{{ $item->price }}" style="width: 80px;">
                                </td>
                                <td class="align-middle item-total">{{ number_format($item->price * $item->quantity, 2) }} €</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    {{-- Individualios puokštės --}}
    @if($order->bouquets->count())
        <h5 class="mt-4 text-warning">
            <i class="fas fa-seedling me-2"></i> Individualios puokštės
        </h5>
        <div class="bg-light p-3 mb-4 rounded border border-warning shadow-sm">
            <div class="table-responsive">
                <table class="table table-hover align-middle">
                    <thead class="table-warning">
                        <tr>
                            <th>Sudėtis</th>
                            <th>Kiekis</th>
                            <th>Suma</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->bouquets as $bouquet)
                            @php
                                $bouquetItems = json_decode($bouquet->bouquet_data, true);
                            @endphp
                            <tr>
                                <td class="align-middle">
                                    @foreach($bouquetItems as $flower)
                                        - {{ $flower['name'] }} ({{ $flower['quantity'] }} vnt.)<br>
                                    @endforeach
                                </td>
                                <td class="align-middle">1</td>
                                <td class="align-middle bouquet-total" data-price="{{ $bouquet->total_price }}">
                                    {{ number_format($bouquet->total_price, 2) }} €
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>


            <div class="col-md-4">
                <div class="border p-3 rounded">
                    <h2>Užsakymo ID: #{{ $order->id }}</h2>
                    <hr>
                    <h5 style="font-weight: normal; font-size: 1rem;">Būsena:</h5>
                    <div class="mb-3"><strong>{{ $order->status }}</strong></div>
                    <hr>
                    <h5 style="font-weight: normal; font-size: 1rem;">Rezervacijos laikas:</h5>
                    <div class="mb-3"><strong>{{ $order->created_at->format('Y-m-d H:i:s') }}</strong></div>
                    <hr>
                    <h5 style="font-weight: normal; font-size: 1rem;">Pirkėjo informacija:</h5>
                    <div class="mb-3">
                        <label for="first_name" class="form-label">Vardas</label>
                        <input type="text" name="first_name" id="first_name" value="{{ $order->first_name }}" class="form-control">

                        <label for="last_name" class="form-label mt-2">Pavardė</label>
                        <input type="text" name="last_name" id="last_name" value="{{ $order->last_name }}" class="form-control">

                        <label for="phone" class="form-label mt-2">Telefono numeris</label>
                        <input type="text" name="phone" id="phone" value="{{ $order->phone }}" class="form-control">

                        <label for="email" class="form-label mt-2">El. paštas</label>
                        <input type="email" name="email" id="email" value="{{ $order->email }}" class="form-control">
                    </div>
                    <hr>
                    <h5 style="font-weight: normal; font-size: 1rem;">Papildoma informacija:</h5>
                    <div class="mb-3">
                        <label for="notes" class="form-label mt-2">Pastabos</label>
                        <textarea name="notes" id="notes" class="form-control">{{ $order->notes }}</textarea>
                    </div>
                    <h5 style="font-weight: normal; font-size: 1rem;">Vaizdo įrašas:</h5>
                    <div class="form-check">
                        <input type="checkbox" name="video" id="video" value="1" {{ $order->video == 1 ? 'checked' : '' }} class="form-check-input">
                        <label class="form-check-label" for="video">Noriu gauti pristatymo vaizdo įrašą (+5 eurų)</label>
                    </div>
                    <hr>
                    <h5 style="font-weight: normal; font-size: 1rem;">Pristatymo adresas:</h5>
                    <div class="mb-3">
                        <select class="form-select" id="delivery-city-select" name="delivery_city" onchange="updateShippingCost()">
                            <option value="" disabled>Pasirinkite miestą</option>
                            <option value="7" {{ $order->delivery_city == 7 ? 'selected' : '' }}>Vilnius - 7 €</option>
                            <option value="10" {{ $order->delivery_city == 10 ? 'selected' : '' }}>Kaunas - 10 €</option>
                        </select>
                        <label for="delivery_address" class="form-label mt-2">Adresas</label>
                        <input type="text" name="delivery_address" id="delivery_address" value="{{ $order->delivery_address }}" class="form-control">

                        <label for="postal_code" class="form-label mt-2">Pašto kodas</label>
                        <input type="text" name="postal_code" id="postal_code" value="{{ $order->postal_code }}" class="form-control">

                        <div>
                            <strong>Pristatymo kaina: <span id="shipping-cost">0</span> €</strong>
                        </div>
                    </div>
                    <label for="delivery_date" class="form-label mt-2">Pristatymo data</label>
                    <input type="text" name="delivery_date" id="delivery_date" class="form-control" value="{{ $order->delivery_date }}" required>

                    <label for="delivery_time" class="form-label mt-2">Pageidaujamas pristatymo laikas</label>
                    <select name="delivery_time" id="delivery_time" class="form-select" required>
                        <option value="">Pasirinkite laiką</option>
                        <option value="10:00 - 12:00" {{ $order->delivery_time == '10:00 - 12:00' ? 'selected' : '' }}>10:00 – 12:00</option>
                        <option value="12:00 - 15:00" {{ $order->delivery_time == '12:00 - 15:00' ? 'selected' : '' }}>12:00 – 15:00</option>
                        <option value="15:00 - 18:00" {{ $order->delivery_time == '15:00 - 18:00' ? 'selected' : '' }}>15:00 – 18:00</option>
                    </select>
                    <hr>
                    <div style="text-align: right;">
                        <h5 style="font-weight: normal; font-size: 1rem;">Bendra suma: <span id="totalPrice"></span></h5>
                    </div>

                    <div class="d-flex justify-content-end gap-2 mt-4">
                        <button type="submit" class="btn btn-success">Išsaugoti pakeitimus</button>
                        <a href="{{ route('orders.show', $order->id) }}" class="btn btn-secondary">Grįžti</a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

<script>
    const quantityInputs = document.querySelectorAll('.quantity-input');
    const totalPriceElement = document.getElementById('totalPrice');
    const shippingCostElement = document.getElementById('shipping-cost');
    const citySelect = document.getElementById('delivery-city-select');
    const deliveryVideoCheckbox = document.getElementById('video');

    function updateTotal() {
        let total = 0;

        quantityInputs.forEach(input => {
            const qty = parseInt(input.value);
            const price = parseFloat(input.dataset.price);
            if (!isNaN(qty) && !isNaN(price)) {
                const itemTotal = qty * price;
                total += itemTotal;
                input.closest('tr').querySelector('.item-total').innerText = itemTotal.toFixed(2) + ' €';
            }
        });

        // Įtraukiam individualias puokštes
        document.querySelectorAll('.bouquet-total').forEach(el => {
            const price = parseFloat(el.dataset.price);
            if (!isNaN(price)) {
                total += price;
            }
        });

        const shipping = parseFloat(shippingCostElement.innerText) || 0;
        const videoFee = deliveryVideoCheckbox && deliveryVideoCheckbox.checked ? 5 : 0;

        totalPriceElement.innerText = (total + shipping + videoFee).toFixed(2) + ' €';
    }

    function updateShippingCost() {
        const selectedValue = parseFloat(citySelect.value) || 0;
        shippingCostElement.innerText = selectedValue.toFixed(2);
        updateTotal();
    }

    quantityInputs.forEach(input => {
        input.addEventListener('input', updateTotal);
    });

    if (deliveryVideoCheckbox) {
        deliveryVideoCheckbox.addEventListener('change', updateTotal);
    }

    if (citySelect) {
        citySelect.addEventListener('change', updateShippingCost);
    }
    document.addEventListener('DOMContentLoaded', function () {
        flatpickr("#delivery_date", {
            dateFormat: "Y-m-d",
            minDate: new Date().fp_incr(2),
            disable: [
                function(date) {
                    return date.getDay() === 0; // Neleisti sekmadienių
                }
            ],
            locale: {
                firstDayOfWeek: 1
            }
        });
    });
    document.addEventListener('DOMContentLoaded', () => {
        updateShippingCost();
        updateTotal();
    });
</script>
@endsection
