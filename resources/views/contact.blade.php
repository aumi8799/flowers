@extends('layouts.app')

@section('title', 'Kontaktai')

@section('content')
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray header-text">
                <h1 class="display-4 fw-bolder">Susisiekite su mumis</h1>
                <p class="lead fw-normal text-dark-gray mb-0">Turite klausimų? Mes visada pasiruošę padėti!</p>
            </div>
        </div>
    </header>

    <section class="py-5">
        <div class="container px-4 px-lg-5">
            

            <div class="row">
                <div class="col-md-6">

                    <h2 class="fw-bolder">Mūsų kontaktai</h2>
                    <p>Norėdami su mumis susisiekti, naudokitės žemiau pateikta informacija arba užpildykite kontaktinę formą.</p>
                    
                    <h4>Adresas</h4>
                    <p>Didlaukio g. 47, Vilnius, Lietuva</p>

                    <h4>Telefonas</h4>
                    <p>+370 600 12345</p>

                    <h4>El. paštas</h4>
                    <p>bloomandblissshoponline@gmail.com</p>
                </div>

                <div class="col-md-6">
                    <h4>Rašykite mums</h4>
                    <form action="{{ route('contact.send') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="name" class="form-label">Jūsų vardas</label>
                            <input type="text" name="name" class="form-control" id="name" placeholder="Įveskite vardą" required>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">El. paštas</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="Įveskite el. paštą" required>
                        </div>
                        <div class="mb-3">
                            <label for="message" class="form-label">Žinutė</label>
                            <textarea name="message" class="form-control" id="message" rows="4" placeholder="Jūsų žinutė" required></textarea>
                        </div>
                        <button type="submit" class="btn btn-primary">Siųsti</button>
                    </form>
                </div>

            </div>
        </div>
    </section>
@endsection
