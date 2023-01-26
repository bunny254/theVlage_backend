<?php

namespace App\Models;

use App\Concerns\HasAuthor;
use App\Concerns\HasUuidPk;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Role extends Model
{
    use HasFactory;
    use SoftDeletes;
    use HasAuthor;
    use HasUuidPk;

    protected $guarded = [];

    protected $hidden = ['pivot'];

    // protected $with = ['permissions'];

    // roles
    public function permissions()
    {
       return $this->belongsToMany(Permission::class,'permissions_roles');
    }

    // permissions
    public function users()
    {
       return $this->belongsToMany(User::class,'roles_users');
    }
}
