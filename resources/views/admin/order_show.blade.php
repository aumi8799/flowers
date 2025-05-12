@extends('layouts.app')

@section('title', 'Užsakymo informacija')

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Užsakymo #{{ $order->id }} informacija</h1>
        </div>
    </div>
</header>

<div class="container my-5">

    {{-- Pirkėjo informacija --}}
    <div class="card p-4 mb-4 shadow-sm">
        <h4 class="mb-3"><i class="fas fa-user me-2 text-primary"></i>Pirkėjo informacija</h4>
        <div class="row">
            <div class="col-md-6 mb-2"><strong>Vardas:</strong> {{ $order->first_name }}</div>
            <div class="col-md-6 mb-2"><strong>Pavardė:</strong> {{ $order->last_name }}</div>
            <div class="col-md-6 mb-2"><strong>Telefono:</strong> {{ $order->phone }}</div>
            <div class="col-md-6 mb-2"><strong>El. paštas:</strong> {{ $order->email }}</div>
            <div class="col-md-6 mb-2"><strong>Paskyros vardas:</strong> {{ $order->user->name ?? '–' }}</div>
        </div>
    </div>

    {{-- Pristatymo informacija --}}
    <div class="card p-4 mb-4 shadow-sm">
        <h4 class="mb-3"><i class="fas fa-truck me-2 text-success"></i>Pristatymo informacija</h4>
        <div class="row">
            <div class="col-md-6 mb-2">
                <strong>Miestas:</strong>
                <span class="badge bg-secondary">
                    @if($order->delivery_city == 7) Vilnius
                    @elseif($order->delivery_city == 10) Kaunas
                    @else {{ $order->delivery_city }}
                    @endif
                </span>
            </div>
            <div class="col-md-6 mb-2"><strong>Adresas:</strong> {{ $order->delivery_address }}</div>
            <div class="col-md-6 mb-2"><strong>Pašto kodas:</strong> {{ $order->postal_code }}</div>
            <div class="col-md-6 mb-2"><strong>Data:</strong> {{ $order->delivery_date ?? '–' }}</div>
            <div class="col-md-6 mb-2"><strong>Laikas:</strong> {{ $order->delivery_time ?? '–' }}</div>
            <div class="col-md-6 mb-2"><strong>Vaizdo įrašas:</strong>
                @if($order->video)
                    Taip @if($order->video_path)
                        (<a href="{{ asset('storage/' . $order->video_path) }}" target="_blank">Peržiūra</a>)
                    @endif
                @else
                    Ne
                @endif
            </div>
        </div>
    </div>

    {{-- Užsakymo būsena --}}
    <div class="card p-4 mb-4 shadow-sm">
        <h4 class="mb-3"><i class="fas fa-info-circle me-2 text-dark"></i>Užsakymo informacija</h4>
        <div class="row">
            <div class="col-md-6 mb-2">
                <strong>Būsena:</strong>
                <span class="badge bg-{{ $order->status === 'atšauktas' ? 'danger' : ($order->status === 'pristatytas' ? 'success' : 'primary') }}">
                    {{ ucfirst($order->status) }}
                </span>
            </div>
            <div class="col-md-6 mb-2"><strong>Sukurtas:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</div>
            @if ($order->cancel_reason)
                <div class="col-md-12 mb-2"><strong>Atšaukimo priežastis:</strong> {{ $order->cancel_reason }}</div>
            @endif
            <div class="col-md-12 mb-2"><strong>Pastabos:</strong> {{ $order->notes ?? 'Nėra' }}</div>
            <div class="col-md-12 mb-2"><strong>Bendra suma:</strong> <span class="fw-bold">{{ number_format($order->total_price, 2) }} €</span></div>
        </div>
    </div>

    @if($order->earnedLoyaltyPoints || $order->loyaltyUsage || $order->usedGiftCoupon())
        <div class="card p-4 mb-4 shadow-sm">
            <h4 class="mb-3"><i class="fas fa-gift text-success me-2"></i>Lojalumo taškų ir kuponų suvestinė</h4>
            <ul class="list-group list-group-flush small">

                @if($order->loyaltyUsage)
                    <li class="list-group-item d-flex justify-content-between">
                        <span><i class="fas fa-minus-circle text-danger me-1"></i>Panaudoti taškai</span>
                        <span class="text-danger">-{{ abs($order->loyaltyUsage->points) }} taškai ({{ number_format(abs($order->loyaltyUsage->points) * 0.10, 2) }} €)</span>
                    </li>
                @endif

                @if($order->earnedLoyaltyPoints)
                    <li class="list-group-item d-flex justify-content-between">
                        <span><i class="fas fa-plus-circle text-success me-1"></i>Gauti taškai</span>
                        <span class="text-success">+{{ $order->earnedLoyaltyPoints->points }} taškai</span>
                    </li>
                @endif

                @if($order->usedGiftCoupon())
                    <li class="list-group-item d-flex justify-content-between">
                        <span><i class="fas fa-ticket-alt text-primary me-1"></i>Naudotas kuponas</span>
                        <span class="text-primary">{{ $order->usedGiftCoupon()->code }} (-{{ number_format($order->usedGiftCoupon()->value, 2) }} €)</span>
                    </li>
                @endif

            </ul>
        </div>
    @endif

    {{-- Užsakymo prekės --}}
    <div class="card p-4 mb-4 shadow-sm">
        <h4 class="mb-4"><i class="fas fa-box-open me-2 text-warning"></i>Užsakymo prekės</h4>

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

    <div class="d-flex justify-content-between mt-4">
        <a href="{{ route('admin.orders') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-2"></i> Grįžti
        </a>
        <a href="{{ route('admin.orders.edit', $order->id) }}" class="btn btn-primary">
            <i class="fas fa-edit me-2"></i> Redaguoti
        </a>
    </div>

</div>
@endsection
