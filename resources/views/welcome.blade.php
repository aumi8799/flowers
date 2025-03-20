@extends('layouts.app')

@section('title', 'Pagrindinis puslapis')

@section('content')
        <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 600px;">
            <div class="container px-4 px-lg-5 my-5">
                <div class="text-center text-dark-gray" style="margin-top: 150px;"> 
                        <h1 class="display-4 fw-bolder">Sveiki atvykę į Gėlių Rojų!</h1>
                        <p class="lead fw-normal text-dark-gray mb-0" style="max-width: 700px; margin: auto;">Mes esame vieta, kur gėlės tampa ne tik gražiais akcentais, bet ir išraiškingomis emocijomis. Mūsų misija – suteikti jums nuostabias, aukščiausios kokybės gėles ir puokštes įvairioms progoms. Nepriklausomai nuo to, ar ieškote puokštės vestuvėms, gimtadieniui, ar tiesiog norite pradžiuginti mylimą žmogų, mes pasirūpinsime, kad jūsų pasirinkimas būtų ypatingas.</p>
                    </div>
                </div>
            </div>
        </header>
@endsection
