@extends('layouts.app')

@section('title', 'Vestuvės Dekoravimas')

@section('content')
    <!-- Header with background image -->
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray header-text">
                <h1 class="display-4 fw-bolder">Vestuvės Dekoravimas</h1>
                <p class="lead fw-normal text-dark-gray mb-0">Elegantiškos ir romantiškos dekoracijos Jūsų vestuvėms.</p>
            </div>
        </div>
    </header>

    <!-- Paslaugų aprašymas -->
    <section class="container my-5">
        <h2>Paslaugų aprašymas</h2>
        <p>Mes siūlome profesionalias vestuvių dekoravimo paslaugas, kurios padės sukurti nepamirštamą šventę. Mūsų paslaugos apima:</p>
        <ul>
            <li>Gėlių dekoracijos</li>
            <li>Stalo dekoravimas</li>
            <li>Atmosferos kūrimas pagal Jūsų pageidavimus</li>
        </ul>
    </section>

    <!-- Paslaugų paketai -->
    <section class="container my-5">
        <h2 class="text-center">Pasirinkite paslaugų paketą</h2>
        <form action="{{ route('decorations.order', ['type' => 'wedding']) }}" method="POST" id="orderForm">
            @csrf
            <input type="hidden" name="package" id="selectedPackage" value=""> <!-- Paslėptas laukas paketui -->

            <div class="row">
                <!-- MINI paketas -->
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h3 class="card-title">MINI</h3>
                            <p class="card-text">Nuo €700</p>
                            <ul>
                                <li>Susitikimai su jaunaisiais</li>
                                <li>Apsilankymas šventės lokacijoje</li>
                                <li>Gėlių pasirinkimas ir užsakymas</li>
                                <li>Salės nupuošimas</li>
                            </ul>
                            <button type="button" class="btn btn-outline-primary" onclick="setPackage('mini')">Pasirinkti šį paketą</button>
                        </div>
                    </div>
                </div>

                <!-- MIDI paketas -->
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h3 class="card-title">MIDI</h3>
                            <p class="card-text">Nuo €1100</p>
                            <ul>
                                <li>Susitikimai su jaunaisiais</li>
                                <li>Apsilankymas šventės lokacijoje</li>
                                <li>Gėlių pasirinkimas ir užsakymas</li>
                                <li>Foto kampelio įkūrimas</li>
                            </ul>
                            <button type="button" class="btn btn-outline-primary" onclick="setPackage('midi')">Pasirinkti šį paketą</button>
                        </div>
                    </div>
                </div>

                <!-- MAXI paketas -->
                <div class="col-md-4">
                    <div class="card shadow-sm mb-4">
                        <div class="card-body">
                            <h3 class="card-title">MAXI</h3>
                            <p class="card-text">Nuo €1600</p>
                            <ul>
                                <li>Susitikimai su jaunaisiais</li>
                                <li>Apsilankymas šventės lokacijoje</li>
                                <li>Gėlių pasirinkimas ir užsakymas</li>
                                <li>Jaunųjų pasiruošimo vietos papuošimas</li>
                            </ul>
                            <button type="button" class="btn btn-outline-primary" onclick="setPackage('maxi')">Pasirinkti šį paketą</button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Užsakymo forma, kuri pasirodo tik pasirinkus paketą -->
            <div id="orderDetails" style="display:none;">
                <h2 class="text-center">Užsakyti Dekoravimo Paslaugas</h2>

                <div class="form-group">
                    <label for="event_date">Šventės data *</label>
                    <input type="date" class="form-control" id="event_date" name="event_date" required>
                </div>

                <div class="form-group">
                    <label for="location">Lokacija *</label>
                    <input type="text" class="form-control" id="location" name="location" required>
                </div>

                <div class="form-group">
                    <label for="guests_count">Svečių skaičius</label>
                    <input type="number" class="form-control" id="guests_count" name="guests_count" min="0">
                </div>

                <div class="form-group">
                    <label for="tables_count">Stalų skaičius</label>
                    <input type="number" class="form-control" id="tables_count" name="tables_count" min="0">
                </div>

                <div class="form-group">
                    <label for="flowers">Ar reikės nuotakos puokštės ir butonjerės?</label>
                    <select class="form-control" id="flowers" name="flowers">
                        <option value="no">Ne</option>
                        <option value="yes">Taip</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="color_scheme">Spalvinė gama</label>
                    <input type="text" class="form-control" id="color_scheme" name="color_scheme">
                </div>

                <div class="form-group">
                    <label for="style">Vestuvių stilistika</label>
                    <select class="form-control" id="style" name="style">
                        <option value="classic">Klasika</option>
                        <option value="boho">Boho</option>
                        <option value="provence">Provence</option>
                        <option value="exotic">Egzotika</option>
                        <option value="other">Kita</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="budget">Preliminarus biudžetas *</label>
                    <input type="number" class="form-control" id="budget" name="budget" required>
                </div>

                <div class="form-group">
                    <label for="name">Jūsų vardas *</label>
                    <input type="text" class="form-control" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Jūsų el. paštas *</label>
                    <input type="email" class="form-control" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="comments">Kiti komentarai nuo jaunųjų</label>
                    <textarea class="form-control" id="comments" name="comments" rows="4"></textarea>
                </div>

                <button type="submit" class="btn btn-success mt-4">Pateikti užklausą</button>
            </div>
        </form>
    </section>

    <!-- JavaScript dinamika -->
    <script>
        function setPackage(package) {
            // Nustatome pasirinkto paketo vertę į paslėptą lauką
            document.getElementById('selectedPackage').value = package;

            // Parodome užsakymo formą
            document.getElementById('orderDetails').style.display = 'block';
        }
    </script>
@endsection
