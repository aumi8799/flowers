<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Užsakymas pradėtas vykdyti</title>
</head>
<body>
    <h2>Sveiki, {{ $order->name }}!</h2>

    <p>Norime informuoti, kad jūsų dekoravimo užsakymas (ID: #{{ $order->id }}) yra pradėtas vykdyti. Mūsų komanda jau pradėjo ruošti viską, kad jūsų šventė būtų išties ypatinga!
</p>

    <p> Jei turite papildomų klausimų, pastebėjimų ar norėtumėte ką nors koreguoti, susisiekite su mumis kuo greičiau –
        mūsų tikslas – padaryti jūsų šventę nepriekaištingą </p>

    <br>
    <p>Pagarbiai,</p>
    <p>Bloom&Bliss dekoravimo komanda</p>
</body>
</html>
