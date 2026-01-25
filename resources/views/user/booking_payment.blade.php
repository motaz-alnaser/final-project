@extends('layout.master')
@section('content')
<body>
    <section class="hero" style="min-height: 100vh; padding: 120px 20px;">
        <div class="philosophy-container">
            <h1 class="philosophy-headline">Complete Your Booking</h1>
            <p class="philosophy-subheading">Pay the minimum amount to confirm your activity.</p>

            <div class="stat-card" style="padding: 30px;">
                <h3>{{ $booking->activity->title }}</h3>
                <p>Date: {{ $booking->booking_date->format('F j, Y') }}</p>
                <p>Total: {{ $booking->total_amount }} JOD</p>
                <p>Minimum Required: {{ $booking->total_amount * 0.5 }} JOD</p>

                <form id="payment-form" action="{{ route('booking.pay', $booking->id) }}" method="POST">
                    @csrf
                    <input type="hidden" name="payment_intent_id" value="{{ $booking->payment_intent_id }}">
                    <div id="payment-element">
                       
                    </div>
                    <button id="submit-button" class="card-cta" style="width: 100%; margin-top: 20px;">
                        <div class="spinner hidden" id="spinner"></div>
                        <span id="button-text">Pay Now</span>
                    </button>
                </form>
            </div>
        </div>
    </section>
    @endsection
    @section('scripts')

    <script>
        const stripe = Stripe('{{ config('services.stripe.key') }}');
        const clientSecret = '{{ $booking->payment_intent_id }}'; 

        const elements = stripe.elements({
            clientSecret: clientSecret,
            appearance: {
                theme: 'night'
            }
        });

        const paymentElement = elements.create('payment');
        paymentElement.mount('#payment-element');

        const form = document.getElementById('payment-form');
        const submitButton = document.getElementById('submit-button');
        const spinner = document.getElementById('spinner');
        const buttonText = document.getElementById('button-text');

        form.addEventListener('submit', async (event) => {
            event.preventDefault();

            const {error} = await stripe.confirmPayment({
                elements,
                confirmParams: {
                    return_url: '{{ route('booking.payment.success', $booking->id) }}',
                },
            });

            if (error) {
                alert(error.message);
            }
        });
    </script>
    @endsection
