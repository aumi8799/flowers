@extends('layouts.app')

@section('title', 'Peržiūrėti dekoravimo užsakymą')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Užklausa iš: #{{ $order->name }} užsakymo</h1>
        </div>
    </div>
</header>

<div class="container py-4">
    
    <!-- Užsakymo informacija -->
    <div class="row">
        <div class="col-md-6">
            <p><strong>El. paštas:</strong> {{ $order->email }}</p>
            <p><strong>Data:</strong> {{ \Carbon\Carbon::parse($order->event_date)->format('d-m-Y') }}</p>
            <p><strong>Vieta:</strong> {{ $order->location }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Svečiai:</strong> {{ $order->guests_count }}</p>
            <p><strong>Stalai:</strong> {{ $order->tables_count }}</p>
            <p><strong>Biudžetas:</strong> {{ number_format($order->budget, 2) }} €</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <p><strong>Gėlės:</strong> {{ $order->flowers == 'yes' ? 'Taip' : 'Ne' }}</p>
            <p><strong>Spalvų gama:</strong> {{ $order->color_scheme }}</p>
        </div>
        <div class="col-md-6">
            <p><strong>Stilius:</strong> {{ ucfirst($order->style) }}</p>
            <p><strong>Tipas:</strong> {{ ucfirst($order->type) }}</p>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <p><strong>Paketas:</strong> 
                @switch($order->package)
                    @case('mini')
                        Mini (Nuo €700)
                        @break
                    @case('midi')
                        Midi (Nuo €1100)
                        @break
                    @case('maxi')
                        Maxi (Nuo €1600)
                        @break
                    @default
                        Nenurodytas
                @endswitch
            </p>
        </div>
    </div>
<p><strong>Statusas:</strong> 
                                @switch($order->status)
                                    @case('pateiktas')
                                        <span class="badge bg-secondary">Pateiktas</span>
                                        @break
                                    @case('atliktas')
                                        <span class="badge bg-info text-dark">Atliktas</span>
                                        @break
                                    @case('vykdomas')
                                        <span class="badge bg-warning text-dark">Vykdomas</span>
                                        @break
                                    @case('atmestas')
                                        <span class="badge bg-danger">Atmestas</span>
                                        @break
                                    @default
                                        <span class="badge bg-light text-dark">Nežinomas</span>
                                @endswitch
                            </p>
    <div class="row">
        <div class="col-md-12">
            <p><strong>Komentarai:</strong> {{ $order->comments }}</p>
        </div>
    </div>
    <div class="d-flex justify-content-between gap-2 mt-4">
            <a href="{{ route('admin.decor_orders') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Grįžti
            </a>
            <a href="{{ route('admin.decor_orders.edit', $order->id) }}" class="btn btn-primary">
                <i class="fas fa-edit me-2"></i> Redaguoti užsakymą
            </a>
        </div>
</div>
@endsection
