<?php

namespace App\Models;

use App\Concerns\HasUuidPk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Payment extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuidPk;

    protected $guarded = [];

    public function booking() {
        return $this->belongsTo(Booking::class, 'txn_ref');
    }
}
