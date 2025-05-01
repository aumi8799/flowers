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
    <div class="card p-4 mb-4">
        <h4 class="mb-3">Pirkėjo informacija</h4>
        <p><strong>Vardas:</strong> {{ $order->first_name }}</p>
        <p><strong>Pavardė:</strong> {{ $order->last_name }}</p>
        <p><strong>Telefono numeris:</strong> {{ $order->phone }}</p>
        <p><strong>El. paštas:</strong> {{ $order->email }}</p>
        <p><strong>Paskyros vardas:</strong> {{ $order->user->name ?? '–' }}</p>
    </div>

    <div class="card p-4 mb-4">
        <h4 class="mb-3">Pristatymo informacija</h4>
        <p><strong>Miestas:</strong>
            @if($order->delivery_city == 7) Vilnius
            @elseif($order->delivery_city == 10) Kaunas
            @else {{ $order->delivery_city }}
            @endif
        </p>
        <p><strong>Adresas:</strong> {{ $order->delivery_address }}</p>
        <p><strong>Pašto kodas:</strong> {{ $order->postal_code }}</p>
        <p><strong>Data:</strong> {{ $order->delivery_date ?? '–' }}</p>
        <p><strong>Laikas:</strong> {{ $order->delivery_time ?? '–' }}</p>
        <p><strong>Vaizdo įrašas:</strong>
            @if($order->video)
                Taip @if($order->video_path) (<a href="{{ asset('storage/' . $order->video_path) }}" target="_blank">Peržiūra</a>) @endif
            @else
                Ne
            @endif
        </p>
    </div>

    <div class="card p-4 mb-4">
        <h4 class="mb-3">Užsakymo informacija</h4>
        <p><strong>Būsena:</strong> {{ ucfirst($order->status) }}</p>
        <p><strong>Sukurtas:</strong> {{ $order->created_at->format('Y-m-d H:i:s') }}</p>
        @if ($order->cancel_reason)
            <p><strong>Atšaukimo priežastis:</strong> {{ $order->cancel_reason }}</p>
        @endif
        <p><strong>Pastabos:</strong> {{ $order->notes ?? 'Nėra' }}</p>
        <p><strong>Bendra suma:</strong> {{ $order->total_price }} €</p>
    </div>

    <div class="card p-4 mb-4">
    <h4>Užsakymo prekės</h4>
    <table class="table table-bordered mt-3">
        <thead>
            <tr>
                <th>Tipas</th>
                <th>Prekė</th>
                <th>Kiekis</th>
                <th>Kaina</th>
                <th>Atvirukas</th>
            </tr>
        </thead>
        <tbody>
            {{-- Produktai --}}
            @foreach($order->items as $item)
                <tr>
                    <td>Produktas</td>
                    <td>{{ $item->product->name ?? '—' }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ number_format($item->price * $item->quantity, 2) }} €</td>
                    <td>
                    @if($item->postcard)
                            <strong>Šablonas:</strong> {{ $item->postcard->template }}<br>
                            <strong>Žinutė:</strong> {{ $item->postcard->message }}<br>
                            @if($item->postcard->file_path)
                                <a href="{{ asset('storage/' . $item->postcard->file_path) }}" target="_blank">Peržiūrėti failą</a>
                            @endif
                        @else
                            <span class="text-muted">–</span>
                        @endif
                    </td>
                </tr>
            @endforeach

            {{-- Individualios puokštės --}}
            @foreach($order->bouquets as $bouquet)
                <tr>
                    <td>Individuali puokštė</td>
                    <td>
                        @php
                            $bouquetItems = json_decode($bouquet->bouquet_data, true);
                        @endphp
                        @foreach($bouquetItems as $flower)
                            • {{ $flower['name'] }} ({{ $flower['quantity'] }} vnt.)<br>
                        @endforeach
                    </td>
                    <td>1</td>
                    <td>{{ number_format($bouquet->total_price, 2) }} €</td>
                    <td>
                        @if($order->postcard)
                            <i class="fas fa-check-circle text-success"></i>
                        @else
                            <i class="fas fa-times-circle text-muted"></i>
                        @endif
                    </td>
                </tr>
            @endforeach

            {{-- Prenumeratos --}}
            @foreach($order->subscriptions as $subscription)
                <tr>
                    <td>Prenumerata</td>
                    <td>
                        Kategorija: {{ ucfirst($subscription->category) }}<br>
                        Dydis: {{ $subscription->size }}
                    </td>
                    <td>1</td>
                    <td>{{ number_format($subscription->price, 2) }} €</td>
                    <td><i class="fas fa-minus text-muted"></i></td>
                </tr>
            @endforeach
        </tbody>
    </table>
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
