<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingDetail extends Model
{
    use HasFactory;

    public $table = 'billing_detail';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    protected $casts = [
        'payload' => 'array'
    ];

    public function setStatusPending()
    {
        $this->attributes['status'] = 'pending';
        $this->save();
    }

    /**
     * Set status to Success
     *
     * @return void
     */
    public function setStatusSuccess()
    {
        $this->attributes['status'] = 'success';
        $this->save();
    }

    /**
     * Set status to Failed
     *
     * @return void
     */
    public function setStatusFailed()
    {
        $this->attributes['status'] = 'failed';
        $this->save();
    }

    /**
     * Set status to Expired
     *
     * @return void
     */
    public function setStatusExpired()
    {
        $this->attributes['status'] = 'expired';
        $this->save();
    }

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'billing_id', 'Id');
    }



}
