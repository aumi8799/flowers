@extends('layouts.app')

@section('title', 'Dekoravimo Paslaugos')

@section('content')
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray header-text">
                <h1 class="display-4 fw-bolder">Dekoravimo Paslaugos</h1>
                <p class="lead fw-normal text-dark-gray mb-0">Pasirinkite dekoravimo paslaugas pagal savo poreikius.</p>
            </div>
        </div>
    </header>

    <!-- Paslaugų pasirinkimas -->
    <section class="container my-5">
        <div class="row">
            <div class="col-md-4 mb-3">
                <a href="{{ route('wedding.decor') }}" class="card text-decoration-none text-dark">
                    <img src="{{ asset('images/decorations/vestuviu.jpg') }}" alt="Vestuvės" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Vestuvės</h5>
                        <p class="card-text">Elegantiškos ir romantiškos dekoracijos Jūsų vestuvėms.</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="{{ route('birthday.decor') }}" class="card text-decoration-none text-dark">
                    <img src="{{ asset('images/decorations/gimtadeniui.jpg') }}" alt="Gimtadieniai" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Gimtadieniai</h5>
                        <p class="card-text">Spalvingos ir linksmos dekoracijos Jūsų gimtadieniui.</p>
                    </div>
                </a>
            </div>
            <div class="col-md-4 mb-3">
                <a href="{{ route('corporate.decor') }}" class="card text-decoration-none text-dark">
                    <img src="{{ asset('images/decorations/imoniu.jpg') }}" alt="Įmonių renginiai" class="card-img-top">
                    <div class="card-body">
                        <h5 class="card-title">Įmonių renginiai</h5>
                        <p class="card-text">Profesionalios dekoracijos Jūsų įmonių renginiams.</p>
                    </div>
                </a>
            </div>
        </div>
    </section>

    <!-- Konsultacijos skiltis su WhatsApp -->
    <div class="container my-5">
        <div class="card shadow text-center p-4 border-success" style="max-width: 600px; margin: 0 auto;">
            <h5 class="mb-3">Reikia pagalbos ar konsultacijos?</h5>
            <p class="mb-4">Susisiekite su mumis – atsakysime kaip įmanoma greičiau!</p>

            <!-- WhatsApp mygtukas -->
            <a href="https://wa.me/37069058344?text=Sveiki,%20norėčiau%20pasikonsultuoti"
            target="_blank"
            class="btn btn-success btn-lg mb-3">
                <i class="bi bi-whatsapp me-2"></i> Rašyti per WhatsApp
            </a>

            <!-- Skambučio mygtukas -->
            <br>
            <a href="tel:+37069058344" class="btn btn-outline-success btn-lg">
                <i class="bi bi-telephone me-2"></i> Skambinti: +370 69058344
            </a>
        </div>
    </div>
@endsection
