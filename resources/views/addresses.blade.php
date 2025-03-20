@extends('layouts.app')

@section('title', 'Adresai')

@section('content')
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Adresai</h1>
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
                <a href="#" class="list-group-item list-group-item-action" style="border-radius: 0;">
                    <i class="fas fa-download"></i> Atsisiuntimai
                </a>
                <a href="#" class="list-group-item list-group-item-action active" style="border-radius: 0;">
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

@endsection
