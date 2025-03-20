@extends('layouts.app')

@section('title', 'Paieškos rezultatai')

@section('content')
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray header-text">
                <h1 class="display-4 fw-bolder">Paieškos rezultatai pagal "{{ $query }}"</h1>
            </div>
        </div>
    </header>

    <div class="product-list">
        @if ($products->isEmpty() && empty($navResults))
            <p>Nerasta rezultatų pagal jūsų užklausą: "{{ $query }}"</p>
        @else
            @foreach ($products as $product)
                <a href="{{ route('product.show', $product->id) }}" class="product-link">
                    <div class="product-item">
                        <img src="{{ asset('images/products/' . $product->image) }}" alt="{{ $product->name }}" class="product-image">
                        <div class="product-details">
                            <h2 class="product-name">{{ $product->name }}</h2>
                            <p class="product-price">{{ $product->price }} €</p>
                            <form action="{{ route('cart.add') }}" method="POST" class="add-to-cart-form">
                                @csrf
                                <input type="hidden" name="id" value="{{ $product->id }}">
                                <input type="hidden" name="name" value="{{ $product->name }}">
                                <input type="hidden" name="price" value="{{ $product->price }}">
                                <button type="submit" class="add-to-cart-btn">Įdėti į krepšelį</button>
                            </form>
                        </div>
                    </div>
                </a>
            @endforeach
        @endif
    </div>
@endsection
