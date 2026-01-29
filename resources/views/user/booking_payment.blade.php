@extends('layout.master')

@section('content')
<div class="stats-section" style="padding: 60px 30px;">
    <div class="philosophy-container">
        <h2 class="section-title">Complete Your Payment</h2>

        <div style="max-width: 600px; margin: 0 auto; background: var(--carbon-dark); padding: 30px; border-radius: 15px;">
            <p style="color: var(--text-secondary); margin-bottom: 20px;">
                You're about to pay <strong>${{ number_format($booking->total_amount, 2) }}</strong> for:
                <br><strong>{{ $booking->activity->title }}</strong>
            </p>

            <form id="payment-form">
                <div id="card-element" style="border: 1px solid var(--metal-dark); padding: 15px; border-radius: 8px; margin-bottom: 20px;"></div>
                <button type="submit" class="card-cta" style="width: 100%;">Pay Now</button>
            </form>

            <div id="payment-message" style="margin-top: 20px; color: var(--text-dim);"></div>
        </div>
    </div>
</div>

<script src="https://js.stripe.com/v3/"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
const stripe = Stripe('{{ config("services.stripe.key") }}');
const elements = stripe.elements();

const cardElement = elements.create('card', {
    hidePostalCode: true,  // ← هذا السطر الجديد!
    style: {
        base: {
            color: '#fff',
            fontFamily: 'Arial, sans-serif',
            fontSmoothing: 'antialiased',
            fontSize: '16px',
            '::placeholder': {
                color: '#aab7c4'
            }
        },
        invalid: {
            color: '#fa755a',
            iconColor: '#fa755a'
        }
    }
});
cardElement.mount('#card-element');

const form = document.getElementById('payment-form');
const message = document.getElementById('payment-message');

form.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.textContent = 'Processing...';
    message.textContent = '';

    try {
        const response = await fetch('{{ route("booking_payment.store", $booking->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        const data = await response.json();

        if (data.error) {
            throw new Error(data.error);
        }

        const result = await stripe.confirmCardPayment(data.clientSecret, {
            payment_method: {
                card: cardElement,
                billing_details: {
                    name: '{{ auth()->user()->name ?? "" }}',
                    email: '{{ auth()->user()->email ?? "" }}'
                }
            }
        });

        if (result.error) {
            throw new Error(result.error.message);
        }

        if (result.paymentIntent.status === 'succeeded') {
            const confirmResponse = await fetch('{{ route("booking_payment.confirm") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    payment_intent_id: result.paymentIntent.id,
                    payment_method_id: result.paymentIntent.payment_method
                })
            });

            const confirmData = await confirmResponse.json();

            if (confirmData.success) {
                Swal.fire({
                    icon: 'success',
                    title: 'Payment Successful!',
                    text: confirmData.message,
                    html: `
                        <div style="text-align: center;">
                            <h3>Booking Confirmed! ✓</h3>
                            <p style="margin: 15px 0;"><strong>Booking #${{ $booking->id }}</strong></p>
                            <p style="margin: 10px 0;">${{ $booking->activity->title }}</p>
                            <p style="margin: 10px 0;">Total: ${{ number_format($booking->total_amount, 2) }}</p>
                            ${confirmData.receiptUrl ? `<p style="margin: 15px 0;"><a href="${confirmData.receiptUrl}" target="_blank" style="color: var(--accent-green);">View Receipt</a></p>` : ''}
                            <div style="margin-top: 20px;">
                                <a href="{{ route('user.bookings') }}" style="display: inline-block; padding: 10px 20px; background: var(--accent-green); color: white; text-decoration: none; border-radius: 5px; margin: 5px;">View My Bookings</a>
                                <a href="{{ route('user.activities') }}" style="display: inline-block; padding: 10px 20px; background: var(--metal-dark); color: white; text-decoration: none; border-radius: 5px; margin: 5px;">Browse More Activities</a>
                            </div>
                        </div>
                    `,
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    width: '500px'
                });
            } else {
                throw new Error('Payment confirmation failed');
            }
        }
    } catch (error) {
        message.textContent = error.message;
        message.style.color = '#fa755a';
        submitButton.disabled = false;
        submitButton.textContent = 'Pay Now';
    }
});
</script>

@endsection