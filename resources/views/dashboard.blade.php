@extends('layouts.app')

@section('title', 'Paskyros skydelis')

@section('content')
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray">
                <h1 class="display-4 fw-bolder">Paskyra</h1>
                <p class="lead fw-normal text-dark-gray mb-0">Pradžia</p>
            </div>
        </div>
    </header>

    <div class="container my-5">
        <div class="row">
            <div class="col-md-3">
                <div class="p-5 mb-3 bg-white border text-center text-gray" style="border-radius: 0;">
                    <h5 class="mb-0">{{ Auth::user()->name }}</h5>
                </div>
                <div class="list-group">
                    <a href="/dashboard" class="list-group-item list-group-item-action active" style="border-radius: 0;">
                        <i class="far fa-tachometer-alt"></i> Skydelis
                    </a>
                    <a href="/orders" class="list-group-item list-group-item-action" style="border-radius: 0;">
                        <i class="far fa-clipboard-list"></i> Užsakymai
                    </a>
                    <a href="{{ route('subscriptions.index') }}" class="list-group-item list-group-item-action" style="border-radius: 0;">
                        <i class="fas fa-download"></i> Prenumeratos
                    </a>
                    <a href="/addresses" class="list-group-item list-group-item-action" style="border-radius: 0;">
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
                <div class="row g-3">
                    <div class="col-md-12">
                        <div class="p-3 mb-3 bg-white border text-center">
                            <h4 class="mb-0">Sveiki atvykę, {{ Auth::user()->name }}! Jūsų paskyra paruošta.</h4>
                        </div>
                    </div>

                    <div class="col-md-4">
                        <a href="/orders" class="text-decoration-none text-dark">
                            <div class="card text-center border" style="border-radius: 0;">
                                <div class="card-body">
                                    <i class="far fa-clipboard-list fa-3x text-muted"></i>
                                    <h5 class="card-title mt-3">Užsakymai</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="#" class="text-decoration-none text-dark">
                            <div class="card text-center border" style="border-radius: 0;">
                                <div class="card-body">
                                    <i class="far fa-download fa-3x text-muted"></i>
                                    <h5 class="card-title mt-3">Prenumeratos</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="/addresses" class="text-decoration-none text-dark">
                            <div class="card text-center border" style="border-radius: 0;">
                                <div class="card-body">
                                    <i class="far fa-map-marker-alt fa-3x text-muted"></i>
                                    <h5 class="card-title mt-3">Paskyros suvestinė</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="{{ route('profile.show') }}" class="text-decoration-none text-dark">
                            <div class="card text-center border" style="border-radius: 0;">
                                <div class="card-body">
                                    <i class="far fa-user fa-3x text-muted"></i>
                                    <h5 class="card-title mt-3">Vartotojo informacija</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                    <div class="col-md-4">
                        <a href="#" class="text-decoration-none text-dark logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                            <div class="card text-center border" style="border-radius: 0;">
                                <div class="card-body">
                                    <i class="fas fa-sign-out-alt fa-3x text-muted"></i>
                                    <h5 class="card-title mt-3">Atsijungti</h5>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
