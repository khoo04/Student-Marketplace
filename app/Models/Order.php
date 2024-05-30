<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'user_id',
    ];

    public function shipment(){
        return $this->hasOne(Shipment::class);
    }

    public function payment(){
        return $this->hasOne(Payment::class);
    }

    public function buyer(){
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function products(){
        return $this->belongsToMany(Product::class)->withPivot('quantity', 'order_status', 'comments_status');
    }
}
