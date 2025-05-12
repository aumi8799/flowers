@extends('layouts.app')

@section('title', 'Akcijų valdymas')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Akcijų valdymas</h1>
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
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h2>Akcijų sąrašas</h2>
                <a href="{{ route('admin.special_offers.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i> Nauja akcija
                </a>
            </div>

            <div class="row">
                @forelse($offers as $offer)
                    <div class="col-md-12 mb-4">
                        <div class="card-glass p-4">
                            <h5>{{ $offer->title }}</h5>
                            <p><strong>Kodas:</strong> {{ $offer->code }}</p>
                            <p><strong>Nuolaida:</strong> {{ $offer->discount * 100 }}%</p>
                            <p><strong>Galioja iki:</strong> {{ $offer->valid_until ? \Carbon\Carbon::parse($offer->valid_until)->format('Y-m-d') : 'Neribotai' }}</p>
                            <p>{{ $offer->description }}</p>

                            @if($offer->image)
                                <img src="{{ asset('images/special_offers/' . $offer->image) }}" alt="Nuotrauka" class="img-fluid my-2" style="max-width: 250px;">
                            @endif

                            <div class="mt-3 d-flex gap-2">
                                <a href="{{ route('admin.special_offers.edit', $offer->id) }}" class="btn btn-outline-success btn-sm">
                                    <i class="fas fa-edit"></i> Redaguoti
                                </a>
                                <form action="{{ route('admin.special_offers.destroy', $offer->id) }}" method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti šią akciją?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-outline-danger btn-sm">
                                        <i class="fas fa-trash-alt"></i> Pašalinti
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info text-center">Akcijų dar nėra.</div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
