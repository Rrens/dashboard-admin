<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Ads extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ads';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'user_id',
        'description',
        'notes',
        'price',
        'picture',
        'count_order',
        'rating',
        'count_view',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'id', 'id_user');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
