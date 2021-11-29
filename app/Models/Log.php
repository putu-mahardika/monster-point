<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'Log';
    protected $primaryKey = 'Id';

    public $timestamps = ["created_at"]; //only want to used created_at column
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = null; //and updated by default null set

    protected $guarded = ['Id', 'Guid', 'CreateDate'];
    protected $hidden = ['Times'];
}
