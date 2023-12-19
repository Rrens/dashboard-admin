<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Merchant extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'merchants';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'name',
        'email',
        'password',
        'phone_number',
        'address',
        'city',
        'province',
        'profile_picture',
        'npwp',
        'is_approve',
        'month',
        'year',
        'id_card_number',
        'category_id',
        'created_at',
        'updated_at',
    ];


    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function ads()
    {
        return $this->belongsTo(Ads::class);
    }

    public function category()
    {
        return $this->hasMany(Categories::class, 'id', 'category_id',);
    }
}
