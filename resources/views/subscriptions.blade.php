@extends('layouts.app')

@section('title', 'Puokščių Prenumerata')

@section('content')
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 300px;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-white">
            <h1 class="display-4 fw-bolder">Puokščių Prenumerata</h1>
            <p class="lead fw-normal text-white mb-0">Užsiprenumeruokite ir gaukite nuostabias gėles reguliariai!</p>
            </div>
        </div>
    </header>
@endsection
