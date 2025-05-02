{{-- resources/views/admin/reviews.blade.php --}}
@extends('layouts.app')

@section('title', 'Atsiliepimų valdymas')
@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray">
                <h1 class="display-4 fw-bolder">Atsiliepimų valdymas</h1>

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
                    <a href="/dashboard" class="list-group-item list-group-item-action logout-link" style="border-radius: 0;">
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
                    <a href="/admin/reviews" class="list-group-item list-group-item-action active" style="border-radius: 0;">
                    <i class="fas fa-comments me-2"></i> Atsiliepimų moderavimas
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
            <h2>Klientų atsiliepimai</h2>
            
            <form method="GET" action="/admin/reviews" class="mb-4 d-flex align-items-end gap-3">
            <label for="rating">Filtruoti pagal įvertinimą:</label>
                    <select name="rating" id="rating" onchange="this.form.submit()" class="form-select w-auto d-inline-block">
                        <option value="">Visi</option>
                        @for($i = 5; $i >= 1; $i--)
                            <option value="{{ $i }}" {{ request('rating') == $i ? 'selected' : '' }}>{{ $i }} žvaigžd.</option>
                        @endfor
                    </select>
                </form>

                            <div class="row">
                            @forelse($reviews as $review)
                    <div class="col-md-12 mb-4">
                        <div class="card-glass p-4">
                            <div class="ribbon bg-primary text-white px-3 py-1 mb-3" style="display: inline-block;">
                                <i class="fas fa-star"></i> {{ $review->rating }}/5
                            </div>

                            <h5>Atsiliepimo ID: <span class="text-success">#{{ $review->id }}</span></h5>
                            <p><strong>Vartotojas:</strong> {{ $review->user->name ?? 'Nežinomas' }}</p>
                            <p><strong>El. paštas:</strong> {{ $review->user->email ?? '-' }}</p>
                            <p><strong>Įvertinimas:</strong> {{ $review->rating }}/5</p>
                            <p><strong>Komentaras:</strong> {{ $review->comment }}</p>
                            <p><strong>Sukurta:</strong> {{ $review->created_at->format('Y-m-d') }}</p>

                            <a href="{{ route('admin.reviews.edit', $review->id) }}" class="btn btn-outline-success btn-sm">
    Tvarkyti atsiliepimą
</a>
                        </div>
                    </div>
                @empty
                <div class="alert alert-info mb-0 text-center">Atsiliepimų nerasta.</div>
                @endforelse
                <div class="mt-4">
    {{ $reviews->appends(request()->query())->links() }}
</div>
            </div>
        </div>
    </div>
</div>
@endsection
