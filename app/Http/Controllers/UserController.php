<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
 use Illuminate\Support\Facades\Hash;
 use Illuminate\Support\Facades\Auth;
 use App\Models\Activity;
use App\Models\Category;
 use App\Models\Activity_details;
   use App\Models\Booking;
   use App\Models\Review;
   use Carbon\Carbon;


class UserController extends Controller
{


public function index()
{
    $activities = Activity::where('status', 'active')
                          ->with(['host:id,name', 'category:id,name', 'primaryImage'])
                          ->latest()
                          ->take(10) 
                          ->get();

    return view('user.index', compact('activities'));
}

   



public function login()
{
    return view('user.login');
}


public function authenticate(Request $request)
{
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);


    if (Auth::attempt($credentials, $request->filled('remember'))) {
        $request->session()->regenerate();

       
        $user = Auth::user();

        if ($user->role === 'admin') {
            return redirect()->route('admin.dashboard');
        } elseif ($user->role === 'host') {
            return redirect()->route('owner.dashboard');
        } else {
            return redirect()->route('home');
        }
    }

   
    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
}




public function register(Request $request)
{
   
    if ($request->isMethod('get')) {
        return view('user.register');
    }

 
    $validated = $request->validate([
        'firstName' => ['required', 'string', 'max:255'],
        'lastName' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
        'phone' => ['nullable', 'string', 'max:20'],
        'role' => ['required', Rule::in(['user', 'host'])],
        'password' => ['required', 'confirmed', 'min:8'],
    ]);

    $user = \App\Models\User::create([
        'name' => $validated['firstName'] . ' ' . $validated['lastName'],
        'email' => $validated['email'],
        'phone' => $validated['phone'] ?? null,
        'role' => $validated['role'],
        'is_active' => true,
        'avatar_url' => null,
        'bio' => null,
        'password' => Hash::make($validated['password']),
    ]);

    auth()->login($user);

   
    if ($user->role === 'user') {
        return redirect()->route('login')->with('success', 'Your account has been created successfully!');
    } elseif ($user->role === 'host') {
        return redirect()->route('login')->with('success', 'Your account as an activity owner has been successfully created!');
    }

    return redirect()->route('home');
}


public function profile()
{
    $user = Auth::user();
    return view('user.profile', compact('user'));
}

public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'first_name' => ['required', 'string', 'max:255'],
        'last_name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'email', 'unique:users,email,' . $user->id],
        'phone' => ['nullable', 'string', 'max:20'],
        'bio' => ['nullable', 'string'],
    ]);

    $user->update([
        'name' => $request->first_name . ' ' . $request->last_name,
        'email' => $request->email,
        'phone' => $request->phone,
        'bio' => $request->bio,
    ]);

    return redirect()->back()->with('success', 'Account information has been updated successfully.');
}

public function changePassword(Request $request)
{
    $request->validate([
        'current_password' => ['required', 'string'],
        'new_password' => ['required', 'string', 'min:8', 'confirmed'],
    ]);

    $user = Auth::user();

    if (!Hash::check($request->current_password, $user->password)) {
        return back()->withErrors(['current_password' => 'The current password is incorrect.']);
    }

    $user->update(['password' => Hash::make($request->new_password)]);

    return redirect()->back()->with('success', 'Password has been changed successfully.');
}


    
public function activities(Request $request)
{
    $query = Activity::with(['category', 'host', 'primaryImage'])
        ->where('status', 'active')
        ->whereDate('activity_date', '>=', now()->toDateString()); 

   
    if ($request->filled('category') && $request->category !== 'all') {
        $query->where('category_id', $request->category);
    }

    
    if ($request->filled('location') && $request->location !== 'all') {
        $query->where('location', 'like', "%{$request->location}%");
    }

  
    if ($request->filled('search')) {
        $query->where(function ($q) use ($request) {
            $q->where('title', 'like', "%{$request->search}%")
              ->orWhere('description', 'like', "%{$request->search}%");
        });
    }

    
    $activities = $query->orderBy('activity_date', 'asc')
                        ->orderBy('activity_time', 'asc')
                        ->paginate(5);

    $categories = Category::all();
    $locations = Activity::where('status', 'active')
                         ->select('location')
                         ->distinct()
                         ->pluck('location');

    return view('user.activities', compact('activities', 'categories', 'locations'));
}

   

// public function activity_details($id)
// {
//     $activity = Activity::with(['host', 'category', 'reviews.user'])->findOrFail($id);

//     return view('user.activity_details', compact('activity'));
// }
public function activity_details($id)
{
    $activity = Activity::with([
        'host', 
        'category', 
        'reviews.user',
        'images',          
        'primaryImage'
             
    ])->findOrFail($id);

    return view('user.activity_details', compact('activity'));
}



public function bookings()
{
    $userId = auth()->id(); 

    //بتجيب الحجز حسب حالته
    $upcomingBookings = Booking::with(['activity', 'activity.host', 'activity.category'])
        ->where('user_id', $userId)
        ->whereIn('status', ['confirmed', 'pending']) 
        ->whereDate('booking_date', '>=', now()) 
        ->orderBy('booking_date', 'asc')
        ->get();

    $pastBookings = Booking::with(['activity', 'activity.host', 'activity.category'])
        ->where('user_id', $userId)
        ->where(function ($query) {
            $query->where('status', 'completed')
                  ->orWhere(function ($q) {
                      $q->where('status', 'confirmed')
                        ->whereDate('booking_date', '<', now());
                  });
        })
        ->orderBy('booking_date', 'desc')
        ->get();

    $cancelledBookings = Booking::with(['activity', 'activity.host', 'activity.category'])
        ->where('user_id', $userId)
        ->where('status', 'cancelled')
        ->orderBy('updated_at', 'desc')
        ->get();

    return view('user.bookings', compact('upcomingBookings', 'pastBookings', 'cancelledBookings'));
}



public function showBookingForm($activityId)
{
    $activity = Activity::findOrFail($activityId);

    
    $activityDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $activity->activity_date . ' ' . $activity->activity_time);
    if ($activityDateTime->isPast()) {
        return redirect()->route('user.activities')->withErrors('This activity has already passed.');
    }

    return view('user.booking_form', compact('activity'));
}

public function createBooking(Request $request, $activityId)
{
    $activity = Activity::findOrFail($activityId);


    $activityDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $activity->activity_date . ' ' . $activity->activity_time);
    if ($activityDateTime->isPast()) {
        return back()->withErrors('Cannot book a past activity.');
    }

    $validated = $request->validate([
        'num_participants' => ['required', 'integer', 'min:1', 'max:' . $activity->max_participants],
    ]);

    $totalAmount = $activity->price * $validated['num_participants'];

   
    $booking = Booking::create([
        'user_id' => Auth::id(),
        'activity_id' => $activity->id,
        'booking_date' => $activity->activity_date, 
        'booking_time' => $activity->activity_time, 
        'num_participants' => $validated['num_participants'],
        'total_amount' => $totalAmount,
        'status' => 'pending',
    ]);

    return redirect()->route('user.bookings')->with('success', 'The activity has been booked successfully!');
}


public function cancelBooking($bookingId)
{
    $booking = Booking::where('id', $bookingId)
                     ->where('user_id', auth()->id())
                     ->firstOrFail();

    if ($booking->status === 'cancelled') {
        return back()->with('error', 'Your reservation has already been cancelled.');
    }

    // دمج التاريخ والوقت للحجز
    $bookingDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $booking->booking_date . ' ' . $booking->booking_time);
    if ($bookingDateTime->isPast()) {
        return back()->with('error', 'The reservation cannot be canceled after it has started.');
    }

    $oneHourAgo = Carbon::now()->subHour();
    if ($booking->created_at < $oneHourAgo) {
        return back()->with('error', 'A reservation cannot be canceled more than an hour after the reservation has been made.');
    }

    $booking->update(['status' => 'cancelled']);
    return redirect()->route('user.bookings')->with('success', 'Your reservation has been successfully cancelled.');
}
public function submitReview(Request $request, $bookingId)
{
    $request->validate([
        'rating' => 'required|integer|min:1|max:5',
        'review_text' => 'nullable|string|max:500',
    ]);

    $booking = Booking::findOrFail($bookingId);

    // تأكد أن المستخدم هو صاحب الحجز
    if ($booking->user_id !== auth()->id()) {
        abort(403);
    }

    // تأكد أنه لم يتم التقييم مسبقًا
    if ($booking->review) {
        return redirect()->back()->withErrors(['error' => 'This activity has already been rated.']);
    }

    // إنشاء التقييم في جدول reviews
    Review::create([
        'user_id' => auth()->id(),
        'activity_id' => $booking->activity_id,
        'booking_id' => $booking->id,
        'rating' => $request->rating,
        'comment' => $request->review_text,
    ]);

    return redirect()->back()->with('success', 'Thank you for your review!');
}





// عرض صفحة الدفع المؤقتة
public function showPaymentForm(Request $request, $activityId)
{
    $activity = Activity::findOrFail($activityId);

    // إذا كان الطلب POST (حفظ البيانات في Session)
    if ($request->isMethod('post')) {
        $validated = $request->validate([
            'num_participants' => 'required|integer|min:1|max:' . $activity->max_participants,
            'total_amount' => 'required|numeric',
            'activity_id' => 'required|exists:activities,id',
        ]);

        // حفظ البيانات في Session
        session(['booking_data' => [
            'num_participants' => $validated['num_participants'],
            'total_amount' => $validated['total_amount'],
            'activity_id' => $validated['activity_id'],
        ]]);

        return response()->json(['success' => true]);
    }

    // إذا كان الطلب GET (عرض الصفحة)
    $activityDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $activity->activity_date . ' ' . $activity->activity_time);
    if ($activityDateTime->isPast()) {
        return redirect()->route('user.activities')->withErrors('This activity has already passed.');
    }

    $bookingData = session('booking_data');
    
    if (!$bookingData || $bookingData['activity_id'] != $activityId) {
        return redirect()->route('booking.create', $activityId)->withErrors('Please fill the booking form first.');
    }

    return view('user.payment_form', compact('activity', 'bookingData'));
}

// معالجة الدفع وتخزين الحجز
public function processPaymentForm(Request $request, $activityId)
{
    $activity = Activity::findOrFail($activityId);

    // التحقق من Session
    $bookingData = session('booking_data');
    
    if (!$bookingData || $bookingData['activity_id'] != $activityId) {
        return redirect()->route('booking.create', $activityId)->withErrors('Session expired. Please try again.');
    }

    // التحقق من صحة البيانات
    $activityDateTime = Carbon::createFromFormat('Y-m-d H:i:s', $activity->activity_date . ' ' . $activity->activity_time);
    if ($activityDateTime->isPast()) {
        session()->forget('booking_data');
        return back()->withErrors('Cannot book a past activity.');
    }

    // التحقق من عدد المشاركين
    if ($bookingData['num_participants'] > $activity->max_participants) {
        session()->forget('booking_data');
        return back()->withErrors('Number of participants exceeds maximum limit.');
    }

    // حساب المبلغ الإجمالي
    $totalAmount = $activity->price * $bookingData['num_participants'];

    // إنشاء الحجز في قاعدة البيانات
    $booking = Booking::create([
        'user_id' => Auth::id(),
        'activity_id' => $activity->id,
        'booking_date' => $activity->activity_date,
        'booking_time' => $activity->activity_time,
        'num_participants' => $bookingData['num_participants'],
        'total_amount' => $totalAmount,
        'status' => 'pending',
    ]);

    // حذف البيانات من Session
    session()->forget('booking_data');

    // إعادة توجيه لصفحة الدفع مع معرف الحجز
    return redirect()->route('booking_payment.create', $booking->id);
}


// حفظ بيانات الحجز في Session
public function storeBookingSession(Request $request, $activityId)
{
    $activity = Activity::findOrFail($activityId);
    
    $validated = $request->validate([
        'num_participants' => 'required|integer|min:1|max:' . $activity->max_participants,
    ]);

    $totalAmount = $activity->price * $validated['num_participants'];

    session(['booking_data' => [
        'num_participants' => $validated['num_participants'],
        'total_amount' => $totalAmount,
        'activity_id' => $activityId,
    ]]);

    return redirect()->route('booking.payment.summary', $activityId);
}

// عرض صفحة ملخص الدفع
public function showPaymentSummary($activityId)
{
    $activity = Activity::findOrFail($activityId);
    $bookingData = session('booking_data');

    if (!$bookingData || $bookingData['activity_id'] != $activityId) {
        return redirect()->route('booking.create', $activityId)->withErrors('Session expired. Please try again.');
    }

    return view('user.payment_form', compact('activity', 'bookingData'));
}

// معالجة الدفع الفعلي وتخزين الحجز
public function processPayment(Request $request, $activityId)
{
    $activity = Activity::findOrFail($activityId);
    $bookingData = session('booking_data');

    if (!$bookingData || $bookingData['activity_id'] != $activityId) {
        return redirect()->route('booking.create', $activityId)->withErrors('Session expired. Please try again.');
    }

    $totalAmount = $activity->price * $bookingData['num_participants'];

    $booking = Booking::create([
        'user_id' => Auth::id(),
        'activity_id' => $activityId,
        'booking_date' => $activity->activity_date,
        'booking_time' => $activity->activity_time,
        'num_participants' => $bookingData['num_participants'],
        'total_amount' => $totalAmount,
        'status' => 'pending',
    ]);

    session()->forget('booking_data');

    return redirect()->route('booking_payment', $booking->id);
}

}
