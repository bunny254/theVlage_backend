<?php

namespace App\Models;

use App\Concerns\HasAuthor;
use App\Concerns\HasPermissions;
use App\Concerns\HasUuidPk;
use App\Notifications\ResetPasswordNotification;
use App\Notifications\VerifyEmailNotification;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Fortify\TwoFactorAuthenticatable;
use Laravel\Jetstream\HasProfilePhoto;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable // implements MustVerifyEmail
{
    use HasApiTokens;
    use HasFactory;
    use HasProfilePhoto;
    use Notifiable;
    use TwoFactorAuthenticatable;
    use SoftDeletes;
    use HasPermissions;
    use HasAuthor;
    use HasUuidPk;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
        'two_factor_recovery_codes',
        'two_factor_secret',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'profile_photo_url',
    ];

    public function getNameAttribute(): string
    {
        return "$this->surname, $this->other_names";
    }

    // is user verified
    public function isVerified() {
        return ! is_null($this->email_verified_at);
    }

    // is user verified
    public function markAsVerified() {
        return $this->update([
           'email_verified_at' => now()
        ]);
    }

    // customize verify email
    public function sendVerificationNotification($token)
    {
        // $token = random_int(100000, 999999);
        $this->notify(new VerifyEmailNotification($token));
    }

    // customize verify email
    public function sendPasswordResetNotification($token)
    {
        $this->notify(new ResetPasswordNotification($token));
    }

    // Route notifications for the Slack channel.
    public function routeNotificationForSlack($notification)
    {
        return config('services.slack.web_hook_url');
    }

    public function bookings() {
        return $this->hasMany(Booking::class, 'author_id');
    }
}
