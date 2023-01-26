<?php

namespace App\Models;

use App\Concerns\HasAuthor;
use App\Concerns\HasUuidPk;
use App\Scopes\OwnerScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Booking extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuidPk;
    use HasAuthor;

    protected $guarded = [];

    protected $casts =[
        'check_in_date' => 'date',
        'check_out_date' => 'date',
        'admin_confirmed' => 'boolean',
        'landlord_confirmed' => 'boolean',
        'other_costs' => 'array'
    ];

    protected static function booted()
    {
        // static::addGlobalScope(new OwnerScope);
    }

    public function scopeOwned($query) {
        return $query->where('author_id', '=', auth()->id());
    }

    public function scopeMine($query) {
        return $query->withoutGlobalScope(OwnerScope::class)
            ->whereRelation('property', 'author_id', auth()->id());
    }

    public function property() {
        return $this->belongsTo(Property::class);
    }

    public function customer() {
        return $this->belongsTo(User::class, 'author_id');
    }

    public function payments() {
        return $this->hasMany(Payment::class, 'txn_ref');
    }

    public function deposit() {
        $deposit_months = $this->property->deposit_months;
        if ($deposit_months) {
            $amount = $this->property->rent_cost * $deposit_months;
        } else {
            $amount = 0;
        }
        return $amount;
    }
}
