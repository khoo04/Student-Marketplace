<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
     /**
     * Indicates if the model should be timestamped.
     *
     * @var bool
     */
    public $timestamps = true;

    protected $fillable = [
        'name',
        'description',
        'quantity_available',
        'price',
        'ratings',
        'condition',
        'images',
        'category_id',
        'user_id',
    ];

    public function scopeFilter($query, $filter){
        if ($filter ?? false){
            $query->where('name','like','%' . request('search') . '%');
        }
    }

    public function seller(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'product_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }
}
