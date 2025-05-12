@extends('layouts.app')

@section('title', 'Specialūs pasiūlymai')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Specialūs pasiūlymai</h1>
            <p class="lead">Pasinaudokite išskirtiniais nuolaidų kodais mūsų klientams!</p>
        </div>
    </div>
</header>

<div class="container my-5">

    @if(session('discount_code_success'))
        <div class="alert alert-success">
            {{ session('discount_code_success') }}
        </div>
    @endif

    @if(session('discount_code_error'))
        <div class="alert alert-danger">
            {{ session('discount_code_error') }}
        </div>
    @endif
    <div class="row">
        @forelse($offers as $offer)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 h-100">
                    @if($offer->image)
                        <img src="{{ asset('images/special_offers/' . $offer->image) }}" class="card-img-top" alt="{{ $offer->title }}">
                    @endif

                    <div class="card-body">
                        <h5 class="card-title text-primary fw-bold">{{ $offer->title }}</h5>
                        <p class="card-text">{{ $offer->description }}</p>
                        <ul class="list-unstyled mb-3">
                            <li><i class="fas fa-percentage text-success me-2"></i><strong>Nuolaida:</strong> {{ $offer->discount * 100 }}%</li>
                            <li><i class="fas fa-tag text-warning me-2"></i><strong>Kodas:</strong> <code>{{ $offer->code }}</code></li>
                            @if($offer->valid_until)
                                <li><i class="fas fa-calendar-alt text-info me-2"></i><strong>Galioja iki:</strong> {{ \Carbon\Carbon::parse($offer->valid_until)->format('Y-m-d') }}</li>
                            @endif
                        </ul>

                        <form action="{{ route('special_offers.apply') }}" method="POST">
                            @csrf
                            <input type="hidden" name="discount_code" value="{{ $offer->code }}">
                            <button type="submit" class="btn btn-outline-primary w-100">
                                <i class="fas fa-check-circle me-1"></i> Panaudoti šį kodą
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12 text-center">
                <div class="alert alert-info">
                    Šiuo metu nėra aktyvių pasiūlymų.
                </div>
            </div>
        @endforelse
    </div>
</div>

@endsection
