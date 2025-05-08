@extends('layouts.app')

@section('title', 'Redaguoti kuponą')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Redaguoti kuponą #{{ $coupon->id }}</h1>
        </div>
    </div>
</header>

<div class="container py-5">

    <form action="{{ route('admin.coupons.update', $coupon->id) }}" method="POST">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="code" class="form-label">Kupono kodas</label>
            <input type="text" name="code" id="code" class="form-control" value="{{ old('code', $coupon->code) }}" required>
        </div>

        <div class="mb-3">
            <label for="value" class="form-label">Vertė (€)</label>
            <input type="number" step="0.01" name="value" id="value" class="form-control" value="{{ old('value', $coupon->value) }}" required>
        </div>

        <div class="mb-3">
            <label for="used" class="form-label">Statusas</label>
            <select name="used" id="used" class="form-select">
                <option value="0" {{ (int)$coupon->used === 0 ? 'selected' : '' }}>Nepanaudotas</option>
                <option value="1" {{ (int)$coupon->used === 1 ? 'selected' : '' }}>Panaudotas</option>
            </select>

        </div>
        <div class="mb-3">
            <label for="used_in_order_id" class="form-label">Panaudota užsakymui (ID)</label>
            <input type="number" name="used_in_order_id" id="used_in_order_id" class="form-control" value="{{ old('used_in_order_id', $coupon->used_in_order_id) }}">
        </div>

        <div class="mb-3">
            <label for="order_id" class="form-label">Sukūrimo užsakymo ID</label>
            <input type="number" name="order_id" id="order_id" class="form-control" value="{{ old('order_id', $coupon->order_id) }}">
        </div>

        <div class="mb-3">
            <label for="created_at" class="form-label">Sukurtas</label>
            <input type="text" id="created_at" class="form-control" value="{{ $coupon->created_at }}" readonly>
        </div>

        <div class="mb-3">
            <label for="updated_at" class="form-label">Atnaujintas</label>
            <input type="text" id="updated_at" class="form-control" value="{{ $coupon->updated_at }}" readonly>
        </div>

        <div class="d-flex justify-content-between gap-2 mt-4">
            <a href="{{ route('admin.coupons.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Grįžti
            </a>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-2"></i> Išsaugoti 
            </button>

            <button type="button" class="btn btn-danger"
                    onclick="if(confirm('Ar tikrai norite ištrinti šį kuponą?')) document.getElementById('delete-user-form').submit();">
                <i class="fas fa-trash me-2"></i> Ištrinti šį kuponą
            </button>
        </div>
    </form>

    <form id="delete-user-form" method="POST" action="{{ route('admin.coupons.destroy', $coupon->id) }}" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection
