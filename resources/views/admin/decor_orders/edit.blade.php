@extends('layouts.app')

@section('title', 'Redaguoti dekoravimo užsakymą')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Redaguoti užsakymą</h1>
        </div>
    </div>
</header>
        <div class="container my-5">
<form action="{{ route('admin.decor_orders.update', $order->id) }}" method="POST">
    @csrf
    @method('PUT')

    <!-- Šventės data -->
    <div class="form-group">
        <label for="event_date">Šventės data *</label>
        <input type="date" class="form-control" id="event_date" name="event_date" value="{{ $order->event_date }}" required>
    </div>

    <!-- Lokacija -->
    <div class="form-group">
        <label for="location">Lokacija *</label>
        <input type="text" class="form-control" id="location" name="location" value="{{ $order->location }}" required>
    </div>

    <!-- Svečių skaičius -->
    <div class="form-group">
        <label for="guests_count">Svečių skaičius</label>
        <input type="number" class="form-control" id="guests_count" name="guests_count" value="{{ $order->guests_count }}" min="0">
    </div>

    <!-- Stalų skaičius -->
    <div class="form-group">
        <label for="tables_count">Stalų skaičius</label>
        <input type="number" class="form-control" id="tables_count" name="tables_count" value="{{ $order->tables_count }}" min="0">
    </div>

    <!-- Pasirinkite paketą -->
    <div class="form-group">
        <label for="package">Pasirinkite paketą</label>
        <select class="form-control" id="package" name="package" required>
            <option value="mini" {{ $order->package == 'mini' ? 'selected' : '' }}>MINI</option>
            <option value="midi" {{ $order->package == 'midi' ? 'selected' : '' }}>MIDI</option>
            <option value="maxi" {{ $order->package == 'maxi' ? 'selected' : '' }}>MAXI</option>
        </select>
    </div>

    <!-- Nuotakos puokštė ir butonjerė -->
    <div class="form-group">
        <label for="flowers">Ar reikės nuotakos puokštės ir butonjerės?</label>
        <select class="form-control" id="flowers" name="flowers">
            <option value="no" {{ $order->flowers == 'no' ? 'selected' : '' }}>Ne</option>
            <option value="yes" {{ $order->flowers == 'yes' ? 'selected' : '' }}>Taip</option>
        </select>
    </div>

    <!-- Spalvinė gama -->
    <div class="form-group">
        <label for="color_scheme">Spalvinė gama</label>
        <input type="text" class="form-control" id="color_scheme" name="color_scheme" value="{{ $order->color_scheme }}">
    </div>

    <!-- Vestuvių stilistika -->
    <div class="form-group">
        <label for="style">Vestuvių stilistika</label>
        <select class="form-control" id="style" name="style">
            <option value="classic" {{ $order->style == 'classic' ? 'selected' : '' }}>Klasika</option>
            <option value="boho" {{ $order->style == 'boho' ? 'selected' : '' }}>Boho</option>
            <option value="provence" {{ $order->style == 'provence' ? 'selected' : '' }}>Provence</option>
            <option value="exotic" {{ $order->style == 'exotic' ? 'selected' : '' }}>Egzotika</option>
            <option value="other" {{ $order->style == 'other' ? 'selected' : '' }}>Kita</option>
        </select>
    </div>

    <!-- Preliminarus biudžetas -->
    <div class="form-group">
        <label for="budget">Preliminarus biudžetas *</label>
        <input type="number" class="form-control" id="budget" name="budget" value="{{ $order->budget }}" required>
    </div>

    <!-- Vardas -->
    <div class="form-group">
        <label for="name">Jūsų vardas *</label>
        <input type="text" class="form-control" id="name" name="name" value="{{ $order->name }}" required>
    </div>

    <!-- El. paštas -->
    <div class="form-group">
        <label for="email">Jūsų el. paštas *</label>
        <input type="email" class="form-control" id="email" name="email" value="{{ $order->email }}" required>
    </div>
<!-- Užsakymo statusas -->
<div class="form-group mt-4">
    <label for="status">Užsakymo statusas</label>
    <select class="form-control" id="status" name="status" required>
        <option value="pateiktas" {{ $order->status == 'pateiktas' ? 'selected' : '' }}>Pateiktas</option>
        <option value="vykdomas" {{ $order->status == 'vykdomas' ? 'selected' : '' }}>Vykdomas</option>
        <option value="atliktas" {{ $order->status == 'atliktas' ? 'selected' : '' }}>Atliktas</option>
        <option value="atmestas" {{ $order->status == 'atmestas' ? 'selected' : '' }}>Atmestas</option>
    </select>
</div>

<div class="form-group mt-3" id="rejection_reason_group" style="display: none;" required>
    <label for="rejection_reason">Atmetimo priežastis *</label>
    <textarea class="form-control" id="rejection_reason" name="rejection_reason" rows="3"></textarea>
</div>
    <!-- Kiti komentarai -->
    <div class="form-group">
        <label for="comments">Kiti komentarai nuo jaunųjų</label>
        <textarea class="form-control" id="comments" name="comments" rows="4">{{ $order->comments }}</textarea>
    </div>

        <div class="d-flex justify-content-between gap-2 mt-4">
            <a href="{{ route('admin.decor_orders.show', $order->id) }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Grįžti
            </a>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-2"></i> Išsaugoti pakeitimus
            </button>
        </div>
    </form>

</form>

<script>
    const statusSelect = document.getElementById('status');
    const rejectionGroup = document.getElementById('rejection_reason_group');

    function toggleRejectionReason() {
        if (statusSelect.value === 'atmestas') {
            rejectionGroup.style.display = 'block';
        } else {
            rejectionGroup.style.display = 'none';
        }
    }

    statusSelect.addEventListener('change', toggleRejectionReason);
    window.addEventListener('load', toggleRejectionReason);
</script>
</div>
@endsection
