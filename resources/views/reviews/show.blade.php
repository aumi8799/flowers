@extends('layouts.app')

@section('title', 'Atsiliepimai')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Atsiliepimai ir įvertinimai</h1>
            <p class="lead fw-normal text-dark-gray mb-0">Skaitykite, ką sako mūsų klientai!</p>
        </div>
    </div>
</header>

<div class="container my-5">
    <!-- Filtravimo forma -->
    <form method="GET" action="{{ route('reviews.show') }}" class="mb-4">
        <div class="row align-items-end">
            <div class="col-md-4">
                <label for="rating" class="form-label">Filtruoti pagal reitingą:</label>
                <select name="rating" id="rating" class="form-select">
                    <option value="">Visi reitingai</option>
                    @for ($i = 5; $i >= 1; $i--)
                        <option value="{{ $i }}" {{ (isset($selectedRating) && $selectedRating == $i) ? 'selected' : '' }}>
                            {{ $i }} žvaigždutės
                        </option>
                    @endfor
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-primary">Filtruoti</button>
            </div>
        </div>
    </form>
    <!-- Apžvalgų suvestinė -->
    <div class="card p-4 mb-5">
        <div class="row align-items-center">
            <div class="col-md-4 text-center">
                <div class="rating-box">
                    <h1 class="pt-2">{{ number_format($averageRating, 1) }}</h1>
                    <p>iš 5</p>
                    @for ($i = 1; $i <= 5; $i++)
                        <span class="fa fa-star {{ $i <= round($averageRating) ? 'star-active' : 'star-inactive' }}"></span>
                    @endfor
                </div>
            </div>
            <div class="col-md-8">
                <table class="table mb-0">
                    @foreach([5 => 'Puikiai', 4 => 'Gerai', 3 => 'Vidutiniškai', 2 => 'Silpnai', 1 => 'Blogai'] as $star => $label)
                        <tr>
                            <td class="w-25">{{ $label }}</td>
                            <td class="w-50">
                                <div class="bar-container">
                                    <div class="bar-{{ $star }}" style="width: {{ isset($ratingCounts[$star]) ? ($ratingCounts[$star] / $totalReviews) * 100 : 0 }}%;"></div>
                                </div>
                            </td>
                            <td class="w-25 text-end">{{ $ratingCounts[$star] ?? 0 }}</td>
                        </tr>
                    @endforeach
                </table>
            </div>
        </div>
    </div>


    @if($reviews->isEmpty())
        <div class="alert alert-info text-center">Šiuo metu nėra atsiliepimų. 🌸</div>
    @else
        <!-- Atsiliepimų sąrašas -->
        <div class="row">
            @foreach($reviews as $review)
            <div class="col-md-6 mb-4">
    <div class="review-card shadow-sm border-0 h-100">
        <div>
            <div class="mb-2 d-flex align-items-center">
                @for ($i = 1; $i <= 5; $i++)
                    <i class="fas fa-star{{ $i <= $review->rating ? '' : '-o' }} {{ $i <= $review->rating ? 'text-warning' : 'text-secondary' }} me-1"></i>
                @endfor
                <small class="text-muted ms-auto">{{ $review->created_at->format('Y-m-d') }}</small>
            </div>
            <p class="text-muted mb-3">“{{ $review->comment }}”</p>
        </div>
        <div class="text-end">
            <small class="text-dark">— <strong>{{ $review->user->name }}</strong></small>
        </div>
    </div>
</div>

            @endforeach
        </div>
    @endif
    @if ($reviews->hasPages())
    <p class="text-muted text-center mt-4">
        Rodoma {{ $reviews->firstItem() }}–{{ $reviews->lastItem() }} iš {{ $reviews->total() }} atsiliepimų
    </p>

    <div class="d-flex justify-content-center mt-3">
        {{ $reviews->appends(request()->query())->links() }}
    </div>
@endif

</div>
@endsection
