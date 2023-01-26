<?php

namespace App\Models;

use App\Concerns\HasAuthor;
use App\Concerns\HasUuidPk;
use App\Scopes\OwnerScope;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Property extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasAuthor;
    use HasUuidPk;

    // guarded
    protected $guarded = [];

    // hidden
    protected $hidden = [];

    // casts
    protected $casts = [
        'available_from' => 'datetime',
        'date_approved' => 'datetime',
        'is_furnished' => 'boolean',
        'amenities' => 'array',
        'services' => 'array'
    ];

    protected static function booted()
    {
        // static::addGlobalScope(new OwnerScope);
    }

    public function scopeOwned($query)
    {
        return $query->where('author_id', '=', auth()->id());
    }

    public function scopeApproved($query)
    {
        return $query->where('status', '=', 'approved');
    }

    public function scopeLike($query, $field, $value)
    {
        return $query->where($field, 'like', "%{$value}%");
    }

    public function scopeRooms($query, $field, $value)
    {
        return $query->where($field, '>=', $value);
    }

    public function scopeAvailability($query, $from_date)
    {
        return $query->whereDate('available_from', '<=', $from_date);
    }

    public function images()
    {
        return $this->morphMany(Image::class, 'imageable');
    }

    public function bookings()
    {
        return $this->hasMany(Booking::class);
    }

    public function deposit() {
        $deposit_months = $this->deposit_months;
        if ($deposit_months) {
            $amount = $this->rent_cost * $deposit_months;
        } else {
            $amount = 0;
        }
        return $amount;
    }
}
