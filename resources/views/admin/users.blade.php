@extends('layouts.app')

@section('title', 'Vartotojų valdymas')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Vartotojų valdymas</h1>
        </div>
    </div>
</header>

<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            <div class="p-5 mb-3 bg-white border text-center text-gray">
                <h5 class="mb-0">Sveiki, {{ Auth::user()->name }}!</h5>
            </div>
            <div class="list-group">
                <a href="/dashboard" class="list-group-item list-group-item-action">
                    <i class="fas fa-tachometer-alt me-2"></i> Skydelis
                </a>
                <a href="/admin/users" class="list-group-item list-group-item-action active">
                    <i class="fas fa-users me-2"></i> Vartotojai 
                </a>
                <a href="/admin/orders" class="list-group-item list-group-item-action">
                    <i class="fas fa-box-open me-2"></i> Užsakymų valdymas
                </a>
                <a href="/admin/coupons" class="list-group-item list-group-item-action logout-link" style="border-radius: 0;">
                <i class="fas fa-gift me-2"></i> Dovanų kuponų valdymas
                </a>
                <a href="/admin/reviews" class="list-group-item list-group-item-action">
                    <i class="fas fa-comments me-2"></i> Atsiliepimų moderavimas
                </a>
                <a href="#" class="list-group-item list-group-item-action logout-link"
                   onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Atsijungti
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <div class="col-md-9">
            <h2>Vartotojų sąrašas</h2>

            <form method="GET" action="/admin/users" class="mb-4 d-flex align-items-end gap-3">
                <label for="role">Filtruoti pagal rolę:</label>
                <select name="role" id="role" onchange="this.form.submit()" class="form-select w-auto d-inline-block">
                    <option value="">Visi</option>
                    <option value="admin" {{ request('role') == 'admin' ? 'selected' : '' }}>Administratoriai</option>
                    <option value="user" {{ request('role') == 'user' ? 'selected' : '' }}>Paprasti vartotojai</option>
                    <option value="courier" {{ request('role') == 'courier' ? 'selected' : '' }}>Kurjeriai</option>
                </select>
            </form>

            <div class="row">
                @forelse($users as $user)
                    <div class="col-md-12 mb-4">
                        <div class="card-glass p-4">
                        <div class="ribbon {{ $user->role }}">
                            @switch($user->role)
                                @case('admin')
                                    <i class="fas fa-user-shield me-1"></i> Administratorius
                                    @break
                                @case('user')
                                    <i class="fas fa-user me-1"></i> Vartotojas
                                    @break
                                @case('courier')
                                    <i class="fas fa-shipping-fast me-1"></i> Kurjeris
                                    @break
                                @default
                                    <i class="fas fa-question me-1"></i> Nežinoma rolė
                            @endswitch
                        </div>
                            <h5>Vartotojo ID: <span class="text-success">#{{ $user->id }}</span></h5>
                            <p><strong>Vardas:</strong> {{ $user->name }}</p>
                            <p><strong>El. paštas:</strong> {{ $user->email }}</p>
                            <p><strong>Užsakymų skaičius:</strong> {{ $user->orders_count }}</p>
                            <p><strong>Atsiliepimų skaičius:</strong> {{ $user->reviews_count }}</p>
                            <a href="{{ route('admin.users.edit', $user->id) }}" class="btn btn-outline-success btn-sm">Valdyti paskyrą</a>
                        </div>
                    </div>
                @empty
                <div class="alert alert-info mb-0 text-center">Vartotojų nerasta.</div>
                @endforelse
                <div class="mt-4">
                    {{ $users->appends(request()->query())->links() }}
                </div>

            </div>
        </div>
    </div>
</div>
@endsection
