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
                <a href="/dashboard" class="list-group-item list-group-item-action" style="border-radius: 0;">
                    <i class="far fa-tachometer-alt"></i> Skydelis
                </a>
                <a href="/orders" class="list-group-item list-group-item-action active" style="border-radius: 0;">
                    <i class="far fa-clipboard-list"></i> Užsakymai
                </a>
                <a href="{{ route('subscriptions.index') }}" class="list-group-item list-group-item-action" style="border-radius: 0;">
                    <i class="fas fa-download"></i> Prenumeratos
                </a>
                <a href="#" class="list-group-item list-group-item-action" style="border-radius: 0;">
                    <i class="far fa-map-marker-alt"></i> Adresai
                </a>
                <a href="{{ route('profile.show') }}" class="list-group-item list-group-item-action" style="border-radius: 0;">
                    <i class="far fa-user"></i> Vartotojo informacija
                </a>
                <a href="#" class="list-group-item list-group-item-action logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="border-radius: 0;">
                    <i class="fas fa-sign-out-alt"></i> Atsijungti
                    </a>
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

                    @if($orders->isEmpty())
                        <div class="alert alert-info mb-0 text-center">
                            Šiuo metu neturite užsakymų. 🌸
                            <br>
                            Apsilankykite <a href="{{ route('catalog.index') }}">gėlių kataloge</a> ir išsirinkite gėlių!
                        </div>
                    @else
                    <div class="row">
                    @foreach($orders as $order)
                    <div class="col-md-12 mb-4">
                                <div class="card-glass p-4">
                                    <!-- Ribbon -->
                                    <div class="ribbon {{ $order->status }}">
                                        @switch($order->status)
                                            @case('rezervuotas')
                                                <i class="fas fa-clock"></i>
                                                @break
                                            @case('apmokėtas')
                                                <i class="fas fa-euro-sign"></i>
                                                @break
                                            @case('pristatytas')
                                                <i class="fas fa-truck"></i>
                                                @break
                                            @case('atšauktas')
                                                <i class="fas fa-times-circle"></i>
                                                @break
                                            @default
                                                <i class="fas fa-info-circle"></i>
                                        @endswitch
                                        {{ ucfirst($order->status) }}
                                    </div>
                                
                                    <h5>
                                        Užsakymo ID: 
                                        <a href="{{ route('orders.show', $order->id) }}" class="text-success">#{{ $order->id }}</a>
                                    </h5>

                                    <p class="mb-1">
                                        <strong>Pristatymo miestas:</strong>
                                        @if($order->delivery_city == 7)
                                            Vilnius
                                        @elseif($order->delivery_city == 10)
                                            Kaunas
                                        @else
                                            Nenurodytas miestas
                                        @endif
                                    </p>

                                    @if($order->status === 'rezervuotas')
                                        <p class="mb-1"><strong>Rezervacijos laikas:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                                    @endif

                                    @if ($order->cancel_reason)
                                        <p class="mb-1"><strong>Priežastis:</strong> {{ $order->cancel_reason }}</p>
                                    @endif

                                    <p class="mb-2"><strong>Kaina:</strong> {{ $order->total_price }} €</p>

                                    <a href="{{ route('orders.show', $order->id) }}" class="btn btn-outline-success btn-sm">Peržiūrėti detales</a>
                                    @if($order->status === 'pristatytas' && !$order->review)
                                <a href="{{ route('reviews.create', $order->id) }}" class="btn btn-sm btn-outline-primary mt-2">Rašyti atsiliepimą</a>
                            @endif
                                </div>
                            </div>

                    @endforeach
                    </div>

                        </div>
                    @endif

        </div>
    </div>
</div>
@endsection
