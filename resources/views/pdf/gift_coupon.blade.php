<!DOCTYPE html>
<html lang="lt">
<head>
    <meta charset="UTF-8">
    <style>
        body {
            font-family: DejaVu Sans, sans-serif;
            padding: 40px;
            background-color: #fdfdfd;
            color: #333;
        }

        .coupon-box {
            border: 3px dashed #0d6efd;
            padding: 40px 30px;
            border-radius: 20px;
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
            text-align: center;
        }

        .logo {
            max-height: 80px;
            margin-bottom: 25px;
        }

        .coupon-title {
            font-size: 2.2rem;
            color: #0d6efd;
            margin-bottom: 20px;
        }

        .coupon-value {
            font-size: 1.8rem;
            margin-bottom: 10px;
        }

        .coupon-code {
            font-size: 1.2rem;
            letter-spacing: 2px;
            margin-bottom: 30px;
        }

        .coupon-note {
            font-size: 1rem;
            margin-top: 10px;
            color: #666;
        }

        .generated {
            font-size: 0.85rem;
            color: #aaa;
            margin-top: 40px;
        }
    </style>
</head>
<body>
    <div class="coupon-box">
        <img src="{{ public_path('images/logo.png') }}" alt="Bloom & Bliss logotipas" class="logo">
        <h1 class="coupon-title">DOVANŲ KUPONAS</h1>
        <p class="coupon-value">Vertė: <strong>{{ $coupon->value }} €</strong></p>
        <p class="coupon-code">Kodas: <strong>{{ $coupon->code }}</strong></p>
        <p class="coupon-note">Galioja vienkartiniam panaudojimui 12 mėnesių.</p>
        <p class="generated">Sugeneruota: {{ now()->format('Y-m-d') }}</p>
    </div>
</body>
</html>
