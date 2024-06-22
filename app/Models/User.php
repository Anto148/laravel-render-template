<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use DateTimeInterface;
use Laravel\Sanctum\HasApiTokens;
use Spatie\MediaLibrary\HasMedia;
use Illuminate\Notifications\Notifiable;
use Spatie\MediaLibrary\InteractsWithMedia;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable implements MustVerifyEmail, HasMedia
{
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes, InteractsWithMedia;
    public const AVATAR_COLLECTION_NAME = "avatar";

    protected $fillable = [
        'nom',
        'prenom',
        'telephone',
        'email',
        'password',
        'is_active',
        'can_login',
        'otp',
        'email_verified_at',
        'account_set_token',
        'account_set_token_created_at',
        'password_reset_token',
        'password_reset_token_created_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
        'email_verified_at',

        'otp',
        'otp_created_at',

        'account_set_token',
        'account_set_token_created_at',

        'password_reset_token',
        'password_reset_token_created_at',
    ];
    protected $appends = [
        'fullname',
        'avatar'
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',

        'otp' => 'hashed',

        'account_set_token' => 'hashed',
        'account_set_token_created_at' => 'datetime',

        'password_reset_token' => 'hashed',
        'password_reset_token_created_at' => 'datetime',
    ];

    public function getAvatarAttribute()
    {
      return $this->getFirstMedia(User::AVATAR_COLLECTION_NAME);
    }

    public function roles()
    {
      return $this->belongsToMany(Role::class);
    }

    public function getFullnameAttribute()
    {
      return $this->nom . ' ' . $this->prenom;
    }

    protected function serializeDate(DateTimeInterface $date)
    {
      return $date->format(config('panel.datetime_format'));
    }

}
