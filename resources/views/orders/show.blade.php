@extends('layouts.app')

@section('title', 'Užsakymo detalės')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Užsakymo #{{ $order->id }} detalės</h1>
            <a href="{{ route('orders.index') }}" class="lead fw-normal text-dark-gray mb-0 text-decoration-none" style="cursor: pointer;">
                <i class="fas fa-arrow-left"></i> Grįžti į mano užsakymus
            </a>
        </div>
    </div>
</header>

<div class="container my-5">
    @if(session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif
    
    @php
        $totalPrice = 0;
    @endphp
    
    @if(empty($order))
        <div class="text-center my-5">
            <img src="{{ asset('images/order-empty.png') }}" alt="Tuščias užsakymas" class="img-fluid" style="max-width: 150px;">
            <p class="mt-3">Nėra užsakymo #{{ $order->id }} informacijos</p>
        </div>
    @else
    <div class="row">
        <div class="col-md-8">
            {{-- Produktai --}}
            @if($order->items->whereNotNull('product_id')->count())
            <h5 class="mt-4 text-primary">
                <i class="fas fa-shopping-basket me-2"></i> Produktai
            </h5>
            <div class="bg-light p-3 mb-4 rounded border border-primary shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-primary">
                            <tr>
                                <th>Prekė</th>
                                <th>Pavadinimas</th>
                                <th>Kiekis</th>
                                <th>Suma</th>
                                <th>Ar yra atvirukas</th>
                                <th>Atviruko informacija</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $totalPrice = 0; @endphp
                            @foreach ($order->items->whereNotNull('product_id') as $item)
                                @php
                                    $itemTotal = $item->price * $item->quantity;
                                    $totalPrice += $itemTotal;
                                @endphp
                                <tr>
                                    <td>
                                        <img src="{{ asset('images/products/' . ($item->product->image ?? 'default.png')) }}" class="img-fluid" style="max-width: 80px; height: 80px;">
                                    </td>
                                    <td class="align-middle">{{ $item->product->name ?? 'Be pavadinimo' }}</td>
                                    <td class="align-middle">{{ $item->quantity }}</td>
                                    <td class="align-middle">{{ number_format($itemTotal, 2) }} €</td>
                                    <td class="align-middle">
                                        @if($item->postcard)
                                            <i class="fas fa-check-circle text-success fs-5"></i>
                                        @else
                                            <i class="fas fa-times-circle text-muted fs-5"></i>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if($item->postcard)
                                            @if($item->postcard->method === 'simple')
                                                <strong>Šablonas:</strong> {{ $item->postcard->template }}<br>
                                                <strong>Žinutė:</strong> {{ $item->postcard->message }}
                                            @elseif($item->postcard->method === 'canva')
                                                <strong>Canva failas:</strong>
                                                @if($item->postcard->file_path)
                                                    <a href="{{ asset($item->postcard->file_path) }}" target="_blank">Peržiūrėti</a>
                                                @else
                                                    Failas nepridėtas
                                                @endif
                                            @else
                                                <em>Nežinomas metodas</em>
                                            @endif
                                        @else
                                            <span class="text-muted">–</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif



        {{-- Individualios puokštės --}}
        @if($order->items->whereNotNull('custom_bouquet_id')->count())
            <h5 class="mt-4 text-warning">
                <i class="fas fa-seedling me-2"></i> Individualios puokštės
            </h5>
            <div class="bg-light p-3 mb-4 rounded border border-warning shadow-sm">
                <div class="table-responsive">
                    <table class="table table-hover align-middle">
                        <thead class="table-warning">
                            <tr>
                                <th>Sudėtis</th>
                                <th>Kiekis</th>
                                <th>Suma</th>
                                <th>Ar yra atvirukas</th>
                                <th>Atviruko informacija</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($order->items->whereNotNull('custom_bouquet_id') as $item)
                                @php
                                    $bouquet = $item->customBouquet;
                                    $bouquetItems = json_decode($bouquet->bouquet_data, true);
                                @endphp
                                <tr>
                                    <td class="align-middle">
                                        @foreach($bouquetItems as $flower)
                                            - {{ $flower['name'] }} ({{ $flower['quantity'] }} vnt.)<br>
                                        @endforeach
                                    </td>
                                    <td class="align-middle">{{ $item->quantity }}</td>
                                    <td class="align-middle">{{ number_format($item->price, 2) }} €</td>
                                    <td class="align-middle">
                                        @if($item->postcard)
                                            <i class="fas fa-check-circle text-success fs-5"></i>
                                        @else
                                            <i class="fas fa-times-circle text-muted fs-5"></i>
                                        @endif
                                    </td>
                                    <td class="align-middle">
                                        @if($item->postcard)
                                            @if($item->postcard->method === 'simple')
                                                <strong>Šablonas:</strong> {{ $item->postcard->template }}<br>
                                                <strong>Žinutė:</strong> {{ $item->postcard->message }}
                                            @elseif($item->postcard->method === 'canva')
                                                <strong>Canva failas:</strong>
                                                @if($item->postcard->file_path)
                                                    <a href="{{ asset($item->postcard->file_path) }}" target="_blank">Peržiūrėti</a>
                                                @else
                                                    Failas nepridėtas
                                                @endif
                                            @else
                                                <em>Nežinomas metodas</em>
                                            @endif
                                        @else
                                            <span class="text-muted">–</span>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
            {{-- Prenumeratos --}}
            @if($order->subscriptions->count())
                <h5 class="mt-4 text-info">
                    <i class="fas fa-sync-alt me-2"></i> Prenumeratos
                </h5>
                <div class="bg-light p-3 mb-4 rounded border border-info shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-info">
                                <tr>
                                    <th>Informacija</th>
                                    <th>Kiekis</th>
                                    <th>Kaina</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->subscriptions as $subscription)
                                    @php $totalPrice += $subscription->price; @endphp
                                    <tr>
                                        <td class="align-middle">
                                            Kategorija: {{ ucfirst($subscription->category) }}<br>
                                            Dydis: {{ $subscription->size }}<br>
                                            Trukmė: {{ $subscription->duration }} mėn.
                                        </td>
                                        <td class="align-middle">1</td>
                                        <td class="align-middle">{{ number_format($subscription->price, 2) }} €</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif

            {{-- Dovanų kuponai --}}
            @if($order->giftCoupons && $order->giftCoupons->count() > 0)
                <h5 class="mt-4 text-success">
                    <i class="fas fa-gift me-2"></i> Dovanų kuponai
                </h5>
                <div class="bg-light p-3 mb-4 rounded border border-success shadow-sm">
                    <div class="table-responsive">
                        <table class="table table-hover align-middle">
                            <thead class="table-success">
                                <tr>
                                    <th>Kodas</th>
                                    <th>Kiekis</th>
                                    <th>Vertė</th>
                                    <th>Būsena</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($order->giftCoupons as $coupon)
                                    <tr>
                                        <td class="align-middle">{{ $coupon->code }}</td>
                                        <td class="align-middle">1</td>
                                        <td class="align-middle">{{ number_format($coupon->value, 2) }} €</td>
                                        <td class="align-middle">
                                            @if($coupon->used)
                                                <span class="text-danger">Panaudotas</span>
                                            @else
                                                <span class="text-success">Nepanaudotas</span>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            @endif
        
        </div>

        {{-- Dešinysis stulpelis su užsakymo informacija --}}
        <div class="col-md-4">
            <div class="border p-3 rounded">
                <h2>Užsakymo ID: #{{ $order->id }}</h2>
                <hr>
                <p><strong>Būsena:</strong> {{ $order->status }}</p>
                @if ($order->cancel_reason)
                    <p><strong>Priežastis:</strong> {{ $order->cancel_reason }}</p>
                @endif

                @if($order->status === 'rezervuotas')
                    <hr>
                    <p><strong>Rezervuotas:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                @endif

                <hr>
                <h5>Pirkėjo informacija</h5>
                <p>
                    <strong>{{ $order->first_name }} {{ $order->last_name }}</strong><br>
                    Tel: {{ $order->phone }}<br>
                    El. paštas: {{ $order->email }}
                </p>

                <hr>
                <p><strong>Pastabos:</strong> {{ $order->notes ?? 'Nėra pastabų' }}</p>

                @if($order->video == 1)
                    <p><strong>Pristatymo vaizdo įrašas:</strong> Užsakytas (+5 €)</p>
                    @if($order->status === 'pristatytas')
                        <a href="{{ asset('storage/' . $order->video_path) }}" class="btn btn-outline-primary btn-sm" target="_blank">Peržiūrėti</a>
                        <a href="{{ asset('storage/' . $order->video_path) }}" download class="btn btn-outline-secondary btn-sm">Atsisiųsti</a>
                    @endif
                @else
                    <p><strong>Pristatymo vaizdo įrašas:</strong> Neužsakytas</p>
                @endif

                <hr>
                <p>
                    <strong>Miestas:</strong>
                    @if($order->delivery_city == 7)
                        Vilnius
                    @elseif($order->delivery_city == 10)
                        Kaunas
                    @else
                        Kitas
                    @endif<br>
                    <strong>Adresas:</strong> {{ $order->delivery_address }}<br>
                    <strong>Pašto kodas:</strong> {{ $order->postal_code }}<br>
                    <strong>Data:</strong> {{ \Carbon\Carbon::parse($order->delivery_date)->format('Y-m-d') }}<br>
                    <strong>Laikas:</strong> {{ $order->delivery_time ?? 'Nenurodytas' }}
                </p>

                <hr>
                <h5 class="text-end">Bendra suma: {{ number_format($order->total_price, 2) }} €</h5>
                @if($order->earnedLoyaltyPoints || $order->loyaltyUsage || $order->usedGiftCoupon())
                    <div class="mt-4 border-top pt-3">
                        <h5 class="mb-3 text-info"><i class="fas fa-star me-2"></i> Lojalumo taškų ir kuponų suvestinė</h5>
                        <ul class="list-group list-group-flush small">

                            @if($order->loyaltyUsage)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Panaudoti taškai</span>
                                    <span class="text-danger">-{{ abs($order->loyaltyUsage->points) }} taškai (-{{ number_format(abs($order->loyaltyUsage->points) * 0.10, 2) }} €)</span>
                                </li>
                            @endif

                            @if($order->earnedLoyaltyPoints)
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Gauti taškai</span>
                                    <span class="text-success">+{{ $order->earnedLoyaltyPoints->points }} taškai</span>
                                </li>
                            @endif

                            @if($order->usedGiftCoupon())
                                <li class="list-group-item d-flex justify-content-between">
                                    <span>Naudotas kuponas</span>
                                    <span class="text-danger">{{ $order->usedGiftCoupon()->code }} (-{{ number_format($order->usedGiftCoupon()->value, 2) }} €)</span>
                                </li>
                            @endif

                        </ul>
                    </div>
                @endif

                {{-- Veiksmai (Apmokėti, Redaguoti, Atšaukti, Atsiliepimas) --}}
                <div class="d-flex flex-column gap-2 mt-3">
                    @if($order->status === 'rezervuotas')
                        <form action="{{ route('checkout.show') }}" method="GET">
                            <input type="hidden" name="total" value="{{ $order->total_price }}">
                            <input type="hidden" name="city" value="{{ $order->delivery_city }}">
                            <input type="hidden" name="order_id" value="{{ $order->id }}">
                            <button type="submit" class="btn btn-success w-100">Apmokėti</button>
                        </form>

                        <form action="{{ route('orders.edit', $order->id) }}" method="GET">
                            <button type="submit" class="btn btn-dark w-100">Redaguoti</button>
                        </form>

                        <form action="{{ route('orders.destroy', $order->id) }}" method="POST" onsubmit="return confirm('Ar tikrai norite atšaukti šį užsakymą?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">Atšaukti rezervaciją</button>
                        </form>
                    @endif

                    @if($order->status === 'pristatytas' && !$order->review)
                        <a href="{{ route('reviews.create', $order->id) }}" class="btn btn-outline-primary">Rašyti atsiliepimą</a>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @endif
</div>
@endsection
