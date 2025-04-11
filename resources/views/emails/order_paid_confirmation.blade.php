<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Užsakymas apmokėtas</title>
</head>
<body>
    <h2>Ačiū, {{ $order->user->name }}!</h2>
    <p>Jūsų užsakymas <strong>#{{ $order->id }}</strong> buvo sėkmingai apmokėtas.</p>
    <p>Bendra suma: <strong>{{ $order->total_price }} €</strong></p>
    <p>Pristatymo miestas: 
        @if($order->delivery_city == 7)
            Vilnius
        @elseif($order->delivery_city == 10)
            Kaunas
        @else
            Nenurodytas
        @endif
    </p>
    <p>Gėlių fėjos jau ruošia jūsų užsakymą 🌸</p>
</body>
</html>
