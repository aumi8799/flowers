<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container d-flex justify-content-between align-items-center w-100">
        

    <div class="search-container">
        <form action="{{ route('search') }}" method="GET" class="d-flex align-items-center">
            <i class="fas fa-search search-icon"></i>
            <input type="text" name="query" class="search-input" placeholder="Ieškoti prekes..." value="{{ request()->input('query') }}">
        </form>
    </div>

        <div class="logo-container">
            <a class="navbar-brand" href="#">
                <img src="{{ asset('images/logo.png') }}" alt="Bloom&Bliss Logo">
            </a>
        </div>

        <div class="d-flex align-items-center">
            <ul class="navbar-nav d-flex align-items-center">
                @auth
                    <li class="nav-item dropdown-hover">
                        <a class="nav-link" href="/dashboard">
                            <span class="d-none d-lg-inline">Mano Paskyra</span>
                            <i class="fas fa-user d-lg-none"></i> 
                        </a>
                        <ul class="dropdown-menu-custom">
                            <li><a class="dropdown-item-custom" href="/dashboard">Skydelis</a></li>
                            <li><a class="dropdown-item-custom" href="/orders">Užsakymai</a></li>
                            <li><a class="dropdown-item-custom" href="#">Atsisiutimai</a></li>
                            <li><a class="dropdown-item-custom" href="/addresses">Adresai</a></li>
                            <li><a class="dropdown-item-custom" href="{{ route('profile.show') }}">Vartotojo informacija</a></li>
                            <li>
                                <a class="dropdown-item-custom" href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    Atsijungti
                                </a>
                            </li>
                            <form id="logout-form" method="POST" action="{{ route('logout') }}" style="display: none;">
                                @csrf
                            </form>
                        </ul>
                    </li>
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Prisijungti</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ route('register') }}">Registracija</a></li>
                @endauth
            </ul>
            <a class="nav-link cart-link" href="{{ route('cart.view') }}">
                <i class="fas fa-shopping-bag"></i>
                <span class="badge cart-count">{{ session('cart') ? count(session('cart')) : 0 }}</span>
            </a>
        </div>
    </div>
</nav>

<script>
    document.querySelector(".search-container").addEventListener("click", function() {
        this.classList.add("active");
        this.querySelector(".search-input").focus();
    });

    document.addEventListener("click", function(event) {
        let searchBox = document.querySelector(".search-container");
        if (!searchBox.contains(event.target) && searchBox.classList.contains("active")) {
            searchBox.classList.remove("active");
        }
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<script>
    document.querySelector(".search-container").addEventListener("click", function() {
        this.classList.add("active");
        this.querySelector(".search-input").focus();
    });

    document.addEventListener("click", function(event) {
        let searchBox = document.querySelector(".search-container");
        if (!searchBox.contains(event.target) && searchBox.classList.contains("active")) {
            searchBox.classList.remove("active");
        }
    });
</script>

<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">

<nav class="navbar navbar-expand-lg navbar-light bg-white">
    <div class="container">
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav mx-auto">
                <li class="nav-item"><a class="nav-link" href="/">PAGRINDINIS</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('about') }}">APIE MUS</a></li>
                <li class="nav-item dropdown-hover">
                    <a class="nav-link" href="{{ route('catalog.index') }}">GĖLIŲ KATALOGAS</a>
                    <ul class="dropdown-menu-custom">
                        <li><a class="dropdown-item-custom" href="{{ route('catalog.skintos-geles') }}">Skintos gėlės</a></li>
                        <li><a class="dropdown-item-custom" href="{{ route('catalog.puokstes') }}">Puokštės</a></li>
                        <li><a class="dropdown-item-custom" href="{{ route('catalog.geles-dezuteje') }}">Gėlės dėžutėje</a></li>
                        <li><a class="dropdown-item-custom" href="{{ route('catalog.miegancios-rozes') }}">Miegančios rožės</a></li>
                    </ul>
                </li>
                <li class="nav-item dropdown-hover">
                    <a class="nav-link" href="#">SPECIALŪS PASIŪLYMAI</a>
                    <ul class="dropdown-menu-custom">
                        <li><a class="dropdown-item-custom" href="#">Puokščių Prenumerata</a></li>
                        <li><a class="dropdown-item-custom" href="#">Dovanų Kuponai</a></li>
                    </ul>
                </li>
                <li class="nav-item"><a class="nav-link" href="{{ route('decoration') }}">DEKORAVIMO PASLAUGOS</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">KONTAKTAI</a></li>
            </ul>
        </div>
    </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.0/dist/js/bootstrap.bundle.min.js"></script>
