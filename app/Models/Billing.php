<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Billing extends Model
{
    use HasFactory;

    protected $table = 'Billing';
    protected $primaryKey = 'Id';

    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'LastUpdate';

    protected $guarded = ['Id', 'Guid', 'CreateDate', 'LastUpdate'];
    protected $hidden = ['Times'];

    public function billing_detail()
    {
        return $this->hasMany(BillingDetail::class, 'billing_id', 'Id');
    }

    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'IdMerchant', 'Id');
    }
}
