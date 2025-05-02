@extends('layouts.app')

@section('title', 'Dovanų kuponai')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray header-text">
            <h1 class="display-4 fw-bolder">Dovanų kuponai</h1>
            </div>
        </div>
    </header>
    <div class="container my-5">
    <h2 class="mb-4">Įsigyti dovanų kuponą</h2>

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('giftcoupons.purchase') }}">
        @csrf

        <div class="mb-3">
            <label for="value" class="form-label">Kupono vertė (€)</label>
            <select name="value" id="value" class="form-select" required>
                <option value="">Pasirinkite sumą</option>
                <option value="10">10 €</option>
                <option value="25">25 €</option>
                <option value="50">50 €</option>
                <option value="100">100 €</option>
            </select>
        </div>

        <button type="submit" class="btn btn-primary">
            <i class="fas fa-gift me-2"></i> Įsigyti kuponą
        </button>
    </form>
</div>
@endsection
