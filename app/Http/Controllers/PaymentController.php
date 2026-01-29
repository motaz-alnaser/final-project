<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Booking;
use App\Models\Payment;
use Stripe\Stripe;
use Stripe\PaymentIntent;

class PaymentController extends Controller
{
    public function create(Request $request, $bookingId)
    {
        $booking = Booking::with('activity')->findOrFail($bookingId);

        if ($booking->payment) {
            return redirect()->route('user.bookings')->with('error', 'This booking is already paid.');
        }

        return view('user.booking_payment', compact('booking'));
    }

    public function store(Request $request, $bookingId)
    {
        $booking = Booking::with('activity')->findOrFail($bookingId);

        if ($booking->payment) {
            return response()->json([
                'error' => 'Payment already processed.'
            ], 409);
        }

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $paymentIntent = PaymentIntent::create([
                'amount' => $booking->total_amount * 100,
                'currency' => 'usd',
                'description' => "Booking #{$booking->id} for {$booking->activity->title}",
                'automatic_payment_methods' => ['enabled' => true],
                'metadata' => [
                    'booking_id' => $booking->id,
                    'user_id' => auth()->id(),
                ],
            ]);

            $payment = Payment::create([
                'booking_id' => $booking->id,
                'user_id' => auth()->id(),
                'amount' => $booking->total_amount,
                'currency' => 'USD',
                'stripe_payment_intent_id' => $paymentIntent->id,
                'status' => 'pending',
                'metadata' => [
                    'client_secret' => $paymentIntent->client_secret,
                ],
            ]);

            return response()->json([
                'success' => true,
                'clientSecret' => $paymentIntent->client_secret,
                'paymentId' => $payment->id,
            ]);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }

    public function confirm(Request $request)
    {
        $request->validate([
            'payment_intent_id' => 'required|string',
            'payment_method_id' => 'required|string',
        ]);

        Stripe::setApiKey(config('services.stripe.secret'));

        try {
            $payment = Payment::where('stripe_payment_intent_id', $request->payment_intent_id)
                ->where('user_id', auth()->id())
                ->firstOrFail();

            $paymentIntent = \Stripe\PaymentIntent::retrieve($payment->stripe_payment_intent_id);

            if ($paymentIntent->status === 'succeeded') {
                $payment->update([
                    'status' => 'succeeded',
                    'stripe_payment_method_id' => $request->payment_method_id,
                    'receipt_url' => $paymentIntent->charges->data[0]->receipt_url ?? null,
                ]);

                $payment->booking->update([
                    'status' => 'confirmed'
                ]);

                return response()->json([
                    'success' => true,
                    'paymentId' => $payment->id,
                    'receiptUrl' => $payment->receipt_url,
                    'message' => 'Payment completed successfully! Your booking has been confirmed.',
                ]);
            }

            return response()->json([
                'error' => 'Payment not completed yet.'
            ], 400);

        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}