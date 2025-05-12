@extends('layouts.app')

@section('title', 'Administratoriaus valdymo skydelis')

@section('content')
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray">
                <h1 class="display-4 fw-bolder">Administratoriaus valdymo skydelis</h1>

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
                <a href="/dashboard" class="list-group-item list-group-item-action active" style="border-radius: 0;">
                    <i class="fas fa-tachometer-alt me-2"></i> Skydelis
                </a>
                <a href="/admin/users" class="list-group-item list-group-item-action logout-link" style="border-radius: 0;">
                <i class="fas fa-users me-2"></i> Vartotojai 
                </a>
                <a href="/admin/orders" class="list-group-item list-group-item-action logout-link" style="border-radius: 0;">
                <i class="fas fa-box-open me-2"></i> Užsakymų valdymas
                </a>
                <a href="/admin/coupons" class="list-group-item list-group-item-action logout-link" style="border-radius: 0;">
                <i class="fas fa-gift me-2"></i> Dovanų kuponų valdymas
                </a>
                <a href="/admin/reviews" class="list-group-item list-group-item-action logout-link" style="border-radius: 0;">
                <i class="fas fa-comments me-2"></i> Atsiliepimų moderavimas
                </a>
                <a href="/admin/special_offers" class="list-group-item list-group-item-action logout-link" style="border-radius: 0;">
                    <i class="fas fa-tags me-2"></i> Akcijų valdymas
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
                        <a href="/admin/users" class="text-decoration-none text-dark">
                            <div class="card text-center border" style="border-radius: 0;">
                                <div class="card-body">
                                    <i class="fas fa-users fa-3x text-muted"></i>
                                    <h5 class="card-title mt-3">Vartotojai</h5>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="/admin/orders" class="text-decoration-none text-dark">
                            <div class="card text-center border" style="border-radius: 0;">
                                <div class="card-body">
                                    <i class="fas fa-box-open fa-3x text-muted"></i>
                                    <h5 class="card-title mt-3">Užsakymų valdymas</h5>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="/admin/coupons" class="text-decoration-none text-dark">
                            <div class="card text-center border" style="border-radius: 0;">
                                <div class="card-body">
                                    <i class="fas fa-gift fa-3x text-muted"></i>
                                    <h5 class="card-title mt-3">Dovanų kuponų valdymas</h5>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="/admin/reviews" class="text-decoration-none text-dark">
                            <div class="card text-center border" style="border-radius: 0;">
                                <div class="card-body">
                                    <i class="fas fa-comments fa-3x text-muted"></i>
                                    <h5 class="card-title mt-3">Atsiliepimų moderavimas</h5>
                                </div>
                            </div>
                        </a>
                    </div>

                    <div class="col-md-4">
                        <a href="/admin/special_offers" class="text-decoration-none text-dark">
                            <div class="card text-center border" style="border-radius: 0;">
                                <div class="card-body">
                                    <i class="fas fa-tags fa-3x text-muted"></i>
                                    <h5 class="card-title mt-3">Akcijų valdymas</h5>
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
@endsection
