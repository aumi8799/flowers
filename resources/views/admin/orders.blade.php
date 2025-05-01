@extends('layouts.app')

@section('title', 'Užsakymų valdymas')
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
                <a href="/admin/orders" class="list-group-item list-group-item-action active" style="border-radius: 0;">
                    <i class="fas fa-box-open me-2"></i> Užsakymų valdymas
                </a>
                <a href="/admin/reviews" class="list-group-item list-group-item-action" style="border-radius: 0;">
                    <i class="fas fa-comments me-2"></i> Atsiliepimų moderavimas
                </a>
                <a href="#" class="list-group-item list-group-item-action logout-link" onclick="event.preventDefault(); document.getElementById('logout-form').submit();" style="border-radius: 0;">
                    <i class="fas fa-sign-out-alt"></i> Atsijungti
                </a>
                <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                    @csrf
                </form>
            </div>
        </div>

        <!-- Turinio sritis -->
        <div class="col-md-9">
            <h2>Vartotojų užsakymai</h2>

            <form method="GET" action="/admin/orders" class="mb-4 d-flex align-items-end gap-3">
                <label for="status">Filtruoti pagal būseną:</label>
                <select name="status" id="status" onchange="this.form.submit()" class="form-select w-auto d-inline-block">
                    <option value="">Visi</option>
                    <option value="rezervuotas" {{ request('status') == 'rezervuotas' ? 'selected' : '' }}>Rezervuoti</option>
                    <option value="apmokėtas" {{ request('status') == 'apmokėtas' ? 'selected' : '' }}>Apmokėti</option>
                    <option value="pristatytas" {{ request('status') == 'pristatytas' ? 'selected' : '' }}>Pristatyti</option>
                    <option value="atšauktas" {{ request('status') == 'atšauktas' ? 'selected' : '' }}>Atšaukti</option>
                </select>
            </form>

            @if($orders->isEmpty())
                <div class="alert alert-info text-center">
                    Šiuo metu nėra tokių užsakymų.
                </div>
            @else           
                    <div class="row">
                    @foreach($orders as $order)
                    <div class="col-md-12 mb-4">
                                <div class="card-glass p-4">
                                    <div class="ribbon {{ $order->status }}">
                                        @switch($order->status)
                                            @case('rezervuotas')
                                                <i class="fas fa-clock"></i>
                                                @break
                                            @case('apmokėtas')
                                                <i class="fas fa-euro-sign"></i>
                                                @break
                                            @case('pristatytas')
                                                <i class="fas fa-truck"></i>
                                                @break
                                            @case('atšauktas')
                                                <i class="fas fa-times-circle"></i>
                                                @break
                                            @default
                                                <i class="fas fa-info-circle"></i>
                                        @endswitch
                                        {{ ucfirst($order->status) }}
                                    </div>
                                
                                    <h5>
                                        Užsakymo ID: 
                                        <a href="" class="text-success">#{{ $order->id}}</a>
                                    </h5>
                                    <h5>
                                        Pirkėjo paskyra: 
                                        <a href="" class="text-success">{{ $order->user->name ?? 'Nežinomas' }}</a>
                                    </h5>
                            
                                    <p class="mb-1">
                                        <strong>Pristatymo adresas:</strong>
                                        @if($order->delivery_city == 7)
                                            Vilnius
                                        @elseif($order->delivery_city == 10)
                                            Kaunas
                                        @else
                                            Nenurodytas miestas
                                        @endif
                                    </p>

                                    @if($order->status === 'rezervuotas')
                                        <p class="mb-1"><strong>Rezervacijos pateikimo laikas:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                                        @elseif ($order->status === 'apmokėtas')
                                        <p class="mb-1"><strong>Apmokėjimo laikas:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                                        
                                    @endif

                                    @if ($order->cancel_reason)
                                        <p class="mb-1"><strong>Priežastis:</strong> {{ $order->cancel_reason }}</p>
                                    @endif

                                    <p class="mb-2"><strong>Užsakymo kaina:</strong> {{ $order->total_price }} €</p>

                                    <a href="{{ route('admin.orders.show', $order->id) }}" class="btn btn-outline-success btn-sm">
    Peržiūrėti detales
</a>                                   
                                </div>
                            </div>

                    @endforeach
                    </div>

                        </div>



                {{ $orders->links() }}
            @endif
        </div>
    </div>
</div>
@endsection
