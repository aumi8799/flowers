@extends('layouts.app')

@section('title', 'Redaguoti vartotoją')

@section('content')
<div class="container my-5">
    <h2>Redaguoti vartotoją</h2>

    <form method="POST" action="{{ route('admin.users.update', $user->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="name" class="form-label">Vardas</label>
            <input type="text" name="name" id="name" value="{{ $user->name }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="email" class="form-label">El. paštas</label>
            <input type="email" name="email" id="email" value="{{ $user->email }}" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="password" class="form-label">Naujas slaptažodis (palikite tuščią, jei nekeisite)</label>
            <input type="password" name="password" id="password" class="form-control">
        </div>

        <div class="mb-3">
            <label for="role" class="form-label">Rolė</label>
            <select name="role" id="role" class="form-select">
                <option value="user" {{ $user->role == 'user' ? 'selected' : '' }}>Vartotojas</option>
                <option value="admin" {{ $user->role == 'admin' ? 'selected' : '' }}>Administratorius</option>
                <option value="courier" {{ $user->role == 'courier' ? 'selected' : '' }}>Kurjeris</option>
            </select>
        </div>

        <div class="d-flex justify-content-between gap-2 mt-4">
            <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-left me-2"></i> Grįžti
            </a>

            <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-2"></i> Išsaugoti pakeitimus
            </button>

            <button type="button" class="btn btn-danger"
                    onclick="if(confirm('Ar tikrai norite ištrinti šią paskyrą?')) document.getElementById('delete-user-form').submit();">
                <i class="fas fa-trash me-2"></i> Ištrinti paskyrą
            </button>
        </div>
    </form>

    <form id="delete-user-form" method="POST" action="{{ route('admin.users.destroy', $user->id) }}" style="display: none;">
        @csrf
        @method('DELETE')
    </form>
</div>
@endsection
