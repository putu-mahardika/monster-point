<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var string[]
     */
    protected $guarded = [
        'id', 'created_at', 'updated_at', 'remember_token', 'two_factor_recovery_codes', 'two_factor_secret'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
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
     * The relationships that should always be loaded.
     *
     * @var array
     */
    protected $with = ['roles'];

    public function socialAccounts(){
        return $this->hasMany(SocialAccount::class);
    }

    /**
     * Get the merchant associated with the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function merchant()
    {
        // return $this->belongsTo(Merchant::class, 'email', 'email');
        return $this->belongsTo(Merchant::class, 'email', 'Email');
    }

    /**
     * Get all of the emailChangeTokens for the User
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function emailChangeTokens()
    {
        return $this->hasMany(EmailChangeVerification::class, 'user_id', 'id');
    }

    public function getIsAdminAttribute()
    {
        return $this->hasRole('super admin');
    }
}
