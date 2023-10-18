<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Transaction extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'transaction';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'ads_id',
        'total_transaction',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'user_id');
    }

    public function ads()
    {
        return $this->hasMany(User::class, 'id', 'ads_id');
    }
}
