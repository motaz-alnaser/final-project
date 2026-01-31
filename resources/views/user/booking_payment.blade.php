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
    hidePostalCode: true,
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

// ✅ مُحسَّن: مُعدَّل للتوجيه التلقائي بعد نجاح الدفع
form.addEventListener('submit', async (e) => {
    e.preventDefault();
    
    const submitButton = form.querySelector('button[type="submit"]');
    submitButton.disabled = true;
    submitButton.textContent = 'Processing...';
    message.textContent = '';

    try {
        // الخطوة 1: إنشاء Payment Intent
        const response = await fetch('{{ route("booking_payment.store", $booking->id) }}', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });

        // التحقق من حالة الاستجابة
        if (!response.ok) {
            // إذا كان الخطأ 419 (CSRF token mismatch)
            if (response.status === 419) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Session Expired',
                    text: 'Your session has expired. Please refresh the page and try again.',
                    confirmButtonText: 'Reload Page'
                }).then(() => {
                    window.location.reload();
                });
                return;
            }
            
            // إذا كان الخطأ 401 (Unauthenticated)
            if (response.status === 401) {
                Swal.fire({
                    icon: 'warning',
                    title: 'Authentication Required',
                    text: 'Please log in again to continue.',
                    confirmButtonText: 'Go to Login'
                }).then(() => {
                    window.location.href = '{{ route("login") }}';
                });
                return;
            }
            
            // أي خطأ آخر
            const errorText = await response.text();
            throw new Error(errorText || 'Network error. Please try again.');
        }

        // التحقق من نوع المحتوى قبل تحليل JSON
        const contentType = response.headers.get('content-type');
        if (contentType && !contentType.includes('application/json')) {
            throw new Error('Server returned unexpected response. Please try again.');
        }

        const data = await response.json();

        if (data.error) {
            throw new Error(data.error);
        }

        // الخطوة 2: تأكيد الدفع مع سترايب
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

        // ✅ الخطوة 3: توجيه تلقائي بعد نجاح الدفع
        if (result.paymentIntent.status === 'succeeded') {
            Swal.fire({
                icon: 'success',
                title: 'Payment Processing...',
                text: 'Please wait while we confirm your booking.',
                showConfirmButton: false,
                allowOutsideClick: false,
                willOpen: () => {
                    Swal.showLoading();
                }
            });

            // توجيه تلقائي إلى صفحة التأكيد
            setTimeout(() => {
                window.location.href = '{{ route("booking_payment.confirm") }}?payment_intent_id=' + result.paymentIntent.id + '&payment_method_id=' + result.paymentIntent.payment_method;
            }, 1000);
        }

    } catch (error) {
        console.error('Payment error:', error);
        Swal.fire({
            icon: 'error',
            title: 'Payment Failed',
            text: error.message || 'An unexpected error occurred. Please try again.',
            confirmButtonText: 'OK'
        });
        submitButton.disabled = false;
        submitButton.textContent = 'Pay Now';
    }
});
</script>
@endsection