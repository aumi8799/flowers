@extends('layouts.app')

@section('title', 'Dekoravimo Paslaugos')

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
            <!-- Nuotrauka kairėje -->
            <div class="col-md-6">
                <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="img-fluid">
            </div>

            <!-- Informacija dešinėje -->
            <div class="col-md-6">
                <h2>{{ $product->name }}</h2>
                <p>{{ $product->description }}</p>
                <p><strong>Kaina:</strong> €{{ $product->price }}</p>

                <form action="{{ route('cart.add') }}" method="POST">
                    @csrf
                    <input type="hidden" name="id" value="{{ $product->id }}">
                    <input type="hidden" name="name" value="{{ $product->name }}">
                    <input type="hidden" name="price" value="{{ $product->price }}">
                    <input type="hidden" name="image" value="{{ $product->image }}"> 
                    <div class="form-group mb-3">
                        <label for="quantity">Kiekis:</label>
                        <input type="number" id="quantity" name="quantity" value="1" min="1" class="form-control" style="width: 100px;">
                    </div>

                    <button type="submit" class="add-to-cart-btn">Įdėti į krepšelį</button>
                </form>

            </div>
        </div>
    </div>
@endsection
