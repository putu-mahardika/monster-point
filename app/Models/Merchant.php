<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Merchant extends Model
{
    use HasFactory;
    protected $table = 'dbo.Merchant';
    protected $fillable = ['CreateDate', 'Token', 'Nama', 'Alamat', 'Pic', 'PicTelp', 'Email', 'Pass', 'Kebutuhan', 'LastUpdate', 'Akif', 'Validasi'];
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'LastUpdate';
}
