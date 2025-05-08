@extends('layouts.app')

@section('title', 'Užduotys')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Mano pristatymo užduotys</h1>
        </div>
    </div>
</header>

<div class="container my-5">
    <div class="row">
        <!-- Kairysis meniu -->
        <div class="col-md-3">
            <div class="p-5 mb-3 bg-white border text-center text-gray rounded-3">
                <h5 class="mb-0">Sveiki, {{ Auth::user()->name }}!</h5>
            </div>
            <div class="list-group">
                <a href="/dashboard" class="list-group-item list-group-item-action">
                    <i class="far fa-tachometer-alt"></i> Skydelis
                </a>
                <a href="/courier/tasks" class="list-group-item list-group-item-action active">
                    <i class="far fa-clipboard-list"></i> Užduotys
                </a>
                <a href="#" class="list-group-item list-group-item-action logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                    <i class="fas fa-sign-out-alt"></i> Atsijungti
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;"> @csrf </form>
            </div>
        </div>

        <!-- Pagrindinis turinys -->
        <div class="col-md-9">
            <h2 class="mb-4">Mano užduotys</h2>

            @if(!empty($summary))
            <div class="row mb-4">
                <div class="col-md-3">
                    <div class="card border-start border-primary border-5 shadow-sm h-100 p-3 text-center rounded-3">
                        <h6 class="text-muted">Viso užduočių</h6>
                        <h4 class="fw-bold">{{ $summary['total'] }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-start border-info border-5 shadow-sm h-100 p-3 text-center rounded-3">
                        <h6 class="text-muted">Šiandienai</h6>
                        <h4 class="fw-bold">{{ $summary['today'] }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-start border-warning border-5 shadow-sm h-100 p-3 text-center rounded-3">
                        <h6 class="text-muted">Reikia pristatyti</h6>
                        <h4 class="fw-bold">{{ $summary['to_deliver'] }}</h4>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="card border-start border-success border-5 shadow-sm h-100 p-3 text-center rounded-3">
                        <h6 class="text-muted">Pristatyta</h6>
                        <h4 class="fw-bold">{{ $summary['delivered'] }}</h4>
                    </div>
                </div>
                <div class="col-md-3 mt-3">
                    <div class="card border-start border-danger border-5 shadow-sm h-100 p-3 text-center rounded-3">
                        <h6 class="text-muted">Vėluoja</h6>
                        <h4 class="fw-bold text-danger">{{ $summary['late'] }}</h4>
                    </div>
                </div>
            </div>
            @endif

            <form method="GET" action="{{ route('courier.tasks') }}" class="mb-4">
                <label for="status" class="me-2">Filtruoti pagal būseną:</label>
                <select name="status" id="status" onchange="this.form.submit()" class="form-select w-auto d-inline-block">
                    <option value="">Visos užduotys</option>
                    <option value="apmokėtas" {{ request('status') == 'apmokėtas' ? 'selected' : '' }}>Reikia pristatyti</option>
                    <option value="pristatytas" {{ request('status') == 'pristatytas' ? 'selected' : '' }}>Pristatytos</option>
                </select>
            </form>

            @forelse($orders as $date => $dailyOrders)
                <h4 class="mb-3 mt-5">
                    <i class="fas fa-calendar-alt text-primary me-2"></i>
                    {{ \Carbon\Carbon::parse($date)->translatedFormat('Y-m-d') }}
                </h4>

                <div class="row">
                    @foreach($dailyOrders as $order)
                    <div class="col-md-12 mb-4">
                        <div class="card-glass p-4 {{ $order->is_late ? 'border border-danger' : '' }} rounded-3 shadow-sm">
                            <div class="ribbon {{ $order->status }}">
                                @switch($order->status)
                                    @case('apmokėtas')
                                        <i class="fas fa-euro-sign"></i> Reikia pristatyti
                                        @break
                                    @case('pristatytas')
                                        <i class="fas fa-truck"></i> Pristatyta
                                        @break
                                    @default
                                        <i class="fas fa-info-circle"></i> {{ ucfirst($order->status) }}
                                @endswitch
                            </div>

                            <div class="card-body">
                                <h5 class="card-title mb-2">Užsakymo ID: <strong>#{{ $order->id }}</strong></h5>
                                <p class="mb-1"><strong>Pristatymo miestas:</strong>
                                    @if($order->delivery_city == 7)
                                        Vilnius
                                    @elseif($order->delivery_city == 10)
                                        Kaunas
                                    @else
                                        Kitas
                                    @endif
                                </p>
                                <div class="row">
                                    <div class="col-md-6"><strong>Pristatymo data:</strong> {{ $order->delivery_date ?? '–' }}</div>
                                    <div class="col-md-6"><strong>Pristatymo laikas:</strong> {{ $order->delivery_time ?? '–' }}</div>
                                </div>
                                <p class="mb-2 mt-2"><strong>Statusas:</strong>
                                    @if($order->is_late ?? false)
                                        <span class="badge bg-danger">Vėluoja</span>
                                    @elseif($order->status == 'apmokėtas')
                                        <span class="badge bg-primary">Apmokėtas</span>
                                    @elseif($order->status == 'pristatytas')
                                        <span class="badge bg-success">Pristatytas</span>
                                    @else
                                        <span class="badge bg-secondary">{{ $order->status }}</span>
                                    @endif
                                </p>
                                <a href="{{ route('courier.show', $order->id) }}" class="btn btn-sm btn-outline-primary">Peržiūrėti</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            @empty
                <div class="alert alert-info">Šiuo metu nėra jokių užduočių.</div>
            @endforelse
        </div>
    </div>
</div>
@endsection
