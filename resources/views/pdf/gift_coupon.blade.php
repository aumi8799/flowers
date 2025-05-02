<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <style>
        body { font-family: DejaVu Sans, sans-serif; text-align: center; padding: 50px; }
        .coupon-box { border: 3px dashed #333; padding: 30px; border-radius: 15px; }
    </style>
</head>
<body>
    <div class="coupon-box">
        <h1>DOVANŲ KUPONAS</h1>
        <p style="font-size: 1.5rem;">Vertė: <strong>{{ $coupon->value }} €</strong></p>
        <p>Kodas: <strong>{{ $coupon->code }}</strong></p>
        <p style="margin-top: 20px;">Galioja vienkartiniam panaudojimui.</p>
        <p style="font-size: 0.9rem;">Sugeneruota: {{ now()->format('Y-m-d') }}</p>
    </div>
</body>
</html>
