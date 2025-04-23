@extends('layouts.app')

@section('title', 'Prenumeratos')

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
                <a href="/orders" class="list-group-item list-group-item-action" style="border-radius: 0;">
                    <i class="far fa-clipboard-list"></i> Užsakymai
                </a>
                <a href="{{ route('subscriptions.index') }}" class="list-group-item list-group-item-action active" style="border-radius: 0;">
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
    <h2>Mano prenumeratos</h2>

    @if($subscriptions->isEmpty())
        <div class="alert alert-info mb-0 text-center">
            Šiuo metu neturite aktyvių prenumeratų. 🌸
            <br>
            Apsilankykite <a href="{{ route('catalog.index') }}">kataloge</a> ir užsisakykite prenumeratą!
        </div>
    @else
        <div class="row">
            @foreach($subscriptions as $subscription)
            <div class="col-md-12 mb-4">
                <div class="card-glass p-4">
                    <!-- Ribbon -->
                    <div class="ribbon {{ $subscription->status }}">
                        @switch($subscription->status)
                            @case('aktyvi')
                                <i class="fas fa-check-circle"></i>
                                @break
                            @case('pasibaigus')
                                <i class="fas fa-calendar-times"></i>
                                @break
                            @default
                                <i class="fas fa-info-circle"></i>
                        @endswitch
                        {{ ucfirst($subscription->status) }}
                    </div>

                    <h5>
                        Prenumeratos ID: 
                        <a href="" class="text-success">#{{ $subscription->id }}</a>
                    </h5>

                    <p class="mb-1">
                        <strong>Kategorija:</strong> {{ $subscription->category }}
                    </p>

                    <p class="mb-1">
                        <strong>Dydis:</strong> {{ $subscription->size }}
                    </p>

                    <p class="mb-1">
                        <strong>Trukmė:</strong> {{ $subscription->duration }} mėnesiai
                    </p>

                    <p class="mb-2">
                        <strong>Kaina:</strong> €{{ $subscription->price }}
                    </p>

    
                    <a href="" class="btn btn-outline-success btn-sm">Peržiūrėti detales</a>
                </div>
            </div>
            @endforeach
        </div>
    @endif
</div>

    </div>
</div>
@endsection
