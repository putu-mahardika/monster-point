<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;
    protected $hidden = ['Times'];
    protected $table = 'dbo.Merchant';
    protected $primaryKey = 'Id';
    protected $fillable = ['CreateDate', 'Token', 'Nama', 'Alamat', 'Pic', 'PicTelp', 'Email', 'Pass', 'Kebutuhan', 'LastUpdate', 'Akif', 'Validasi'];
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'LastUpdate';

    /**
     * Get all of the events for the Merchant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function events()
    {
        return $this->hasMany(Event::class, 'IdMerchant', 'Id');
    }

    public function billings()
    {
        return $this->hasMany(Billing::class, 'IdMerchant', 'Id');
    }

    /**
     * Get all of the members for the Merchant
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function members()
    {
        return $this->hasMany(Member::class, 'IdMerhant', 'Id');
    }

    public function users()
    {
        return $this->hasOne(User::class, 'email', 'Email');
        // return $this->hasOne(User::class, 'email', 'Email');
    }

    public function hasUser()
    {
        return $this->belongsTo(User::class, 'email', 'email');
    }

    // hapus semua yang berkaitan dengan merchant
    public static function boot() {
        parent::boot();
        static::deleting(function($merchant) { // before delete() method call this
            // dd($merchant->Email);
            $merchant->events()->delete();
            $merchant->billings()->delete();
            $merchant->members()->delete();
            $merchant->users()->delete();
        });
    }

}
