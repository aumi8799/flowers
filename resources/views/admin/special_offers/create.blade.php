@extends('layouts.app')

@section('title', 'Nauja akcija')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Pridėti naują akciją</h1>
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
                <a href="/dashboard" class="list-group-item list-group-item-action"><i class="fas fa-tachometer-alt me-2"></i> Skydelis</a>
                <a href="/admin/users" class="list-group-item list-group-item-action"><i class="fas fa-users me-2"></i> Vartotojai</a>
                <a href="/admin/orders" class="list-group-item list-group-item-action"><i class="fas fa-box-open me-2"></i> Užsakymų valdymas</a>
                <a href="/admin/coupons" class="list-group-item list-group-item-action"><i class="fas fa-gift me-2"></i> Dovanų kuponų valdymas</a>
                <a href="/admin/reviews" class="list-group-item list-group-item-action"><i class="fas fa-comments me-2"></i> Atsiliepimų moderavimas</a>
                <a href="/admin/special_offers" class="list-group-item list-group-item-action active"><i class="fas fa-tags me-2"></i> Akcijų valdymas</a>
                <a href="#" class="list-group-item list-group-item-action logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i> Atsijungti</a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">@csrf</form>
            </div>
        </div>

        <div class="col-md-9">
            <form action="{{ route('admin.special_offers.store') }}" method="POST" enctype="multipart/form-data">
                @csrf

                <div class="mb-3">
                    <label class="form-label">Pavadinimas</label>
                    <input type="text" class="form-control" name="title" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nuolaidos kodas</label>
                    <input type="text" class="form-control" name="code" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Nuolaida (%)</label>
                    <input type="number" class="form-control" name="discount" min="1" max="100" required>
                </div>

                <div class="mb-3">
                    <label class="form-label">Galioja iki</label>
                    <input type="date" class="form-control" name="valid_until">
                </div>

                <div class="mb-3">
                    <label class="form-label">Aprašymas</label>
                    <textarea class="form-control" name="description" rows="4"></textarea>
                </div>

                <div class="mb-3">
                    <label class="form-label">Paveikslėlis</label>
                    <input type="file" class="form-control" name="image">
                </div>

                <button type="submit" class="btn btn-success">Išsaugoti akciją</button>
            </form>
        </div>
    </div>
</div>
@endsection
