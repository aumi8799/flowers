@extends('layouts.app') 

@section('title', 'Atsiskaitymas per PayPal')

@section('content')
    <header class="py-5" style="background: url('{{ asset('images/header-bg.jpg') }}') no-repeat center center; background-size: cover; height: 200px; display: flex; align-items: center; justify-content: center;">
        <div class="container px-4 px-lg-5 my-5">
            <div class="text-center text-dark-gray header-text">
            <h1 class="display-4 fw-bolder">
                <i class="fab fa-paypal"></i> Apmokėjimas per PayPal
            </h1>
            @if(isset($order_id))
            <p class="lead fw-normal text-dark-gray mb-0">Jūs mokate už rezervuotą užsakymą #{{ $order_id }}</p>
            @endif
            <p class="lead fw-normal text-dark-gray mb-0">Mokėjimo suma: <strong>{{ $total }} €</strong></p>
            </div>
        </div>
    </header>

    <div class="container my-5">
        <div style="display: flex; justify-content: center;">
            <div id="paypal-button-container" style="min-width: 350px;"></div>
        </div>
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
                let redirectUrl = "{{ route('paypal.success') }}";

                @if(isset($order_id))
                    redirectUrl += '?order_id={{ $order_id }}';
                @endif

                window.location.href = redirectUrl;
            });
        },
        onCancel: function(data) {
            window.location.href = "{{ route('paypal.cancel') }}";
        }
    }).render('#paypal-button-container');
</script>

@endsection