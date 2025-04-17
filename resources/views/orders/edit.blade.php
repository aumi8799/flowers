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
                    <h5>Pristatymo išlaidos:</h5>
                    <div class="mb-3">
                        <select class="form-select" id="delivery-city-select" name="delivery_city" onchange="updateShippingCost()">
                            <option value="" disabled selected>Pasirinkite miestą</option>
                            <option value="7" {{ $order->delivery_city == 'Vilnius' ? 'selected' : '' }}>Vilnius - 7 €</option>
                            <option value="10" {{ $order->delivery_city == 'Kaunas' ? 'selected' : '' }}>Kaunas - 10 €</option>
                        </select>
                    </div>
                    <div>
                        <strong>Pristatymo kaina: <span id="shipping-cost">0</span> €</strong>
                    </div>
                    <hr>
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
        totalPriceElement.innerText = (total + shipping).toFixed(2) + ' €';
    }

    function updateShippingCost() {
        const selectedValue = parseFloat(citySelect.value) || 0;
        shippingCostElement.innerText = selectedValue.toFixed(2);
        updateTotal();
    }

    // Kiekvienam inputui priskirti change listenerį
    quantityInputs.forEach(input => {
        input.addEventListener('input', updateTotal);
    });

    // Kai puslapis užsikrauna
    document.addEventListener('DOMContentLoaded', () => {
        updateShippingCost(); // automatiškai įkelia pristatymo kainą ir atnaujina total
    });
</script>
@endsection
