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
        'category_id',
        'description',
        'notes',
        'price',
        'picture',
        'city',
        'province',
        'count_order',
        'rating',
        'is_approve',
        'count_view',
        'created_at',
        'updated_at',
    ];

    public function user()
    {
        return $this->hasMany(User::class, 'id_user');
    }

    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }

    public function categories()
    {
        return $this->belongsTo(Categories::class . 'category_id');
    }

    // public function sub_category()
    // {
    //     return $this->hasOne(SubCategory::class);
    // }
}
