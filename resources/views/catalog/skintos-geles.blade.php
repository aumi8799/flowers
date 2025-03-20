@extends('layouts.app')

@section('title', 'Skintos gėlės')

@section('content')
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray header-text">
            <h1 class="display-4 fw-bolder">Skintos gėlės</h1>
            </div>
        </div>
    </header>

    <div class="container my-3">
        <form method="GET" action="{{ route('catalog.skintos-geles') }}">
            <div class="row justify-content-start">
                <p class="lead fw-normal text-dark mb-3">Filtruoti pagal kainą</p>
                <div class="col-md-auto">
                    <input type="number" name="min_price" class="form-control" style="width: 150px;" placeholder="Min Kaina" value="{{ request('min_price') }}" min="0" max="150">
                </div>
                <div class="col-md-auto">
                    <input type="number" name="max_price" class="form-control" style="width: 150px;" placeholder="Max Kaina" value="{{ request('max_price') }}" min="0" max="150">
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="add-to-cart-btn">Filtruoti</button>
                </div>
            </div>
        </form>
    </div>
    
    <div class="product-list">
    @foreach ($products as $product)
            <div class="product-item">
                <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                <div class="product-details">
                    <h2 class="product-name">{{ $product->name }}</h2>
                    <p class="product-price">{{ $product->price }} €</p>
                    <form action="{{ route('product.show', $product->id) }}" class="add-to-cart-form">
                        @csrf
                        <button type="submit" class="add-to-cart-btn">Pasirinkti savybes</button>
                    </form>
                </div>
            </div>
    @endforeach
</div>
@endsection

