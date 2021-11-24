<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $hidden = ['Times'];
    protected $table = 'dbo.Member';
    protected $fillable = ['IdMerhant', 'MerchentMemberKey', 'Nama', 'Point', 'Keterangan', 'Aktif'];
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'LastUpdate';
}
