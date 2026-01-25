<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Activity;
use App\Models\Booking;
use App\Models\Category;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
 use App\Models\Review;




class AdminController extends Controller
{


public function dashboard()
{
    // بتحسب احصائيات
    $totalUsers = User::count();
    $activeActivities = Activity::where('status', 'active')->count();
    $totalBookings = Booking::count();
    $totalRevenue = Booking::sum('total_amount'); 

    // بتجييب الانشطة
    $recentActivities = Activity::with('host:id,name')
                                ->latest()
                                ->take(5)
                                ->get();

    return view('admin.dashboard', compact(
        'totalUsers',
        'activeActivities',
        'totalBookings',
        'totalRevenue',
        'recentActivities'
    ));
}






public function earnings()
{
    // بتجيب النشاط والارباح
    $activities = Activity::withSum(['bookings as total_earnings' => function ($query) {
        $query->where('status', 'confirmed');
    }], 'total_amount')
    ->withCount(['bookings as confirmed_bookings_count' => function ($query) {
        $query->where('status', 'confirmed');
    }])
    ->with('host:id,name')
    ->latest()
    ->get();

    // بتحسب الارباح كاملة
    $totalEarnings = $activities->sum('total_earnings');
    $platformFeePercentage = 0.15; 
    $platformFees = $totalEarnings * $platformFeePercentage;
    $netEarnings = $totalEarnings - $platformFees;

    return view('admin.earnings', compact('activities', 'totalEarnings', 'platformFees', 'netEarnings'));
}
public function editUser($userId)
{
    $user = User::findOrFail($userId);
    return view('admin.edit_user', compact('user'));
}

public function updateUser(Request $request, $userId)
{
    $user = User::findOrFail($userId);

    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        'role' => ['required', 'in:user,host,admin'],
        'status' => ['required', 'in:active,inactive,suspended'],
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'role' => $request->role,
        'status' => $request->status,
    ]);

    return redirect()->route('admin.users')->with('success', 'The user was updated successfully.');
}

public function deleteUser($userId)
{
    $currentUser = Auth::id();
    
    // بحذفش الحساب الحالي
    if ($currentUser == $userId) {
        return redirect()->route('admin.users')->with('error', 'Your account cannot be deleted.');
    }

    $user = User::findOrFail($userId);
    $user->delete();

    return redirect()->route('admin.users')->with('success', 'The user has been deleted successfully.');
}
public function users(Request $request)
{
    $query = User::query();

    // بطبق الفلتر ع نوع المستخدم
    if ($request->filled('role')) {
        $role = $request->role;
        if ($role === 'regular') {
            $query->where('role', 'user');
        } elseif ($role === 'hosts') {
            $query->where('role', 'host');
        } elseif ($role === 'admins') {
            $query->where('role', 'admin');
        }
    }

    // بتعمل فلتر على الحالة
    if ($request->filled('status')) {
        $status = $request->status;
        if ($status === 'active') {
            $query->where('status', 'active'); 
        } elseif ($status === 'inactive') {
            $query->where('status', 'inactive');
        } elseif ($status === 'suspended') {
            $query->where('status', 'suspended');
        }
    }

    // بتطبق البحث
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $users = $query->latest()->paginate(5); 

    return view('admin.users', compact('users'));
}



public function editActivity($activityId)
{
    $activity = Activity::with('host:id,name', 'category:id,name')->findOrFail($activityId);
    $categories = Category::all();
    $hosts = User::where('role', 'host')->get(); 

    return view('admin.edit_activity', compact('activity', 'categories', 'hosts'));
}

public function updateActivity(Request $request, $activityId)
{
    $activity = Activity::findOrFail($activityId);

    $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'location' => ['required', 'string', 'max:255'],
        'price' => ['required', 'numeric', 'min:0'],
        'max_participants' => ['required', 'integer', 'min:1'],
        'category_id' => ['required', 'exists:categories,id'],
        'host_id' => ['required', 'exists:users,id'],
        'status' => ['required', 'in:active,pending,rejected,archived'],
        'image_url' => ['nullable', 'url'],
    ]);

    $activity->update([
        'title' => $request->title,
        'description' => $request->description,
        'location' => $request->location,
        'price' => $request->price,
        'max_participants' => $request->max_participants,
        'category_id' => $request->category_id,
        'host_id' => $request->host_id,
        'status' => $request->status,
        'image_url' => $request->image_url ?? $activity->image_url,
    ]);

    return redirect()->route('admin.activities')->with('success', 'The activity was updated successfully.');
}

public function deleteActivity($activityId)
{
    $activity = Activity::findOrFail($activityId);
    $activity->delete();

    return redirect()->route('admin.activities')->with('success', 'The activity has been deleted successfully.');
}
public function activities(Request $request)
{
    $query = Activity::with(['host:id,name', 'category:id,name'])->withCount('bookings');

  
    if ($request->filled('category')) {
        $query->where('category_id', $request->category);
    }

   
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    
    if ($request->filled('search')) {
        $query->where('title', 'like', '%' . $request->search . '%');
    }

    $activities = $query->latest()->paginate(5); 
    $categories = Category::all();

    return view('admin.activities', compact('activities', 'categories'));
}



public function create_activity()
{
    $categories = Category::all();
    $hosts = User::where('role', 'host')->get(); 

    return view('admin.create_activity', compact('categories', 'hosts'));
}

public function storeActivity(Request $request)
{
    $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'location' => ['required', 'string', 'max:255'],
        'price' => ['required', 'numeric', 'min:0'],
        'max_participants' => ['required', 'integer', 'min:1'],
        'category_id' => ['required', 'exists:categories,id'],
        'host_id' => ['required', 'exists:users,id'],
        'status' => ['required', 'in:active,pending,rejected,archived'],
        'image_url' => ['nullable', 'url'],
    ]);

    Activity::create([
        'title' => $request->title,
        'description' => $request->description,
        'location' => $request->location,
        'price' => $request->price,
        'max_participants' => $request->max_participants,
        'category_id' => $request->category_id,
        'host_id' => $request->host_id,
        'status' => $request->status,
        'image_url' => $request->image_url ?? 'images/default-activity.jpg',
    ]);

    return redirect()->route('admin.activities')->with('success', 'The activity was created successfully.');
}
    
    public function edit_activity()
    {
        return view('admin.create_activity'); 
    }
   


public function hosts(Request $request)
{
    $query = User::where('role', 'host');

    // بتعمل فلتر على الحالة
    if ($request->filled('status')) {
        $status = $request->status;
        if ($status === 'active') {
            $query->where('status', 'active'); 
        } elseif ($status === 'inactive') {
            $query->where('status', 'inactive');
        } elseif ($status === 'suspended') {
            $query->where('status', 'suspended');
        }
    }

    //بتطبق البحث
    if ($request->filled('search')) {
        $query->where('name', 'like', '%' . $request->search . '%');
    }

    $hosts = $query->latest()->paginate(5); 

    return view('admin.hosts', compact('hosts'));
}
public function bookings(Request $request)
{
    $query = Booking::with(['user:id,name', 'activity:id,title']);

    //بتعمل فلتر على الحالة
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    // بتطبق البحث
    if ($request->filled('search')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    $bookings = $query->latest()->paginate(5);

    return view('admin.bookings', compact('bookings'));
}

public function editBooking($bookingId)
{
    $booking = Booking::with('user:id,name', 'activity:id,title')->findOrFail($bookingId);
    $activities = Activity::all(); 

    return view('admin.edit_booking', compact('booking', 'activities'));
}

public function updateBooking(Request $request, $bookingId)
{
    $booking = Booking::findOrFail($bookingId);

    $request->validate([
        'activity_id' => ['required', 'exists:activities,id'],
        'num_participants' => ['required', 'integer', 'min:1'],
        'total_amount' => ['required', 'numeric', 'min:0'],
        'status' => ['required', 'in:confirmed,pending,completed,cancelled'],
        'booking_date' => ['required', 'date'],
        'booking_time' => ['required', 'string'],
    ]);

    $booking->update([
        'activity_id' => $request->activity_id,
        'num_participants' => $request->num_participants,
        'total_amount' => $request->total_amount,
        'status' => $request->status,
        'booking_date' => $request->booking_date,
        'booking_time' => $request->booking_time,
    ]);

    return redirect()->route('admin.bookings')->with('success', 'Your reservation has been updated successfully.');
}

public function deleteBooking($bookingId)
{
    $booking = Booking::findOrFail($bookingId);
    $booking->delete();

    return redirect()->route('admin.bookings')->with('success', 'Your reservation has been successfully deleted.');
}
    

public function admin_profile()
{
    $user = Auth::user(); 
    return view('admin.admin_profile', compact('user'));
}

public function updateProfile(Request $request)
{
    $user = Auth::user();

    $request->validate([
        'name' => ['required', 'string', 'max:255'],
        'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
        'phone' => ['nullable', 'string', 'max:20'],
        'bio' => ['nullable', 'string'],
    ]);

    $user->update([
        'name' => $request->name,
        'email' => $request->email,
        'phone' => $request->phone,
        'bio' => $request->bio,
    ]);

    return redirect()->route('admin.admin_profile')->with('success', 'The profile has been updated successfully.');
}
 

public function reviews()
{
    // بتجيب تقييمات
    $reviews = Review::with(['user:id,name', 'activity:id,title'])
                    ->latest()
                    ->get();

    return view('admin.reviews', compact('reviews'));
}  


public function editReview($reviewId)
{
    $review = Review::with('user:id,name', 'activity:id,title')->findOrFail($reviewId);

    return view('admin.edit_review', compact('review'));
}

public function updateReview(Request $request, $reviewId)
{
    $review = Review::findOrFail($reviewId);

    $request->validate([
        'rating' => ['required', 'integer', 'min:1', 'max:5'],
        'comment' => ['required', 'string'],
        'status' => ['required', 'in:approved,pending,rejected'],
    ]);

    $review->update([
        'rating' => $request->rating,
        'comment' => $request->comment,
        'status' => $request->status,
    ]);

    return redirect()->route('admin.reviews')->with('success', 'The rating has been updated successfully.');
}

public function deleteReview($reviewId)
{
    $review = Review::findOrFail($reviewId);
    $review->delete();

    return redirect()->route('admin.reviews')->with('success', 'Rating has been successfully deleted.');
}
}
