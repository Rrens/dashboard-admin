<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Categories extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'categories';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'name',
        'created_at',
        'updated_at',
    ];

    public function ads()
    {
        return $this->belongsTo(Ads::class);
    }

    public function sub_category()
    {
        return $this->belongsTo(SubCategory::class);
    }
}
