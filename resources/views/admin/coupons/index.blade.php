@extends('layouts.app')

@section('title', 'Dovanų kuponų valdymas')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Užsakymų valdymas</h1>
        </div>
    </div>
</header>

<div class="container my-5">
    <div class="row">
        <!-- Šoninis meniu -->
        <div class="col-md-3">
            <div class="p-5 mb-3 bg-white border text-center text-gray" style="border-radius: 0;">
                <h5 class="mb-0">Sveiki, {{ Auth::user()->name }}!</h5>
            </div>
            <div class="list-group">
                <a href="/dashboard" class="list-group-item list-group-item-action" style="border-radius: 0;">
                    <i class="fas fa-tachometer-alt me-2"></i> Skydelis
                </a>
                <a href="/admin/users" class="list-group-item list-group-item-action" style="border-radius: 0;">
                    <i class="fas fa-users me-2"></i> Vartotojai 
                </a>
                <a href="/admin/orders" class="list-group-item list-group-item-action" style="border-radius: 0;">
                    <i class="fas fa-box-open me-2"></i> Užsakymų valdymas
                </a>
                <a href="/admin/coupons" class="list-group-item list-group-item-action active" style="border-radius: 0;">
                <i class="fas fa-gift me-2"></i> Dovanų kuponų valdymas
                </a>
                <a href="/admin/reviews" class="list-group-item list-group-item-action" style="border-radius: 0;">
                    <i class="fas fa-comments me-2"></i> Atsiliepimų moderavimas
                </a>
                <a href="/admin/special_offers" class="list-group-item list-group-item-action logout-link" style="border-radius: 0;">
                    <i class="fas fa-tags me-2"></i> Akcijų valdymas
                </a>
                <a href="/admin/decor_orders" class="list-group-item list-group-item-action logout-link" style="border-radius: 0;">
                    <i class="fas fa-swatchbook me-2"></i> Dekoravimo užklausos
                </a>
                <a href="#" class="list-group-item list-group-item-action logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="border-radius: 0;">
                    <i class="fas fa-sign-out-alt"></i> Atsijungti
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <div class="col-md-9">
            <h2>Dovanų kuponai</h2>

            <div class="d-flex justify-content-between align-items-end mb-4">
                <form method="GET" action="/admin/coupons" class="d-flex align-items-end gap-3">
                    <label for="used">Filtruoti pagal statusą:</label>
                    <select name="used" id="used" onchange="this.form.submit()" class="form-select w-auto d-inline-block">
                        <option value="">Visi</option>
                        <option value="1" {{ request('used') == '1' ? 'selected' : '' }}>Panaudoti</option>
                        <option value="0" {{ request('used') == '0' ? 'selected' : '' }}>Nepanauduoti</option>
                    </select>
                </form>

                <a href="{{ route('admin.coupons.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-1"></i> Naujas kuponas
                </a>
            </div>

            <div class="row">
            @forelse($coupons as $coupon)
                <div class="col-md-12 mb-4">
                    <div class="card-glass p-4">
                    <div class="ribbon {{ $coupon->used ? 'panaudotas' : 'nepanaudotas' }}">
                        @if($coupon->used)
                            <i class="fas fa-check-circle me-1"></i> Panaudotas
                        @else
                            <i class="fas fa-gift me-1"></i> Nepanaudotas
                        @endif
                    </div>

                        <h5>Kupono ID: <span class="text-success">{{ $coupon->id }}</span></h5>

                        <p><strong>Užsakymo ID:</strong>  
                            @if($coupon->order_id)
                                <a href="{{ route('admin.orders.show', $coupon->order_id) }}">#{{ $coupon->order_id }}</a>
                            @else
                                —
                            @endif
                        </p>

                        <p><strong>Kupono kodas:</strong> {{ $coupon->code }}</p>
                        <p><strong>Vertė:</strong> {{ number_format($coupon->value, 2) }} €</p>
                        <p><strong>Sukurtas:</strong> {{ $coupon->created_at->format('Y-m-d') }}</p>
                        <p><strong>Statusas:</strong> 
                            @if($coupon->used)
                                <span class="text-danger">Panaudotas</span>
                            @else
                                <span class="text-success">Nepanaudotas</span>
                            @endif
                        </p>
                        <a href="{{ route('admin.coupons.edit', $coupon->id) }}" class="btn btn-outline-success btn-sm">
                            <i class="fas fa-edit me-1"></i> Valdyti dovanų kuponą
                        </a>

                    </div>
                </div>
            @empty
                <div class="alert alert-info mb-0 text-center">Šiuo metu nėra jokių dovanų kuponų.</div>
            @endforelse
                            <p class="text-muted text-center mt-4">
                    Rodoma {{ $coupons->firstItem() }}–{{ $coupons->lastItem() }} iš {{ $coupons->total() }} dovanų kuponų
                </p>  
            <div class="mt-4">
    {{ $coupons->appends(request()->query())->links() }}
</div>

            </div>
            </div>
            </div>
</div>
@endsection

