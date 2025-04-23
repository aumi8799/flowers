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
                <table class="table">
                    <thead>
                        <tr>
                            <th>Prekė</th>
                            <th></th>
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
                                <td class="align-middle item-total">{{ $item->price * $item->quantity }} €</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="col-md-4">
                <div class="border p-3 rounded">
                    <h2>Užsakymo ID: #{{ $order->id }}</h2>
                    <hr>
                    <h5 style="font-weight: normal; font-size: 1rem;">Būsena:</h5>
                        <div class="mb-3">
                            <strong>{{ $order->status }}</strong>
                        </div>
                    <hr>
                    <h5 style="font-weight: normal; font-size: 1rem;">Rezervacijos laikas:</h5>
                        <div class="mb-3">
                            <strong>{{ $order->created_at->format('Y-m-d H:i:s') }}</strong>
                        </div>
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
                            <option value="" disabled selected>Pasirinkite miestą</option>
                            <option value="7" {{ $order->delivery_city == 'Vilnius' ? 'selected' : '' }}>Vilnius - 7 €</option>
                            <option value="10" {{ $order->delivery_city == 'Kaunas' ? 'selected' : '' }}>Kaunas - 10 €</option>
                        </select>
                        <label for="delivery_address" class="form-label">Adresas</label>
                        <input type="text" name="delivery_address" id="delivery_address" value="{{ $order->delivery_address }}" class="form-control">

                        <label for="postal_code" class="form-label mt-2">Pašto kodas</label>
                        <input type="text" name="postal_code" id="postal_code" value="{{ $order->postal_code }}" class="form-control">

                        <div>
                        <strong>Pristatymo kaina: <span id="shipping-cost">0</span> €</strong>
                    </div>

                    </div>

                    <div style="text-align: right;">
                            <h5 style="font-weight: normal; font-size: 1rem;">Bendra suma: <span id="totalPrice"> </span></h5>
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

    const shipping = parseFloat(shippingCostElement.innerText) || 0;
    const videoFee = deliveryVideoCheckbox && deliveryVideoCheckbox.checked ? 5 : 0;

    totalPriceElement.innerText = (total + shipping + videoFee).toFixed(2) + ' €';
}

function updateShippingCost() {
    const selectedValue = parseFloat(citySelect.value) || 0;
    shippingCostElement.innerText = selectedValue.toFixed(2);
    updateTotal();
}

// Priskirti event'us
quantityInputs.forEach(input => {
    input.addEventListener('input', updateTotal);
});

if (deliveryVideoCheckbox) {
    deliveryVideoCheckbox.addEventListener('change', updateTotal);
}

if (citySelect) {
    citySelect.addEventListener('change', updateShippingCost);
}

document.addEventListener('DOMContentLoaded', () => {
    updateShippingCost(); // įkelia pristatymo kainą
    updateTotal(); // paskaičiuoja pradinę bendrą sumą
});

</script>

@endsection
