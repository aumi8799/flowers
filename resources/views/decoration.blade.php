@extends('layouts.app')

@section('title', 'Dekoravimo Paslaugos')

@section('content')
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray header-text">
            <h1 class="display-4 fw-bolder">Dekoravimo Paslaugos</h1>
            <p class="lead fw-normal text-dark-gray mb-0">...</p>
            </div>
        </div>
    </header>
@endsection
