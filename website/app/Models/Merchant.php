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
        'user_id',
        'name',
        'email',
        'password',
        'phone_number',
        'address',
        'city',
        'province',
        'profile_picture',
        'npwp',
        'id_card_number',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }
}
