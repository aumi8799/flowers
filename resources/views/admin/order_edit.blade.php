@extends('layouts.app')

@section('title', 'Redaguoti užsakymą')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Redaguoti užsakymą #{{ $order->id }}</h1>
        </div>
    </div>
</header>

<div class="container my-5">
    <form action="{{ route('admin.orders.update', $order->id) }}" method="POST">
        @csrf
        @method('PUT')

        {{-- Pirkėjo informacija --}}
        <div class="bg-light p-4 mb-4 rounded shadow-sm border">
            <h4 class="mb-3"><i class="fas fa-user me-2 text-primary"></i>Pirkėjo informacija</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Vardas</label>
                    <input type="text" name="first_name" class="form-control" value="{{ $order->first_name }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pavardė</label>
                    <input type="text" name="last_name" class="form-control" value="{{ $order->last_name }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Telefono numeris</label>
                    <input type="text" name="phone" class="form-control" value="{{ $order->phone }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">El. paštas</label>
                    <input type="email" name="email" class="form-control" value="{{ $order->email }}">
                </div>
            </div>
        </div>

        {{-- Pristatymo informacija --}}
        <div class="bg-light p-4 mb-4 rounded shadow-sm border">
            <h4 class="mb-3"><i class="fas fa-truck me-2 text-success"></i>Pristatymo informacija</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Miestas</label>
                    <select name="delivery_city" class="form-select">
                        <option value="7" {{ $order->delivery_city == 7 ? 'selected' : '' }}>Vilnius</option>
                        <option value="10" {{ $order->delivery_city == 10 ? 'selected' : '' }}>Kaunas</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Pašto kodas</label>
                    <input type="text" name="postal_code" class="form-control" value="{{ $order->postal_code }}">
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Adresas</label>
                    <input type="text" name="delivery_address" class="form-control" value="{{ $order->delivery_address }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Data</label>
                    <input type="date" name="delivery_date" class="form-control" value="{{ $order->delivery_date }}">
                </div>
                <div class="col-md-3 mb-3">
                    <label class="form-label">Laikas</label>
                    <input type="time" name="delivery_time" class="form-control" value="{{ $order->delivery_time }}">
                </div>
                <div class="col-md-12 form-check mt-2">
                    <input type="checkbox" class="form-check-input" name="video" id="video" value="1" {{ $order->video ? 'checked' : '' }}>
                    <label class="form-check-label" for="video">Užsakytas vaizdo įrašas (+5€)</label>
                </div>
            </div>
        </div>

        {{-- Kita informacija --}}
        <div class="bg-light p-4 mb-4 rounded shadow-sm border">
            <h4 class="mb-3"><i class="fas fa-info-circle me-2 text-dark"></i>Užsakymo būsena</h4>
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label class="form-label">Būsena</label>
                    <select name="status" class="form-select">
                        <option value="rezervuotas" {{ $order->status == 'rezervuotas' ? 'selected' : '' }}>Rezervuotas</option>
                        <option value="apmokėtas" {{ $order->status == 'apmokėtas' ? 'selected' : '' }}>Apmokėtas</option>
                        <option value="pristatytas" {{ $order->status == 'pristatytas' ? 'selected' : '' }}>Pristatytas</option>
                        <option value="atšauktas" {{ $order->status == 'atšauktas' ? 'selected' : '' }}>Atšauktas</option>
                    </select>
                </div>
                <div class="col-md-6 mb-3">
                    <label class="form-label">Atšaukimo priežastis</label>
                    <input type="text" name="cancel_reason" class="form-control" value="{{ $order->cancel_reason }}">
                </div>
                <div class="col-12 mb-3">
                    <label class="form-label">Pastabos</label>
                    <textarea name="notes" class="form-control">{{ $order->notes }}</textarea>
                </div>
            </div>
        </div>

        <div class="d-flex justify-content-between">
            <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Grįžti
            </a>
            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-2"></i> Išsaugoti
            </button>
        </div>
    </form>
</div>
@endsection
