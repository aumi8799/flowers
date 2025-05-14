<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Užklausa gauta</title>
</head>
<body>
   <h2>Sveiki, {{ $order->name }}!</h2>

<p>Deja, jūsų dekoravimo užklausa (ID: #{{ $order->id }}) buvo atmesta.</p>

<p><strong>Priežastis:</strong></p>
<p>{{ $reason }}</p>

<p>Jei turite klausimų ar norėtumėte pasiūlyti kitą variantą – drąsiai susisiekite su mumis!</p>

<br>
<p>Pagarbiai,</p>
<p>Bloom&Bliss dekoravimo komanda</p>

</body>
</html>
