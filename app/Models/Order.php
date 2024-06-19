<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order extends Model
{
    use HasFactory, SoftDeletes;

    public $timestamps = true;

    protected $fillable = [
        'user_id',
        'product_id',
        'address_id',
        'quantity',
        'comment_status',
        'order_status',
        'tracking_num',
        'ship_out_date',
    ];

    public function payment(){
        return $this->hasOne(Payment::class);
    }

    public function buyer(){
        return $this->belongsTo(User::class,'user_id');
    }
    
    public function product(){
        return $this->belongsTo(Product::class,'product_id');
    }

    public function address(){
        return $this->belongsTo(ShippingAddress::class);
    }
}
