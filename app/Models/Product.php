<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;
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
        'rating',
        'condition',
        'images',
        'approve_status',
        'category_id',
        'user_id',
    ];

    public function seller(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class,'product_id');
    }

    public function category(){
        return $this->belongsTo(Category::class,'category_id');
    }

    public function carts(){
        return $this->belongsToMany(Cart::class)->withPivot('quantity');;
    }

    public function orders(){
        return $this->hasMany(Order::class,'product_id');
    }
}
