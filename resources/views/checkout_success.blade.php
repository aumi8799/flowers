@extends('layouts.app')

@section('title', 'Mokėjimas sėkmingas')

@section('content')
<div class="container py-5">
    <div class="alert alert-success text-center">
        <h3>Ačiū už pirkimą!</h3>
        <p>Jūsų mokėjimas sėkmingai įvykdytas.</p>
        <a href="{{ url('/') }}" class="btn btn-primary">Grįžti į pagrindinį puslapį</a>
    </div>
</div>
@endsection
