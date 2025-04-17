@extends('layouts.app')

@section('title', 'Atsiliepimai')

@section('content')
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray">
                <h1 class="display-4 fw-bolder">Atsiliepimai ir įvertinimai</h1>
                <p class="lead fw-normal text-dark-gray mb-0">Skaitykite, ką sako mūsų klientai!</p>
            </div>
        </div>
    </header>

    <div class="container my-5">
        @if($reviews->isEmpty())
            <div class="alert alert-info text-center">
                Šiuo metu nėra atsiliepimų. 🌸
            </div>
        @else
            <div class="row">
                @foreach($reviews as $review)
                    <div class="col-md-6 mb-4">
                        <div class="card shadow-lg h-100 border-0 rounded-3 overflow-hidden">
                            <div class="card-body bg-gradient p-4">
                                <h5 class="card-title mb-3">
                                    @for ($i = 1; $i <= 5; $i++)
                                        <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }} text-warning" style="font-size: 1.2rem;"></i>
                                    @endfor
                                </h5>
                                <p class="card-text text-muted">{{ $review->comment }}</p>
                            </div>
                            <div class="card-footer text-white text-center bg-dark">
                                <small>Parašė: <strong>{{ $review->user->name }}</strong></small><br>
                                <small>{{ $review->created_at->format('Y-m-d ') }}</small>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
@endsection
