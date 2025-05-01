@extends('layouts.app')

@section('title', 'Užduoties peržiūra')

@section('content')

<header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
    <div class="container px-4 px-lg-5 my-5">
        <div class="text-center text-dark-gray">
            <h1 class="display-4 fw-bolder">Užduoties #{{ $order->id }} peržiūra</h1>
        </div>
    </div>
</header>

<div class="container my-5">
    <h2 class="mb-4">Užsakymo informacija</h2>
    
    <!-- Užsakymo duomenų kortelė -->
    <div class="card mb-4 shadow-sm border-light">
        <div class="card-body">
            <p><strong>Užsakymo ID:</strong> {{ $order->id }}</p>
            <p><strong>Užsakovo duomenys:</strong></p>
            <ul>
                <li><strong>Vardas:</strong> {{ $order->first_name }}</li>  
                <li><strong>Pavardė:</strong> {{ $order->last_name }}</li>  
                <li><strong>Telefono numeris:</strong> {{ $order->phone }}</li>  
                <li><strong>El. paštas:</strong> {{ $order->email }}</li>  
            </ul>
            <p><strong>Pristatymo informacija:</strong></p>
            <ul>
                <li><strong>Pristatymo miestas:</strong>
                    @if($order->delivery_city == 7)
                        Vilnius
                    @elseif($order->delivery_city == 10)
                        Kaunas
                    @else
                        Nenurodytas miestas
                    @endif
                </li>
                <li><strong>Pristatymo adresas:</strong> {{ $order->delivery_address }}</li>  
                <li><strong>Pašto kodas:</strong> {{ $order->postal_code }}</li>  
                <li><strong>Pastabos:</strong> {{ $order->notes }}</li>             
            </ul>
            <p><strong>Bendra suma:</strong> {{ $order->total_price }}€</p>
            <p><strong>Statusas:</strong> {{ $order->status }}</p>
            <p><strong>Ar reikia filmuoti pristatymą:</strong> 
                @if($order->video == 1) 
                    Taip
                @else
                    Ne
                @endif
            </p>
        </div>
    </div>

    <!-- Prekės -->
    <h4 class="mb-4">Prekės</h4>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>Prekė</th>
                <th>Kiekis</th>
                <th>Kaina vnt.</th>
                <th>Atvirukas</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($order->items as $item)
                <tr>
                    <td>{{ $item->product->name }}</td>
                    <td>{{ $item->quantity }}</td>
                    <td>{{ $item->price }}€</td>
                    <td>@if($item->postcard)
                                    <i class="fas fa-check-circle" style="color: green; font-size: 1.5rem;"></i>
                                @else
                                    <i class="fas fa-times-circle" style="color: gray; font-size: 1.5rem;"></i>
                                @endif</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <!-- Grįžimo nuoroda -->
    <form action="/courier/tasks" method="GET" style="display:inline;">
    <button type="submit" class="btn btn-secondary mb-4">Grįžti</button>
</form>


    <!-- Vaizdo įrašo įkėlimas -->
    @if($order->video == 1 && !$order->video_path)
    <form action="{{ route('order.uploadVideo', $order->id) }}" method="POST" enctype="multipart/form-data" class="mb-3">
        @csrf
        <div class="mb-2">
            <label for="video_file" class="form-label">Įkelti vaizdo įrašą (MP4):</label>
            <input type="file" name="video_file" id="video_file" accept="video/mp4" class="form-control" required>
        </div>
        <button type="submit" class="btn btn-primary">Įkelti vaizdo įrašą</button>
    </form>
    @endif

    <!-- Užsakymo statuso atnaujinimas -->
    @if($order->status != 'pristatytas')
    <form action="{{ route('order.delivered', $order->id) }}" method="POST" style="display:inline;">
        @csrf
        @method('PUT')
        <button type="submit" class="btn btn-success"
            @if($order->video == 1 && !$order->video_path) disabled @endif>
            Pažymėti kaip pristatytą
        </button>
    </form>
    @endif
</div>
@endsection
