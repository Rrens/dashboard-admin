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
        'merchant_id',
        'ads_id',
        'total_transaction',
        'month',
        'year',
        'created_at',
        'updated_at',
    ];


    public function ads()
    {
        return $this->hasMany(User::class, 'id', 'ads_id');
    }

    public function merchant()
    {
        return $this->hasMany(Merchant::class, 'id', 'merchant_id');
    }
}
