@extends('layouts.app')

@section('title', 'Puokščių Prenumerata')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray header-text">
            <h1 class="display-4 fw-bolder">Puokščių Prenumerata</h1>
            <p class="lead fw-normal text-dark-gray mb-0">Užsiprenumeruokite ir gaukite nuostabias gėles reguliariai!</p>
        </div>
    </div>
</header>

<div class="container my-5">
    <div class="row align-items-center">
        <div class="col-md-6 mb-4">
            <img src="{{ asset('images/products/prenumerata.png') }}" class="img-fluid rounded shadow-sm" alt="Prenumerata">
        </div>
        <div class="col-md-6">
            <h2 class="mb-3">Kiekvienas mėnuo – nauja gėlių patirtis</h2>
            <p class="text-muted">
                Atraskite nuolatinį gėlių džiaugsmą! Pasirinkite mėgstamą stilių, dydį ir trukmę – o mes pasirūpinsime, kad kiekvieną mėnesį jus pasiektų nauja, profesionaliai sukurta gėlių kompozicija.
            </p>

            <div class="bg-light p-4 rounded shadow-sm mt-4">
                <h5 class="mb-3">Ką gausite pasirinkę kiekvieną kategoriją?</h5>
                <div class="row">
                    <div class="col-md-6 mb-3">
                        <div class="border-start border-3 border-primary ps-3">
                            <h6><i class="fas fa-heart text-primary me-2"></i><strong>Klasika</strong></h6>
                            <p class="mb-0 text-muted">Rožės, lelijos, gvazdikai – elegantiška ir išliekanti puokštė tradicinių spalvų tonais.</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="border-start border-3 border-danger ps-3">
                            <h6><i class="fas fa-star text-danger me-2"></i><strong>Egzotika</strong></h6>
                            <p class="mb-0 text-muted">Orchidėjos, proteos, strelicijos – spalvingos ir netikėtos kompozicijos iš egzotinių augalų.</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="border-start border-3 border-success ps-3">
                            <h6><i class="fas fa-leaf text-success me-2"></i><strong>Žaluma</strong></h6>
                            <p class="mb-0 text-muted">Eukaliptai, paparčiai, ruskusas – natūralūs, žali, gaivūs deriniai su minimaliais žiedais.</p>
                        </div>
                    </div>
                    <div class="col-md-6 mb-3">
                        <div class="border-start border-3 border-secondary ps-3">
                            <h6><i class="fas fa-minus text-secondary me-2"></i><strong>Minimalizmas</strong></h6>
                            <p class="mb-0 text-muted">Subtilios spalvos, nedaug rūšių, bet estetiškas išdėstymas – skoniui be pertekliaus.</p>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('subscription.add') }}" method="POST" class="mt-4">
                @csrf
                <div class="mb-3">
                    <label for="category" class="form-label">Kategorija:</label>
                    <select name="category" id="category" class="form-select" required>
                        <option value="">-- Pasirink kategoriją --</option>
                        <option value="klasika">Klasika</option>
                        <option value="egzotika">Egzotika</option>
                        <option value="zaluma">Žaluma</option>
                        <option value="minimalizmas">Minimalizmas</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="size" class="form-label">Puokštės dydis:</label>
                    <select name="size" id="size" class="form-select" required>
                        <option value="XS" data-price="0">XS</option>
                        <option value="S" data-price="5">S (+5€)</option>
                        <option value="M" data-price="10">M (+10€)</option>
                        <option value="L" data-price="15">L (+15€)</option>
                        <option value="XL" data-price="20">XL (+20€)</option>
                    </select>
                </div>

                <div class="mb-3">
                    <label for="duration" class="form-label">Laikotarpis:</label>
                    <select name="duration" id="duration" class="form-select" required>
                        <option value="1" data-multiplier="1">1 mėnuo</option>
                        <option value="3" data-multiplier="3">3 mėnesiai</option>
                        <option value="6" data-multiplier="6">6 mėnesiai</option>
                    </select>
                </div>

                <div class="mb-3">
                    <strong>Bendra kaina:</strong> <span id="price" class="text-primary fw-bold">30 €</span>
                </div>

                <button type="submit" class="btn btn-primary w-100">
                    <i class="fas fa-paper-plane me-2"></i> Prenumeruoti dabar
                </button>
            </form>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sizeSelect = document.querySelector('select[name="size"]');
    const durationSelect = document.querySelector('select[name="duration"]');
    const priceElement = document.getElementById('price');
    const basePrice = 30;

    function updatePrice() {
        const sizePrice = parseInt(sizeSelect.options[sizeSelect.selectedIndex].dataset.price);
        const durationMultiplier = parseInt(durationSelect.options[durationSelect.selectedIndex].dataset.multiplier);
        const finalPrice = (basePrice + sizePrice) * durationMultiplier;
        priceElement.textContent = `${finalPrice} €`;
    }

    sizeSelect.addEventListener('change', updatePrice);
    durationSelect.addEventListener('change', updatePrice);
    updatePrice();
});
</script>
@endsection
