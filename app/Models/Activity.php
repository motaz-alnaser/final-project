<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;

    protected $fillable = [
        'title', 'description', 'location', 'price',
        'max_participants', 'category_id', 'host_id', 'status', 'activity_date', 'activity_time',
    ];

    protected $casts = [
        'price' => 'decimal:2',
    ];

    // علاقة المضيف
    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    // علاقة الفئة
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    // علاقة الحجوزات
    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    // علاقة التقييمات
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // علاقة الصور (كل الصور)
    public function images()
    {
        return $this->hasMany(ActivityImage::class);
    }

    // علاقة الصورة الأساسية فقط
   public function primaryImage()
{
    return $this->hasOne(ActivityImage::class)->where('is_primary', true);
}
    public function isFullyBooked()
{
    $confirmedBookings = $this->bookings()->where('status', 'confirmed')->count();
    return $confirmedBookings >= $this->max_participants;
}
}