@extends('layouts.app')

@section('title', 'Dovanų kuponai')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray">
                <h1 class="display-4 fw-bolder">Dovanų kuponai</h1>
                <p class="lead">Padovanokite galimybę pasirinkti!</p>
            </div>
        </div>
    </header>
<div class="container my-5">
    <div class="row">
        <!-- Forma -->
        <div class="col-md-6">
            @if(session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif

            <h2 class="mb-4"><i class="fas fa-gift me-2 text-primary"></i>Įsigyti dovanų kuponą</h2>

            <form method="POST" action="{{ route('giftcoupons.purchase') }}">
                @csrf

                <div class="mb-3">
                    <label for="value" class="form-label">Kupono vertė (€)</label>
                    <select name="value" id="value" class="form-select" required>
                        <option value="">-- Pasirinkite sumą --</option>
                        <option value="10">10 €</option>
                        <option value="25">25 €</option>
                        <option value="50">50 €</option>
                        <option value="100">100 €</option>
                    </select>
                </div>

                <button type="submit" class="btn btn-primary btn-lg px-4">
                    <i class="fas fa-shopping-cart me-2"></i> Įsigyti kuponą
                </button>
            </form>
        </div>

        <!-- Kupono peržiūra -->
        <div class="col-md-6 mt-5 mt-md-0 ps-md-5">
            <div class="p-4 rounded-4 shadow-sm text-center" style="background: #ffffff; border: 2px dashed #0d6efd;">
                <img src="{{ asset('images/logo.png') }}" alt="Bloom & Bliss" style="max-height: 60px; margin-bottom: 15px;">
                <h5 class="fw-bold text-primary mb-2">DOVANŲ KUPONAS</h5>
                <p style="font-size: 1.2rem;">Vertė: <strong id="preview-value"></strong></p>
                <p>Kodas: <strong></strong></p>
                <p class="text-muted small mb-0">Galioja vienkartiniam panaudojimui 12 mėnesių.</p>
                <br>
                <p class="text-muted small">Sugeneruota: {{ \Carbon\Carbon::now()->format('Y-m-d') }}</p>
            </div>
        </div>
    </div>

    <!-- Informacija apie kuponus -->
    <div class="row mt-5">
        <div class="col-12">
            <h5 class="mb-3"><i class="fas fa-info-circle text-secondary me-2"></i>Informacija apie kuponus</h5>
            <ul class="list-unstyled">
                <li class="mb-2"><i class="fas fa-calendar-alt text-primary me-2"></i>Galioja <strong>12 mėnesių</strong>.</li>
                <li class="mb-2"><i class="fas fa-tags text-success me-2"></i>Galima naudoti visoms prekėms.</li>
                <li class="mb-2"><i class="fas fa-ban text-danger me-2"></i>Negrąžinamas pinigais.</li>
                <li class="mb-2"><i class="fas fa-envelope text-warning me-2"></i>Klausimai: <a href="mailto:bloomandblissshoponline@gmail.com">bloomandblissshoponline@gmail.com</a></li>
            </ul>
        </div>
    </div>
</div>

<!-- Dinaminis kupono vertės atnaujinimas -->
<script>
    document.getElementById('value').addEventListener('change', function () {
        const selectedValue = this.value ? this.value + ' €' : '–';
        document.getElementById('preview-value').textContent = selectedValue;
    });
</script>
@endsection
