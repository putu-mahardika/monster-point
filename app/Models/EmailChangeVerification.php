<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EmailChangeVerification extends Model
{
    use HasFactory;

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'verified_at' => 'datetime',
        'expired_at' => 'datetime'
    ];

    /**
     * Scope a query to only include active token
     *
     * @param  \Illuminate\Database\Eloquent\Builder  $query
     * @return \Illuminate\Database\Eloquent\Builder
     **/
    public function scopeActive($query)
    {
        return $query->where('expired_at', '>', now())
                     ->whereNull('verified_at');
    }

    /**
     * Get the user that owns the EmailChangeVerification
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
