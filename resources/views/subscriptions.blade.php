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
        <div class="row">
            <div class="col-md-6">
            <img src="{{ asset('images/products/prenumerata.png') }}" class="img-fluid" alt="Prenumerata">
            </div>
            <div class="col-md-6">
            <h2>Gėlių puokščių prenumerata</h2>
                <p>
                    Atraskite nuolatinį gėlių džiaugsmą! <br>
                    Pasirinkite savo mėgstamą gėlių stilių, puokštės dydį ir prenumeratos trukmę, o mes pasirūpinsime, kad kas mėnesį į jūsų duris atkeliuotų nauja, kruopščiai sukurta gėlių kompozicija. <br>
                    Kiekvieną kartą gausite vis kitokią, tačiau pasirinktos kategorijos įkvėptą puokštę, kupiną gaivos, spalvų ir šilumos.
                </p>

                <p><strong>Kaina:</strong> <span id="price">30 €</span></p>
                <form action="{{ route('subscription.add') }}" method="POST">
                    @csrf

                    <div class="mb-3">
                        <label>Kategorija:</label>
                        <select name="category" class="form-control" required>
                            <option value="">-- Pasirink kategoriją --</option>
                            <option value="klasika">Klasika</option>
                            <option value="egzotika">Egzotika</option>
                            <option value="zaluma">Žaluma</option>
                            <option value="minimalizmas">Minimalizmas</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Puokštės dydis:</label>
                        <select name="size" class="form-control" required>
                            <option value="XS" data-price="0">XS</option>
                            <option value="S" data-price="5">S (+5€)</option>
                            <option value="M" data-price="10">M (+10€)</option>
                            <option value="L" data-price="15">L (+15€)</option>
                            <option value="XL" data-price="20">XL (+20€)</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label>Laikotarpis:</label>
                        <select name="duration" class="form-control" required>
                            <option value="1" data-multiplier="1">1 mėnuo</option>
                            <option value="3" data-multiplier="3">3 mėnesiai</option>
                            <option value="6" data-multiplier="6">6 mėnesiai</option>
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary">Prenumeruoti</button>
                </form>
            </div>
        </div>
    </div>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const sizeSelect = document.querySelector('select[name="size"]');
    const durationSelect = document.querySelector('select[name="duration"]');
    const priceElement = document.getElementById('price');
    const basePrice = 30; // Pagrindinė kaina (XS dydžiui)

    // Funkcija, kuri perskaičiuos kainą
    function updatePrice() {
        const sizePrice = parseInt(sizeSelect.options[sizeSelect.selectedIndex].dataset.price); // Gauname dydžio kainą
        const durationMultiplier = parseInt(durationSelect.options[durationSelect.selectedIndex].dataset.multiplier); // Gauname laikotarpio dauginimo koeficientą

        // Apskaičiuojame galutinę kainą
        const finalPrice = (basePrice + sizePrice) * durationMultiplier;
        // Atnaujiname kainą puslapyje
        priceElement.textContent = `${finalPrice} €`;
    }

    // Pridedame įvykio klausytojus, kad kaina būtų atnaujinama, kai pasikeičia pasirinkimas
    sizeSelect.addEventListener('change', updatePrice);
    durationSelect.addEventListener('change', updatePrice);

    // Atnaujinsime kainą pradžiai, kai puslapis užsikraus
    updatePrice();
});
</script>
@endsection
