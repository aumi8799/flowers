@extends('layouts.app')

@section('title', 'Naujas vartotojas')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px;">
    <div class="container text-center text-white">
        <h1 class="display-4 fw-bolder">Sukurti naują vartotoją</h1>
    </div>
</header>

<div class="container my-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card p-4 shadow">
                <h4 class="mb-4">Naujo vartotojo forma</h4>

                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul class="mb-0">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <form method="POST" action="{{ route('admin.user_store') }}">
                    @csrf

                    <div class="mb-3">
                        <label for="name" class="form-label">Vardas</label>
                        <input type="text" class="form-control" id="name" name="name" required value="{{ old('name') }}">
                    </div>

                    <div class="mb-3">
                        <label for="email" class="form-label">El. paštas</label>
                        <input type="email" class="form-control" id="email" name="email" required value="{{ old('email') }}">
                    </div>

                    <div class="mb-3">
                        <label for="password" class="form-label">Slaptažodis</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>

                    <div class="mb-3">
                        <label for="role" class="form-label">Rolė</label>
                        <select class="form-select" id="role" name="role" required>
                            <option value="user" {{ old('role') == 'user' ? 'selected' : '' }}>Vartotojas</option>
                            <option value="admin" {{ old('role') == 'admin' ? 'selected' : '' }}>Administratorius</option>
                            <option value="courier" {{ old('role') == 'courier' ? 'selected' : '' }}>Kurjeris</option>
                        </select>
                    </div>

                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('admin.users') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left me-1"></i> Atgal
                        </a>
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-plus me-1"></i> Sukurti vartotoją
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
