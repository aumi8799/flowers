<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Sąskaita faktūra</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; font-size: 12px; }
        h2, h3 { margin-bottom: 5px; }
        table { width: 100%; border-collapse: collapse; margin-bottom: 15px; }
        th, td { border: 1px solid #000; padding: 5px; text-align: left; }
    </style>
</head>
<body>

<h2>Sąskaita faktūra #{{ $order->id }}</h2>
<p>Data: {{ $order->created_at->format('Y-m-d') }}</p>
<p>Vardas: {{ $order->first_name }} {{ $order->last_name }}</p>
<p>El. paštas: {{ $order->email }}</p>
<p>Adresas: {{ $order->delivery_address }}, {{ $order->postal_code }}, {{ $order->delivery_city }}</p>

{{-- Produktai --}}
@if($order->items->count())
<h3>Produktai</h3>
<table>
    <thead>
        <tr>
            <th>Pavadinimas</th>
            <th>Kiekis</th>
            <th>Kaina (vnt)</th>
            <th>Suma</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->items as $item)
            <tr>
                <td>{{ $item->product->name ?? 'Be pavadinimo' }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->price, 2) }} €</td>
                <td>{{ number_format($item->price * $item->quantity, 2) }} €</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- Puokštės --}}
@if($order->bouquets->count())
<h3>Individualios puokštės</h3>
<table>
    <thead>
        <tr>
            <th>Sudėtis</th>
            <th>Kiekis</th>
            <th>Suma</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->bouquets as $bouquet)
            <tr>
                <td>
                    @foreach(json_decode($bouquet->bouquet_data, true) as $flower)
                        - {{ $flower['name'] }} ({{ $flower['quantity'] }} vnt.)<br>
                    @endforeach
                </td>
                <td>1</td>
                <td>{{ number_format($bouquet->total_price, 2) }} €</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- Prenumeratos --}}
@if($order->subscriptions->count())
<h3>Prenumeratos</h3>
<table>
    <thead>
        <tr>
            <th>Kategorija</th>
            <th>Dydis</th>
            <th>Trukmė</th>
            <th>Kaina</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->subscriptions as $subscription)
            <tr>
                <td>{{ ucfirst($subscription->category) }}</td>
                <td>{{ $subscription->size }}</td>
                <td>{{ $subscription->duration }} mėn.</td>
                <td>{{ number_format($subscription->price, 2) }} €</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

{{-- Kuponai --}}
@if($order->giftCoupons && $order->giftCoupons->count() > 0)
<h3>Dovanų kuponai</h3>
<table>
    <thead>
        <tr>
            <th>Kodas</th>
            <th>Vertė</th>
            <th>Būsena</th>
        </tr>
    </thead>
    <tbody>
        @foreach($order->giftCoupons as $coupon)
            <tr>
                <td>{{ $coupon->code }}</td>
                <td>{{ number_format($coupon->value, 2) }} €</td>
                <td>{{ $coupon->used ? 'Panaudotas' : 'Nepanaudotas' }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
@endif

<h3>Bendra suma: {{ number_format($order->total_price, 2) }} €</h3>

</body>
</html>
