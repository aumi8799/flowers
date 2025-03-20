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
            <table class="table">
                <thead>
                    <tr>
                        <th></th>
                        <th>Prekė</th>
                        <th>Kaina</th>
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
                            <td class="align-middle">{{ $item['price'] }} €</td>
                            <td class="align-middle">{{ $item['quantity'] }}</td>
                            <td class="align-middle">{{ $itemTotal }} €</td>
                            <td class="align-middle">
                                <form action="{{ route('cart.remove', $id) }}" method="POST" style="display: inline;">
                                    @csrf
                                    <button type="submit"  style="background: none; border: none; padding: 0;">
                                        <img src="{{ asset('images/trash-icon.png') }}" alt="Šiukšlių dėžė" style="width: 20px; height: 20px;">
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>

            <div class="d-flex justify-content-between">
                <h4>Suma: {{ $totalPrice }} €</h4>
                <form action="{{ route('cart.clear') }}" method="POST">
                    @csrf
                    <button type="submit" class="btn btn-warning">Ištuštinti krepšelį</button>
                </form>
            </div>
        @endif
    </div>

@endsection
