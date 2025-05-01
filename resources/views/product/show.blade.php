@extends('layouts.app')

@section('title')
    {{ $product->name }}
@endsection

@section('content')
<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">{{ $product->name }}</h1>
        </div>
    </div>
</header>

<div class="container my-5">
    <div class="row">
        <div class="col-md-6">
            <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
        </div>

        <div class="col-md-6">
            <h2>{{ $product->name }}</h2>
            <p>{{ $product->description }}</p>
            <p><strong>Kaina:</strong> €{{ $product->price }}</p>

            <form action="{{ route('cart.add') }}" method="POST" onsubmit="return validateForm()">
                @csrf
                <input type="hidden" name="id" value="{{ $product->id }}">
                <input type="hidden" name="name" value="{{ $product->name }}">
                <input type="hidden" name="price" value="{{ $product->price }}">
                <input type="hidden" name="image" value="{{ $product->image }}">

                <!-- Kiekio pasirinkimas -->
                <div class="form-group mb-3">
                    <label for="quantity">Kiekis:</label>
                    <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control" style="width: 100px;">
                </div>

                <!-- Sąlygos pagal kategoriją -->
                @if($product->category == 'miegancios_rozes')
                    <div class="form-group mb-3">
                        <label for="gift_wrap">Dovanos pakuotė:</label>
                        <select id="gift_wrap" name="gift_wrap" class="form-control" style="width: 300px;" required>
                            <option value="">Pasirinkite pakuotę</option>
                            <option value="dovanu_pakuote">Permatoma dovanu dėžutė su juostele</option>
                            <option value="dovanu_dezute">Dovanu dėžutė</option>
                        </select>
                    </div>

                @elseif($product->category == 'puokstes' || $product->category == 'skintos_geles')
                    <div class="form-group mb-3">
                        <label for="wrap_type">Pakuotės tipas:</label>
                        <select id="wrap_type" name="wrap_type" class="form-control" style="width: 300px;" onchange="toggleWrapOptions()" required>
                            <option value="">Pasirinkite pakuotės tipą</option>
                            <option value="popierius">Spalvotas popierius</option>
                            <option value="juostele">Juostelė</option>
                        </select>
                    </div>
                    <div id="wrap_color_section" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="wrap_color">Spalvos pasirinkimas:</label>
                            <select id="wrap_color" name="wrap_color" class="form-control" style="width: 300px;">
                                <option value="raudona">Raudona</option>
                                <option value="balta">Balta</option>
                                <option value="geltona">Geltona</option>
                                <option value="rožinė">Rožinė</option>
                            </select>
                        </div>
                    </div>

                @elseif($product->category == 'geles_dezuteje')
                    <div class="form-group mb-3">
                        <label for="box_type">Dėžutės tipas:</label>
                        <select id="box_type" name="box_type" class="form-control" style="width: 300px;" onchange="toggleBoxColorOptions()" required>
                            <option value="">Pasirinkite dėžutės tipą</option>
                            <option value="popierine">Popierinė</option>
                            <option value="viliurine">Viliūrinė</option>
                        </select>
                    </div>
                    <div id="box_color_section" style="display: none;">
                        <div class="form-group mb-3">
                            <label for="box_color">Spalvos pasirinkimas:</label>
                            <select id="box_color" name="box_color" class="form-control" style="width: 300px;">
                                <option value="raudona">Raudona</option>
                                <option value="balta">Balta</option>
                                <option value="auksine">Auksinė</option>
                                <option value="sidabrine">Sidabrinė</option>
                            </select>
                        </div>
                    </div>
                @endif

                <!-- Atviruko pasirinkimas -->

                <!-- VARNELĖ: Ar nori atviruko -->
                <div class="form-group mb-3">
                    <label>
                    <input type="checkbox" id="addPostcard" name="add_postcard" value="1" onchange="togglePostcardOptions()">
                        Pridėti atviruką prie šio užsakymo. 
                    </label>
                </div>

                <!-- PASIRINKIMAS: Kuris būdas -->
                <div id="postcardOptions" style="display: none;" class="mb-3">
                    <label><strong>Pasirink atviruko kūrimo būdą:</strong></label><br>
                    <input type="radio" name="postcard_method" value="simple" onclick="togglePostcardMethod()" checked> Paprastas<br>
                    <input type="radio" name="postcard_method" value="canva" onclick="togglePostcardMethod()"> Canva<br>
                </div>

                <!-- PAPRASTAS ATVIRUKAS -->
                <div id="simplePostcardForm" style="display: none;">
                    <div class="form-group mb-2">
                        <label for="postcard_template">Šablonas:</label>
                        <select name="postcard_template" id="postcard_template" class="form-control" style="width: 300px;">
                            <option value="birthday">Gimtadienis</option>
                            <option value="love">Meilė</option>
                            <option value="thank_you">Ačiū</option>
                        </select>
                    </div>

                    <div class="form-group mb-2">
                        <label for="postcard_message">Tavo žinutė:</label>
                        <textarea name="postcard_message" id="postcard_message" class="form-control" rows="3" style="width: 300px;"></textarea>
                    </div>
                </div>

                <!-- CANVA ATVIRUKAS -->
                <div id="canvaPostcardForm" style="display: none;" class="mt-3">
                    <a href="{{ route('postcard.canva') }}" target="_blank" class="btn btn-outline-success mb-2">
                        🎨 Kurti atviruką su Canva
                    </a>

                    <div class="form-group">
                        <label for="postcard_upload">Įkelk sukurtą atviruką (PNG/PDF):</label>
                        <input type="file" name="postcard_file" class="form-control-file" accept=".png,.pdf">
                    </div>
                </div>


                <!-- Pridėjimas į krepšelį -->

                <button type="submit" class="add-to-cart-btn">Įdėti į krepšelį</button>
            </form>
        </div>
    </div>
</div>


<script>
    function toggleWrapOptions() {
        var wrapType = document.getElementById('wrap_type').value;
        var wrapColorSection = document.getElementById('wrap_color_section');

        if (wrapType === 'juostele' || wrapType === 'popierius') {
            wrapColorSection.style.display = 'block';
        } else {
            wrapColorSection.style.display = 'none';
        }
    }

    function toggleBoxColorOptions() {
        var boxType = document.getElementById('box_type').value;
        var boxColorSection = document.getElementById('box_color_section');

        if (boxType === 'popierine' || boxType === 'viliurine') {
            boxColorSection.style.display = 'block';
        } else {
            boxColorSection.style.display = 'none';
        }
    }

    function validateForm() {
        // Tikrina ar pasirinktas reikiamas laukas (klientams aiškiai parodys klaidą)
        var category = "{{ $product->category }}";
        
        if (category === 'miegancios_rozes') {
            var giftWrap = document.getElementById('gift_wrap').value;
            if (giftWrap === '') {
                alert('Prašome pasirinkti dovanos pakuotę.');
                return false;
            }
        }

        if (category === 'puokstes' || category === 'skintos_geles') {
            var wrapType = document.getElementById('wrap_type').value;
            if (wrapType === '') {
                alert('Prašome pasirinkti pakuotės tipą.');
                return false;
            }
        }

        if (category === 'geles_dezuteje') {
            var boxType = document.getElementById('box_type').value;
            if (boxType === '') {
                alert('Prašome pasirinkti dėžutės tipą.');
                return false;
            }
        }

        return true;
    }

    function togglePostcardOptions() {
        const checkbox = document.getElementById('addPostcard');
        document.getElementById('postcardOptions').style.display = checkbox.checked ? 'block' : 'none';
        document.getElementById('simplePostcardForm').style.display = checkbox.checked ? 'block' : 'none'; // default
        document.getElementById('canvaPostcardForm').style.display = 'none';
    }

    function togglePostcardMethod() {
        const selected = document.querySelector('input[name="postcard_method"]:checked').value;
        document.getElementById('simplePostcardForm').style.display = selected === 'simple' ? 'block' : 'none';
        document.getElementById('canvaPostcardForm').style.display = selected === 'canva' ? 'block' : 'none';
    }
    
</script>
@endsection
