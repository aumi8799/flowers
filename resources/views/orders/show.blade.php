@extends('layouts.app')

@section('title', 'Užsakymo detalės')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Užsakymo #{{ $order->id }} detalės</h1>
            <a href="{{ route('orders.index') }}" class="lead fw-normal text-dark-gray mb-0 text-decoration-none" style="cursor: pointer;">
            <i class="fas fa-arrow-left"></i> Grįžti į mano užsakymus </a>
            </div>
    </div>
</header>

    <div class="container my-5">
        @if(session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        @if(empty($order))
            <div class="text-center my-5">
                <img src="{{ asset('images/order-empty.png') }}" alt="Tuščias užsakymas" class="img-fluid" style="max-width: 150px;">
                <p class="mt-3">Nėra užsakymo #{{ $order->id }}informacijos</p>
            </div>
        @else
            <div class="row">
                <div class="col-md-8">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Prekė</th>
                                <th></th>
                                <th>Kiekis</th>   
                                <th>Suma</th>
                                <th>Atvirukas</th>
                             

                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $totalPrice = 0;
                            @endphp

                            @foreach($order->items as $item)
                                @php
                                    $itemTotal = $item->price * $item->quantity;
                                    $totalPrice += $itemTotal;
                                @endphp
                                <tr>
                                    <td>
                                        <img src="{{ asset('images/products/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="img-fluid" style="max-width: 80px; height: 80px;">
                                    </td>
                                    <td class="align-middle">{{ $item->product->name }}</td>
                                    <td class="align-middle">{{ $item->quantity }}</td>
                                    <td class="align-middle">{{ $itemTotal }} €</td>
                                    <td class="align-middle">
                                    @if($item->postcard)
                                    <i class="fas fa-check-circle" style="color: green; font-size: 1.5rem;"></i>
                                @else
                                    <i class="fas fa-times-circle" style="color: gray; font-size: 1.5rem;"></i>
                                @endif
                            </td>
                                </tr>
                            @endforeach
                            {{-- Individualios puokštės atvaizdavimas --}}
                                @foreach($order->bouquets as $bouquet)
                                    @php
                                        $bouquetItems = json_decode($bouquet->bouquet_data, true);
                                        $totalPrice += $bouquet->total_price;
                                    @endphp
                                    <tr>
                                        <td>
                                        <strong>Individuali puokštė</strong><br>
                                        </td>
                                        <td class="align-middle">
                                            @foreach($bouquetItems as $flower)
                                                - {{ $flower['name'] }} ({{ $flower['quantity'] }} vnt.)<br>
                                            @endforeach
                                        </td>
                                        <td class="align-middle">1</td>
                                        <td class="align-middle">{{ $bouquet->total_price }} €</td>
                                        <td class="align-middle">
                                            @if($order->postcard)
                                                <i class="fas fa-check-circle" style="color: green; font-size: 1.5rem;"></i>
                                            @else
                                                <i class="fas fa-times-circle" style="color: gray; font-size: 1.5rem;"></i>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach

                            {{-- Prenumeratos atvaizdavimas tokiu pačiu stiliumi kaip krepšelyje --}}
                            @foreach($order->subscriptions as $subscription)
                                @php
                                    $subscriptionTotal = $subscription->price;
                                    $totalPrice += $subscriptionTotal;

                                    $startDate = $subscription->start_date ? new DateTime($subscription->start_date) : null;
                                    $endDate = null;
                                    if ($startDate) {
                                        $endDate = clone $startDate;
                                        $endDate->modify('+' . $subscription->duration . ' months');
                                    }
                                @endphp
                                <tr>
                                    <td>
                                    <strong>Gėlių prenumerata</strong><br>                                    </td>
                                    <td class="align-middle">
                                        <br>
                                        Kategorija: {{ ucfirst($subscription->category) }}<br>
                                        Dydis: {{ $subscription->size }}<br>
                                    </td>
                                    <td class="align-middle">1</td>
                                    <td class="align-middle">{{ $subscriptionTotal }} €</td>
                                </tr>
                            @endforeach
                            {{-- Dovanų kuponai --}}
@if($order->giftCoupons && $order->giftCoupons->count() > 0)
    <tr>
        <td colspan="5"><strong>Dovanų kuponai</strong></td>
    </tr>
    @foreach($order->giftCoupons as $coupon)
        <tr>
            <td>Dovanų kuponas</td>
            <td>1</td>
            <td>{{ number_format($coupon->value, 2) }} €</td>
            <td>
                <strong>Kodas:</strong> {{ $coupon->code }}<br>
                <strong>Būsena:</strong>
                @if($coupon->used)
                    <span class="text-danger">Panaudotas</span>
                @else
                    <span class="text-success">Nepanaudotas</span>
                @endif
            </td>
        </tr>
    @endforeach
@endif

                        </tbody>
                    </table>
                </div>

                <div class="col-md-4">
    <div class="border p-3 rounded">
        <h2>Užsakymo ID: #{{ $order->id }}</h2>
        <hr>
        <h5 style="font-weight: normal; font-size: 1rem;">Būsena:</h5>
        <div class="mb-3">
            <strong>{{ $order->status }}</strong>
        </div>
        @if ($order->cancel_reason)
            <hr>
            <h5 style="font-weight: normal; font-size: 1rem;">Priežastis:</h5>
            <div class="mb-3">
                <strong>{{ $order->cancel_reason }}</strong>
            </div>
        @endif
        <hr>
        @if($order->status === 'rezervuotas')
            <h5 style="font-weight: normal; font-size: 1rem;">Rezervacijos laikas:</h5>
            <div class="mb-3">
                <strong>{{ $order->created_at->format('Y-m-d H:i:s') }}</strong>
            </div>
            <hr>
        @endif

        <!-- Pirkėjo duomenys -->
        <h5 style="font-weight: normal; font-size: 1rem;">Pirkėjo informacija:</h5>
        <div class="mb-3">
            <strong>Vardas:</strong> {{ $order->first_name }}<br>
            <strong>Pavardė:</strong> {{ $order->last_name }}<br>
            <strong>Telefono numeris:</strong> {{ $order->phone }}<br>
            <strong>El. paštas:</strong> {{ $order->email }}<br>
        <hr>
        <h5 style="font-weight: normal; font-size: 1rem;">Papildoma informacija:</h5>
        <strong>Pastabos:</strong> {{ $order->notes ?? 'Nėra pastabų' }}<br>
        @if($order->video == 1) 
            <strong>Pristatymo vaizdo įrašas:</strong> Užsakytas (+5 eur)<br>
        @else
            <strong>Pristatymo vaizdo įrašas:</strong> Ne užsakytas<br>
        @endif
        @if($order->status === 'pristatytas' && $order->video == 1)
                <hr>
                <h5 style="font-weight: normal; font-size: 1rem;">Galite peržiūrėti arba atsisiųsti vaizdo įrašą:</h5>
                <div class="mb-3">
                    <div class="d-flex gap-1">
                        <!-- Peržiūros nuoroda -->
                        <a href="{{ asset('storage/' . $order->video_path) }}" class="btn btn-primary" target="_blank">
                            <i class="fas fa-video"></i> Peržiūrėti vaizdo įrašą
                        </a>
                        <!-- Atsisiuntimo nuoroda -->
                        <a href="{{ asset('storage/' . $order->video_path) }}" download class="btn btn-secondary">
                            <i class="fas fa-download"></i> Atsisiųsti vaizdo įrašą
                        </a>
                    </div>
                </div>
        @endif
        <hr>
        <h5 style="font-weight: normal; font-size: 1rem;">Pristatymo adresas:</h5>
        <div class="mb-3">
            <strong> Pristatymo miestas: 
                @if($order->delivery_city == 7)
                    Vilnius
                @elseif($order->delivery_city == 10)
                    Kaunas
                @else
                    Nenurodytas miestas
                @endif
            </strong><br>
            <strong>Pristatymo adresas:</strong> {{ $order->delivery_address }}<br>
            <strong>Pašto kodas:</strong> {{ $order->postal_code }}<br>
        </div>
        <hr>
       
<h5 style="font-weight: normal; font-size: 1rem;">Pristatymo data ir laikas:</h5>
<div class="mb-3">
    <strong>Data:</strong>
    {{ $order->delivery_date ? \Carbon\Carbon::parse($order->delivery_date)->format('Y-m-d') : 'Nenurodyta' }}<br>
    <strong>Laikas:</strong>
    {{ $order->delivery_time ?? 'Nenurodytas' }}
</div>
<hr>
        <div style="text-align: right;">
            <h5 style="font-weight: normal; font-size: 1rem;">Pristatymo išlaidos: {{ $order->delivery_city }} €</h5>
            <h5 style="font-weight: normal; font-size: 1rem;">Bendra suma: <span id="total-cost">{{ $order->total_price }}</span> €</h5>
        </div>
        <div class="d-flex justify-content-end gap-2 mt-4">
            @if($order->status === 'rezervuotas')
                <div class="d-flex justify-content-end gap-2 mt-4">

                    <form action="{{ route('checkout.show') }}" method="GET">
                        <input type="hidden" name="total" value="{{ $order->total_price }}">
                        <input type="hidden" name="city" value="{{ $order->delivery_city }}">
                        <input type="hidden" name="order_id" value="{{ $order->id }}">
                        <button type="submit" class="btn btn-green">Apmokėti</button>
                    </form>

                    {{-- Redagavimo mygtukas --}}
                    <form action="{{ route('orders.edit', $order->id) }}" method="GET">
                        <button type="submit" class="btn btn-dark">Redaguoti</button>
                    </form>

                    {{-- Atšaukimo mygtukas --}}
                    <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Ar tikrai norite atšaukti šį užsakymą?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Atšaukti rezervaciją</button>
                    </form>
                </div>
            @endif
            @if($order->status === 'pristatytas' && !$order->review)
                                <a href="{{ route('reviews.create', $order->id) }}" class="btn btn-sm btn-outline-primary mt-2">Rašyti atsiliepimą</a>
                            @endif
        </div>
    </div>
</div>

            </div>
        @endif
    </div>
@endsection
