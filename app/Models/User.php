<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasApiTokens, Notifiable,HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
      'first_name','last_name','profile_image','phone','email','farm_name','password','otp','otp_expires_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'opt',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function communities()
{
    return $this->hasMany(Community::class, 'user_id');
}
// ref code generate


protected static function boot()
{
    parent::boot();

    static::creating(function ($user) {
        $user->referral_code = strtoupper(substr($user->first_name, 0, 3)) . rand(1000, 9999);
    });
}

  public function getProfileImageAttribute($value)
{
    if ($value) {
        // Combine APP_URL with the stored image path
        return rtrim(config('app.url'), '/') . '/' . ltrim($value, '/');
    }

    return null;
}

}
