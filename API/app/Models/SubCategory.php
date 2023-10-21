<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class SubCategory extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'sub_category';
    protected $primaryKey = 'id';
    protected $guarded = [];

    protected $fillable = [
        'category_id',
        'name',
        'created_at',
        'updated_at',
    ];

    public function categories()
    {
        return $this->hasMany(Categories::class, 'id', 'category_id',);
    }

    public function sub_category_and_categories()
    {
        return $this->belongsTo(Categories::class, 'category_id', 'id');
    }
}
