<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $timestamps = false;

    protected $fillable = [
        'user_id',
    ];

    public function user(){
        return $this->belongsTo(User::class,'user_id');
    }

    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('quantity');;
    }

}
