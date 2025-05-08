@extends('layouts.app')

@section('title', 'Paskyros suvestinė')

@section('content')
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Paskyros suvestinė</h1>
            <p class="lead fw-normal text-dark-gray mb-0"></p>
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
                <a href="{{ route('subscriptions.index') }}" class="list-group-item list-group-item-action" style="border-radius: 0;">
                    <i class="fas fa-download"></i> Prenumeratos
                </a>
                <a href="#" class="list-group-item list-group-item-action active" style="border-radius: 0;">
                    <i class="far fa-map-marker-alt"></i> Paskyros suvestinė
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
    <div class="mb-4">
        <h4 class="fw-bold">Jūsų paskyros apžvalga</h4>
        <p class="text-muted">
            Čia galite matyti visą savo veiklos suvestinę: kiek užsakymų esate pateikę, kiek lojalumo taškų sukaupėte bei kiek atsiliepimų parašėte. 
            Sekite savo progresą ir pasinaudokite privilegijomis ateities pirkiniuose!
        </p>
    </div>

    <div class="row text-center">
        <div class="col-md-4 mb-4">
            <div class="p-4 bg-white border rounded shadow-sm h-100">
                <h6 class="text-uppercase text-muted">Lojalumo taškai</h6>
                <p class="fs-3 fw-bold text-success mb-0">{{ $totalPoints }}</p>
                <small>Viso sukaupta taškų</small>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="p-4 bg-white border rounded shadow-sm h-100">
                <h6 class="text-uppercase text-muted">Užsakymai</h6>
                <p class="fs-3 fw-bold mb-0">{{ $ordersCount }}</p>
                <small>Atliktų užsakymų skaičius</small>
            </div>
        </div>

        <div class="col-md-4 mb-4">
            <div class="p-4 bg-white border rounded shadow-sm h-100">
                <h6 class="text-uppercase text-muted">Atsiliepimai</h6>
                <p class="fs-3 fw-bold mb-0">{{ $reviewsCount }}</p>
                <small>Parašytų atsiliepimų</small>
            </div>
        </div>
    </div>
</div>

@endsection
