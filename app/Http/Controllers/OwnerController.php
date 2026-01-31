<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Booking;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Category;
use Illuminate\Support\Facades\Storage;
use App\Models\Review;
use App\Models\ActivityImage;


class OwnerController extends Controller
{
    public function dashboard()
{
    $hostId = Auth::id();

    //بتجيب احصائيات
    $monthlyBookings = Booking::where('status', 'confirmed')
                             ->whereHas('activity', function ($q) use ($hostId) {
                                 $q->where('host_id', $hostId);
                             })
                             ->whereMonth('booking_date', now()->month)
                             ->count();

    $monthlyRevenue = Booking::where('status', 'confirmed')
                            ->whereHas('activity', function ($q) use ($hostId) {
                                $q->where('host_id', $hostId);
                            })
                            ->whereMonth('booking_date', now()->month)
                            ->sum('total_amount');

    $totalViews = Activity::where('host_id', $hostId)->sum('views_count'); 
    $averageRating = Activity::where('host_id', $hostId)->avg('rating'); 

    
    $activities = Activity::where('host_id', $hostId)
                         ->withCount('bookings')
                          ->with(['primaryImage']) 
                         ->latest()
                         ->paginate(5); 

    return view('owner.dashboard', compact(
        'monthlyBookings',
        'monthlyRevenue',
        'totalViews',
        'averageRating',
        'activities'
    ));
}


public function bookings(Request $request)
{
    $hostId = Auth::id();

    $query = Booking::whereHas('activity', function ($q) use ($hostId) {
        $q->where('host_id', $hostId);
    });

    // بتعمل فلتر ع الحالة
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }

    //بتعمل فلتر على النشاط
    if ($request->filled('activity')) {
        $query->where('activity_id', $request->activity);
    }

    // بتطبق البحث
    if ($request->filled('search')) {
        $query->whereHas('user', function ($q) use ($request) {
            $q->where('name', 'like', '%' . $request->search . '%');
        });
    }

    $bookings = $query->with(['user:id,name', 'activity:id,title'])->latest()->paginate(5); // 10 حجوزات في كل صفحة

    // بتجيب الانشطة
    $activities = Activity::where('host_id', $hostId)->select('id', 'title')->get();

    return view('owner.bookings', compact('bookings', 'activities'));
}

public function deleteBooking($bookingId)
{
    $hostId = Auth::id();

    
    $booking = Booking::where('id', $bookingId)
                     ->whereHas('activity', function ($query) use ($hostId) {
                         $query->where('host_id', $hostId);
                     })
                     ->firstOrFail();

    $booking->delete();

    return redirect()->route('owner.bookings')->with('success', 'Your reservation has been successfully deleted.');
}


public function add_activity()
{
    $categories = Category::all(); 
    return view('owner.add_activity', compact('categories'));
}

public function storeActivity(Request $request)
{
    $hostId = Auth::id();

    $validated = $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'location' => ['required', 'string', 'max:255'],
        'price' => ['required', 'numeric', 'min:0'],
        'max_participants' => ['required', 'integer', 'min:1'],
        'category_id' => ['required', 'exists:categories,id'],
        'images' => ['nullable', 'array'],
        'images.*' => ['image', 'mimes:jpeg,png,jpg,gif,svg', 'max:2048'],
      
        'activity_date' => ['required', 'date', 'after_or_equal:today'],
        'activity_time' => ['required', 'date_format:H:i'],
    ]);

    // إنشاء النشاط
    $activity = Activity::create([
        'title' => $validated['title'],
        'description' => $validated['description'],
        'location' => $validated['location'],
        'price' => $validated['price'],
        'max_participants' => $validated['max_participants'],
        'category_id' => $validated['category_id'],
        'host_id' => $hostId,
        'status' => 'active',
        
        'activity_date' => $validated['activity_date'],
        'activity_time' => $validated['activity_time'],
    ]);

    // رفع الصور
    if ($request->hasFile('images')) {
        foreach ($request->file('images') as $image) {
            if ($image->isValid()) {
                $path = $image->storeAs(
                    'uploads/activities',
                    time() . '_' . $image->getClientOriginalName(),
                    'public'
                );

                ActivityImage::create([
                    'activity_id' => $activity->id,
                    'image_url' => $path,
                    'is_primary' => false, 
                ]);
            }
        }

       
        $firstImage = $activity->images()->first();
        if ($firstImage) {
            $firstImage->update(['is_primary' => true]);
        }
    }

    return redirect()->route('owner.dashboard')->with('success', 'Activity added successfully.');
}
public function editActivity($activityId)
{
    $hostId = Auth::id();

    
    $activity = Activity::where('id', $activityId)
                       ->where('host_id', $hostId)
                       ->firstOrFail();

    $categories = Category::all();

    return view('owner.edit_activity', compact('activity', 'categories'));
}

public function updateActivity(Request $request, $activityId)
{
    $hostId = Auth::id();

    $activity = Activity::where('id', $activityId)
                       ->where('host_id', $hostId)
                       ->firstOrFail();

    $request->validate([
        'title' => ['required', 'string', 'max:255'],
        'description' => ['required', 'string'],
        'location' => ['required', 'string', 'max:255'],
        'price' => ['required', 'numeric', 'min:0'],
        'max_participants' => ['required', 'integer', 'min:1'],
        'category_id' => ['required', 'exists:categories,id'],
        'image_url' => ['nullable', 'url'],
    ]);

    $activity->update([
        'title' => $request->title,
        'description' => $request->description,
        'location' => $request->location,
        'price' => $request->price,
        'max_participants' => $request->max_participants,
        'category_id' => $request->category_id,
        'image_url' => $request->image_url ?? $activity->image_url,
        
    ]);

    return redirect()->route('owner.dashboard')->with('success', 'The activity was updated successfully.');
}
public function deleteActivity($activityId)
{
    $hostId = Auth::id();

   
    $activity = Activity::where('id', $activityId)
                       ->where('host_id', $hostId)
                       ->firstOrFail();

    $activity->delete();

    return redirect()->route('owner.dashboard')->with('success', 'The activity has been deleted successfully.');
}


public function earnings()
{
    $hostId = Auth::id();

    
    $totalEarnings = Booking::where('status', 'confirmed')
                           ->whereHas('activity', function ($query) use ($hostId) {
                               $query->where('host_id', $hostId);
                           })
                           ->sum('total_amount');

    $platformFeePercentage = 0.15; 
    $platformFees = $totalEarnings * $platformFeePercentage;
    $availableToWithdraw = $totalEarnings - $platformFees;

    
    $monthlyEarnings = Booking::where('status', 'confirmed')
                             ->whereHas('activity', function ($query) use ($hostId) {
                                 $query->where('host_id', $hostId);
                             })
                             ->whereMonth('booking_date', now()->month)
                             ->sum('total_amount');

    return view('owner.earnings', compact(
        'totalEarnings',
        'availableToWithdraw',
        'platformFees',
        'monthlyEarnings'
    ));
}

    

public function reviews()
{
    $hostId = Auth::id();

   
    $reviews = Review::whereHas('activity', function ($query) use ($hostId) {
        $query->where('host_id', $hostId);
    })
    ->with(['user:id,name', 'activity:id,title']) 
    ->latest()
    ->get();

    return view('owner.reviews', compact('reviews'));
}
public function deleteReview($reviewId)
{
    $hostId = Auth::id();

    
    $review = Review::where('id', $reviewId)
                   ->whereHas('activity', function ($query) use ($hostId) {
                       $query->where('host_id', $hostId);
                   })
                   ->firstOrFail();

    $review->delete();

    return redirect()->route('owner.reviews')->with('success', 'Rating has been successfully deleted.');
}
}