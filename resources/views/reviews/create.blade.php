@extends('layouts.app')

@section('title', 'Rašyti atsiliepimą')

@section('content')
<div class="container my-5">
    <h2>Palikite atsiliepimą už užsakymą #{{ $order->id }}</h2>

    <form action="{{ route('reviews.store', $order) }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="rating" class="form-label">Įvertinimas (1-5):</label>
            <select name="rating" id="rating" class="form-select w-auto">
                @for ($i = 1; $i <= 5; $i++)
                    <option value="{{ $i }}">{{ $i }} ⭐</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Komentaras:</label>
            <textarea name="comment" id="comment" class="form-control" rows="4" required></textarea>
        </div>

        <button type="submit" class="btn btn-success">Pateikti atsiliepimą</button>
    </form>
</div>
@endsection
