<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <title>Užsakymas apmokėtas</title>
    <style>
        body { font-family: DejaVu Sans, sans-serif; color: #333; }
        h2 { color: #4CAF50; }
        p { line-height: 1.6; }
    </style>
</head>
<body>
    <h2>Ačiū, {{ $order->user->name }}!</h2>
    <p>Jūsų užsakymas <strong>#{{ $order->id }}</strong> buvo sėkmingai apmokėtas.</p>
    <p>Bendra suma: <strong>{{ number_format($order->total_price, 2) }} €</strong></p>

    <p>Pristatymo miestas: 
        @switch($order->delivery_city)
            @case(7)
                Vilnius
                @break
            @case(10)
                Kaunas
                @break
            @default
                Nenurodytas
        @endswitch
    </p>

    <p>Pristatymo data: <strong>{{ $order->delivery_date }}</strong></p>
    <p>Pristatymo laikas: <strong>{{ $order->delivery_time }}</strong></p>

    <p>🧾 Sąskaita faktūra pridėta prie šio laiško kaip PDF priedas.</p>

    <p>Gėlių fėjos jau ruošia jūsų užsakymą 🌸</p>

    <p>Su meile,</p>
    <p><strong>Bloom & Bliss</strong> komanda</p>
</body>
</html>
