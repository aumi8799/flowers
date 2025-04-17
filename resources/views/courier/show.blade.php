@extends('layouts.app')

@section('title', 'Užduoties peržiūra')

@section('content')

<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Užduoties #{{ $order->id }} peržiūra</h1>
        </div>
    </div>
</header>

<div class="container my-5">
    <h2>Užsakymo informacija</h2>
    <div class="card mb-4">
        <div class="card-body">
            <p><strong>Užsakymo ID:</strong> {{ $order->id }}</p>
            <p><strong>Užsakovo vardas:</strong> {{ $order->user->name }}</p>
            <p><strong>Pristatymo miestas:</strong>          
                             @if($order->delivery_city == 7)
                                Vilnius
                            @elseif($order->delivery_city == 10)
                                Kaunas
                            @else
                                Nenurodytas miestas
                            @endif
                        </p>
            <p><strong>Bendra suma:</strong> {{ $order->total_price }}€</p>
            <p><strong>Statusas:</strong> {{ $order->status }}</p>
        </div>
    </div>

    <h4>Prekės</h4>
    <table class="table">
        <thead>
            <tr>
                <th>Prekė</th>
                <th>Kiekis</th>
                <th>Kaina</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}€</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <a href="/courier/tasks" class="btn btn-secondary">Grįžti</a>
    @if($order->status != 'pristatytas')
    <form action="{{ route('order.delivered', $order->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-success">Pažymėti kaip pristatytą</button>
    </form>
@endif

</div>
@endsection
