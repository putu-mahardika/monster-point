<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoice';
    protected $primaryKey = 'id';

    protected $guarded = ['id', 'created_at', 'updated_at'];

    public function billing()
    {
        return $this->belongsTo(Billing::class, 'billing_id', 'Id');
    }
}
