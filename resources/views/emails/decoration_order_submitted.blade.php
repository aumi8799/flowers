<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Užklausa gauta</title>
</head>
<body>
    <h2>Sveiki, {{ $order->name }}!</h2>

    <p>Ačiū, kad palikote užklausą dėl 
    @switch($order->type)
        @case('wedding')
            vestuvių dekoravimo 
            @break
        @case('corporate')
            įmonės renginio dekoravimo
            @break
        @case('birthday')
            gimtadienio dekoravimo
            @break
        @default
            dekoravimo
            @endswitch 
            paslaugos.</p>

    <p>Jūsų dekoravimo užklausa (ID: #{{ $order->id }}) sėkmingai užregistruota. Greitu metu su jumis susisieksime dėl tolimesnių detalių.</p>

    <br>
    <p>Pagarbiai,</p>
    <p>Bloom&Bliss dekoravimo komanda</p>
</body>
</html>
