<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BillingDetail extends Model
{
    use HasFactory;

    public $table = 'billing_detail';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'billing_id', 'Id');
    }

}
