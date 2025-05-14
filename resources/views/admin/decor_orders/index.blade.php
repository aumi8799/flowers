@extends('layouts.app')

@section('title', 'Dekoravimo užsakymai')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Dekoravimo užsakymai</h1>
        </div>
    </div>
</header>

<div class="container my-5">
    <div class="row">
        <div class="col-md-3">
            <div class="p-5 mb-3 bg-white border text-center text-gray" style="border-radius: 0;">
                <h5 class="mb-0">Sveiki, {{ Auth::user()->name }}!</h5>
            </div>
            <div class="list-group">
                <a href="/dashboard" class="list-group-item list-group-item-action"><i class="fas fa-tachometer-alt me-2"></i> Skydelis</a>
                <a href="/admin/users" class="list-group-item list-group-item-action"><i class="fas fa-users me-2"></i> Vartotojai</a>
                <a href="/admin/orders" class="list-group-item list-group-item-action"><i class="fas fa-box-open me-2"></i> Užsakymų valdymas</a>
                <a href="/admin/coupons" class="list-group-item list-group-item-action"><i class="fas fa-gift me-2"></i> Dovanų kuponų valdymas</a>
                <a href="/admin/reviews" class="list-group-item list-group-item-action"><i class="fas fa-comments me-2"></i> Atsiliepimų moderavimas</a>
                <a href="/admin/special_offers" class="list-group-item list-group-item-action"><i class="fas fa-tags me-2"></i> Akcijų valdymas</a>
                <a href="/admin/decor_orders" class="list-group-item list-group-item-action active"><i class="fas fa-swatchbook me-2"></i> Dekoravimo užklausos</a>
                <a href="#" class="list-group-item list-group-item-action logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"><i class="fas fa-sign-out-alt me-2"></i> Atsijungti</a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">@csrf</form>
            </div>
        </div>

        <div class="col-md-9">
            <h2>Užsakymų sąrašas</h2>

            
            <div class="row">
                @forelse($orders as $order)
                    <div class="col-md-12 mb-4">
                        <div class="card-glass p-4">
                            <h5>Užsakymo ID: <span class="text-success">#{{ $order->id }}</span></h5>
                            <p><strong>Vardas:</strong> {{ $order->name }}</p>
                            <p><strong>El. paštas:</strong> {{ $order->email }}</p>
                            <p><strong>Data:</strong> {{ $order->event_date }}</p>
                            <p><strong>Biudžetas:</strong> {{ $order->budget }} €</p>
                            <p><strong>Paketas:</strong> {{ ucfirst($order->package) }}</p>
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
                            <a href="{{ route('admin.decor_orders.show', $order->id) }}" class="btn btn-outline-primary btn-sm">Peržiūrėti</a>
                        </div>
                    </div>
                @empty
                    <div class="alert alert-info mb-0 text-center">Užsakymų nerasta.</div>
                @endforelse

                <p class="text-muted text-center mt-4">
                    Rodoma {{ $orders->firstItem() }}–{{ $orders->lastItem() }} iš {{ $orders->total() }} užsakymų
                </p>

                <div class="mt-4">
                    {{ $orders->appends(request()->query())->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
