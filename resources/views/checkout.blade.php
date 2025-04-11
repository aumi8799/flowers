@extends('layouts.app') 

@section('title', 'Atsiskaitymas per PayPal')

@section('content')
<div class="container mt-5">
    <h2>Apmokėjimas per PayPal</h2>
    <p class="mb-3">Mokėjimo suma: <strong>{{ $total }} €</strong></p>

    <div id="paypal-button-container"></div>
</div>

<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID') }}&currency=EUR"></script>

<script>
    paypal.Buttons({
        createOrder: function(data, actions) {
            return actions.order.create({
                purchase_units: [{
                    amount: {
                        value: '{{ $total }}'
                    }
                }]
            });
        },
        onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
            window.location.href = "{{ route('paypal.success') }}";
        });
    },
    onCancel: function(data) {
        window.location.href = "{{ route('paypal.cancel') }}";
    }
}).render('#paypal-button-container');
</script>
@endsection