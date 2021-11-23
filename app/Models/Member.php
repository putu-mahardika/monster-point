<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Member extends Model
{
    use HasFactory;
    protected $hidden = ['Times'];
    protected $table = 'dbo.Member';
    protected $fillable = ['IdMerhant', 'MerchentMemberKey', 'Nama', 'Point', 'Keterangan'];
    const CREATED_AT = 'CreateDate';
    const UPDATED_AT = 'LastUpdate';

    protected $with = ['merchant'];

    /**
     * Get the merchant that owns the Member
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function merchant()
    {
        return $this->belongsTo(Merchant::class, 'IdMerhant', 'Id');
    }
}
