@extends('layouts.app')

@section('title', 'Redaguoti atsiliepimą')

@section('content')
<div class="container my-5">
    <h2>Redaguoti atsiliepimą #{{ $review->id }}</h2>

    <form method="POST" action="{{ route('admin.reviews.update', $review->id) }}">
        @csrf
        @method('PUT')

        <div class="mb-3">
            <label for="rating" class="form-label">Įvertinimas (1–5)</label>
            <select id="rating" name="rating" class="form-select">
                @for($i = 5; $i >= 1; $i--)
                    <option value="{{ $i }}" {{ $review->rating == $i ? 'selected' : '' }}>{{ $i }} žvaigžd.</option>
                @endfor
            </select>
        </div>

        <div class="mb-3">
            <label for="comment" class="form-label">Komentaras</label>
            <textarea id="comment" name="comment" rows="4" class="form-control">{{ old('comment', $review->comment) }}</textarea>
        </div>
        <div class="d-flex justify-content-between align-items-center mt-4 flex-wrap gap-2">

        <a href="{{ route('admin.reviews') }}" class="btn btn-secondary mb-3"><i class="fas fa-arrow-left me-2"></i>Grįžti</a>

        <button type="submit" class="btn btn-success">
                <i class="fas fa-save me-2"></i> Išsaugoti pakeitimus
            </button>
    </form>
    <form action="{{ route('admin.reviews.destroy', $review->id) }}" method="POST" onsubmit="return confirm('Ar tikrai norite ištrinti šį atsiliepimą?');">
    @csrf
    @method('DELETE')
    <button type="submit" class="btn btn-danger">Ištrinti atsiliepimą</button>
    </div>
</form>

</div>
@endsection
