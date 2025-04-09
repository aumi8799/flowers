@extends('layouts.app')

@section('title', 'Užsakymo detalės')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Užsakymo #{{ $order->id }} detalės</h1>
        </div>
    </div>
</header>

    <div class="container my-5">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(empty($order))
            <div class="text-center my-5">
                <img src="{{ asset('images/order-empty.png') }}" alt="Tuščias užsakymas" class="img-fluid" style="max-width: 150px;">
                <p class="mt-3">Nėra užsakymo #{{ $order->id }}informacijos</p>
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
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalPrice = 0;
                            @endphp

                            @foreach($order->items as $item)
                                @php
                                    $itemTotal = $item->price * $item->quantity;
                                    $totalPrice += $itemTotal;
                                @endphp
                                <tr>
                                    <td>
                                        <img src="{{ asset('images/products/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid" style="max-width: 80px; height: 80px;">
                                    </td>
                                    <td class="align-middle">{{ $item->product->name }}</td>
                                    <td class="align-middle">{{ $item->quantity }}</td>
                                    <td class="align-middle">{{ $itemTotal }} €</td>
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
                        <h5 style="font-weight: normal; font-size: 1rem;">Pristatymo miestas:</h5>
                        <div class="mb-3">
                            <strong>  
                                @if($order->delivery_city == 7)
                                    Vilnius
                                @elseif($order->delivery_city == 10)
                                    Kaunas
                                @else
                                    Nenurodytas miestas
                                @endif
                            </strong>
                        </div>
                        <hr>
                        <div>
                            <h5 style="font-weight: normal; font-size: 1rem;">Viso: <span>{{ $totalPrice }} €</span></h5>
                        </div>
                        <hr>
                        <div style="text-align: left;">
                            <h4 style="font-weight: normal; font-size: 1rem;">Rezervacijos laikas: <span>{{ $order->created_at->format('Y-m-d H:i:s') }}</span></h4>
                        </div>
                        <div class="d-flex justify-content-end gap-2 mt-4">
                            <form action="" method="">
                                <button type="submit" class="btn btn-dark ">Redaguoti</button>
                            </form>
                            <form action="" method="">
                                <button type="submit" class="btn btn-danger">Atšaukti rezervaciją</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        @endif
    </div>
@endsection
