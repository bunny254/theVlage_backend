<?php

namespace App\Models;

use App\Concerns\HasAuthor;
use App\Concerns\HasUuidPk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Permission extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasAuthor;
    use HasUuidPk;

    protected $guarded = [];

    protected $hidden = ['pivot'];

    // protected $with = ['roles'];

    // roles
    public function roles()
    {
       return $this->belongsToMany(Role::class,'permissions_roles');
    }

    // permissions
    public function users()
    {
       return $this->belongsToMany(User::class,'permissions_users');
    }

}
