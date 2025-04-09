@extends('layouts.app')

@section('title', 'Užsakymai')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Užsakymai</h1>
        </div>
    </div>
</header>

<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            <div class="p-5 mb-3 bg-white border text-center text-gray" style="border-radius: 0;">
                <h5 class="mb-0">Sveiki, {{ Auth::user()->name }}!</h5>
            </div>
            <div class="list-group">
                <a href="/dashboard" class="list-group-item list-group-item-action">Skydelis</a>
                <a href="/orders" class="list-group-item list-group-item-action active">Užsakymai</a>
                <a href="#" class="list-group-item list-group-item-action">Atsisiuntimai</a>
                <a href="/addresses" class="list-group-item list-group-item-action">Adresai</a>
                <a href="{{ route('profile.show') }}" class="list-group-item list-group-item-action">Vartotojo informacija</a>
                <a href="#" class="list-group-item list-group-item-action logout-link"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">Atsijungti</a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <div class="col-md-9">
        <h2>Mano užsakymai</h2>

<form method="GET" action="{{ route('orders.index') }}" class="mb-4">
    <label for="status">Filtruoti pagal būseną:</label>
    <select name="status" id="status" onchange="this.form.submit()" class="form-select w-auto d-inline-block">
        <option value="">Visi</option>
        <option value="rezervuotas" {{ request('status') == 'rezervuotas' ? 'selected' : '' }}>Rezervuotas</option>
        <option value="apmokėtas" {{ request('status') == 'apmokėtas' ? 'selected' : '' }}>Apmokėtas</option>
        <option value="pristatytas" {{ request('status') == 'pristatytas' ? 'selected' : '' }}>Pristatytas</option>
        <option value="atšauktas" {{ request('status') == 'atšauktas' ? 'selected' : '' }}>Atšauktas</option>
    </select>
</form>

<div class="list-group">
    @foreach($orders as $order)
        <div class="list-group-item">
            <h5>Užsakymo ID: #{{ $order->id }}</h5>
            <p>Pristatymo miestas: {{ $order->delivery_city }}</p>
            <p>Būsena: {{ $order->status }}</p>
            <p>Kaina: {{ $order->total_price }} €</p>
            <p>Data: {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
        </div>
    @endforeach
</div>
        </div>
    </div>
</div>
@endsection
