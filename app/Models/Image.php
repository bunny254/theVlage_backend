<?php

namespace App\Models;

use App\Concerns\HasUuidPk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasUuidPk;

    protected $guarded = [];

    // images polymorph r-ship
    public function properties() {
        return $this->morphedByMany(Property::class, 'imageable');
    }

}
