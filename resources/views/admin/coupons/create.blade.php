@extends('layouts.app')

@section('title', 'Sukurti dovanų kuponą')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Sukurti dovanų kuponą</h1>
        </div>
    </div>
</header>

<div class="container my-5">

    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    <form method="POST" action="{{ route('admin.coupons.store') }}">
        @csrf

        <div class="mb-3">
            <label for="code" class="form-label">Kupono kodas</label>
            <input type="text" name="code" id="code" class="form-control" value="{{ old('code') }}" required>
            @error('code')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>

        <div class="mb-3">
            <label for="value" class="form-label">Vertė (€)</label>
            <input type="number" name="value" id="value" class="form-control" step="0.01" value="{{ old('value') }}" required>
            @error('value')
                <div class="text-danger small">{{ $message }}</div>
            @enderror
        </div>
        <div class="d-flex justify-content-between gap-2 mt-4">

        <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Grįžti
            </a>
        <button type="submit" class="btn btn-success"><i class="fas fa-plus me-2"></i>Sukurti kuponą</button>
        </div>
    </form>
</div>
@endsection
