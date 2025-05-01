@extends('layouts.app')

@section('title', 'Kurti Puokštę')

@section('content')
    <!-- Header kaip kituose puslapiuose -->
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray header-text">
                <h1 class="display-4 fw-bolder">Sukurk savo puokštę</h1>
            </div>
        </div>
    </header>

    <div class="container my-5">
        <div class="row">
            <!-- Gėlių pasirinkimas -->
            <div class="col-md-6">
                <h2 class="mb-4">Pasirink gėles:</h2>

                <!-- Gėlių tipų filtrai -->
                <div class="mb-4 d-flex flex-wrap gap-2">
                    @foreach ($flowerTypes as $type)
                        <button type="button" class="btn btn-outline-dark flower-type-btn" data-type="{{ $type }}">
                            {{ ucfirst($type) }}
                        </button>
                    @endforeach
                </div>

                <!-- Gėlių sąrašas -->
                <div class="product-list d-flex flex-nowrap overflow-auto" id="flowers-list">
                    @foreach ($flowers as $flower)
                        <div class="product-item card text-center m-2 flower-card" style="width: 200px; min-height: 370px;" data-type="{{ $flower->type }}">
                            <img src="{{ asset('images/products/' . $flower->image) }}" alt="{{ $flower->name }}" class="product-image" style="height: 180px; object-fit: cover;">
                            <div class="product-details text-center p-2">
                                <h2 class="product-name" style="font-size: 1.2rem;">{{ $flower->name }}</h2>
                                <p class="product-price" style="font-weight: bold;">{{ $flower->price }} €</p>
                                <button class="add-to-cart-btn add-flower" 
                                        data-id="{{ $flower->id }}" 
                                        data-name="{{ $flower->name }}" 
                                        data-price="{{ $flower->price }}">
                                    Pridėti
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Tavo puokštė -->
            <div class="col-md-6">
                <h2 class="mb-4">Tavo puokštė:</h2>
                <ul id="bouquet-list" class="list-group mb-4"></ul>
                <p class="fw-bold mb-4">Bendra kaina: <span id="total-price">0</span> €</p>

                <form method="POST" action="{{ route('bouquet.store') }}" enctype="multipart/form-data">
                @csrf
                    <input type="hidden" name="bouquet" id="bouquet-data">
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

                    <button type="submit" class="add-to-cart-btn">Užsakyti puokštę</button>
                </form>
            </div>
        </div>
    </div>

    <div class="text-center mb-5">
        <a href="{{ route('catalog.index') }}" class="add-to-cart-btn">← Grįžti į katalogą</a>
    </div>

    <!-- JavaScript -->
    <script>
        const bouquetList = document.getElementById('bouquet-list');
        const bouquetData = document.getElementById('bouquet-data');
        const totalPrice = document.getElementById('total-price');
        const flowerCards = document.querySelectorAll('.flower-card');
        const flowerTypeButtons = document.querySelectorAll('.flower-type-btn');

        let bouquet = [];
        let total = 0;

        function renderBouquet() {
            bouquetList.innerHTML = '';
            total = 0;

            bouquet.forEach((item, index) => {
                total += item.price * item.quantity;

                const li = document.createElement('li');
                li.classList.add('list-group-item', 'd-flex', 'justify-content-between', 'align-items-center');
                li.innerHTML = `
                    <div class="d-flex justify-content-between align-items-center w-100">
                        <span>${item.name} – ${item.quantity}x – ${(item.price * item.quantity).toFixed(2)} €</span>
                        <button class="btn btn-outline-danger btn-sm remove-flower" data-index="${index}" style="padding: 0.25rem 0.5rem; font-size: 0.8rem;">
                            ✖
                        </button>
                    </div>
                `;
                bouquetList.appendChild(li);
            });

            bouquetData.value = JSON.stringify(bouquet);
            totalPrice.textContent = total.toFixed(2);

            document.querySelectorAll('.remove-flower').forEach(button => {
                button.addEventListener('click', (e) => {
                    const index = e.target.dataset.index;

                    if (bouquet[index].quantity > 1) {
                        bouquet[index].quantity--;
                        renderBouquet();
                    } else {
                        if (confirm('Ar tikrai norite pašalinti šią gėlę iš puokštės?')) {
                            bouquet.splice(index, 1);
                            renderBouquet();
                        }
                    }
                });
            });
        }

        document.querySelectorAll('.add-flower').forEach(button => {
            button.addEventListener('click', () => {
                const id = button.dataset.id;
                const name = button.dataset.name;
                const price = parseFloat(button.dataset.price);

                const existingFlower = bouquet.find(flower => flower.id === id);

                if (existingFlower) {
                    existingFlower.quantity++;
                } else {
                    bouquet.push({ id, name, price, quantity: 1 });
                }

                renderBouquet();
            });
        });

        flowerTypeButtons.forEach(button => {
            button.addEventListener('click', () => {
                const selectedType = button.dataset.type;

                flowerCards.forEach(card => {
                    if (card.dataset.type === selectedType) {
                        card.style.display = 'block';
                    } else {
                        card.style.display = 'none';
                    }
                });

                flowerTypeButtons.forEach(btn => {
                    btn.classList.remove('btn-dark');
                    btn.classList.add('btn-outline-dark');
                });
                button.classList.remove('btn-outline-dark');
                button.classList.add('btn-dark');
            });
        });

        if (flowerTypeButtons.length > 0) {
            flowerTypeButtons[0].click();
        }
        function togglePostcardOptions() {
        const checkbox = document.getElementById('addPostcard');
        document.getElementById('postcardOptions').style.display = checkbox.checked ? 'block' : 'none';
        document.getElementById('simplePostcardForm').style.display = checkbox.checked ? 'block' : 'none';
        document.getElementById('canvaPostcardForm').style.display = 'none';
    }

    function togglePostcardMethod() {
        const selected = document.querySelector('input[name="postcard_method"]:checked').value;
        document.getElementById('simplePostcardForm').style.display = selected === 'simple' ? 'block' : 'none';
        document.getElementById('canvaPostcardForm').style.display = selected === 'canva' ? 'block' : 'none';
    }
    </script>
@endsection