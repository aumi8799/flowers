@extends('layouts.app')

@section('title', 'Administratoriaus valdymo skydelis')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray">
                <h1 class="display-4 fw-bolder">Administratoriaus valdymo skydelis</h1>
            </div>
        </div>
</header>

<div class="container my-5">
    <div class="row g-4">
        <div class="col-md-4">
            <div class="card border-success shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Užsakymai</h5>
                    <p class="card-text">Peržiūrėkite ir administruokite vartotojų užsakymus.</p>
                    <a href="{{ route('orders.index') }}" class="btn btn-success">Peržiūrėti</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-primary shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Atsiliepimai</h5>
                    <p class="card-text">Skaitykite ir moderuokite klientų atsiliepimus.</p>
                    <a href="{{ route('reviews.show') }}" class="btn btn-primary">Atidaryti</a>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <div class="card border-warning shadow-sm">
                <div class="card-body text-center">
                    <h5 class="card-title">Vartotojai</h5>
                    <p class="card-text">Valdykite registruotus vartotojus ir jų roles.</p>
                    <a href="#" class="btn btn-warning disabled">Kuriama...</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
