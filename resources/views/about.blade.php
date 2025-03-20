@extends('layouts.app')

@section('title', 'Apie mus')

@section('content')
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray header-text">
                <h1 class="display-4 fw-bolder">Apie mus</h1>
                <p class="lead fw-normal text-dark-gray mb-0">Mūsų istorija – trijų draugių svajonė, virtusi realybe.</p>
            </div>
        </div>
    </header>

    <section class="py-5">
        <div class="container px-4 px-lg-5">
            <h2 class="fw-bolder">Kaip viskas prasidėjo?</h2>
            <p>
                Mes – trys draugės studentės, kurias vienija meilė gėlėms ir estetikai. Studijų metais pastebėjome,
                kad rinkoje trūksta unikalaus, kūrybiško požiūrio į gėlių kompozicijas, tad nusprendėme sukurti
                savo verslą. <strong>Taip gimė „Bloom & Bliss“</strong> – vieta, kur kiekviena puokštė kuriama su meile ir išskirtiniu dėmesiu detalėms.
            </p>

            <h2 class="fw-bolder mt-4">Mūsų misija</h2>
            <p>
                Norime padėti žmonėms dovanoti ne tik gėles, bet ir jausmus. Kiekviena mūsų kurta puokštė ar dekoracija
                pasakoja istoriją ir sukuria ypatingą nuotaiką. Tikime, kad gėlės gali papuošti ne tik erdves, bet ir gyvenimus.
            </p>

            <h2 class="fw-bolder mt-4">Kodėl rinktis mus?</h2>
            <ul>
                <li>🌿 Kiekviena puokštė kuriama rankomis su meile ir atidumu.</li>
                <li>🌸 Siūlome tik šviežiausias, aukščiausios kokybės gėles.</li>
                <li>🎨 Kuriame individualius užsakymus pagal jūsų poreikius.</li>
                <li>🚀 Greitas ir patikimas pristatymas.</li>
            </ul>

            <h2 class="fw-bolder mt-4">Prisijunkite prie mūsų kelionės!</h2>
            <p>
                Kviečiame jus apsilankyti mūsų <a href="{{ route('catalog.index') }}">gėlių kataloge</a> ir išsirinkti tai, kas pradžiugins jus ar jūsų artimuosius.  
            </p>
        </div>
    </section>
@endsection
