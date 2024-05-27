<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Shipment extends Model
{
    use HasFactory;

    //Enable Timestamp
    public $timestamps = true;
    
    //Custom Timestamp
    const UPDATED_AT = 'ship_out_date';
    
    protected $fillable = [
        'status',
        'ship_out_date',
        'tracking_number',
        'address_id',
        'user_id',
        'order_id',
    ];

    public function address(){
        return $this->belongsTo(ShippingAddress::class);
    }

    public function buyer(){
        return $this->belongsTo(User::class);
    }

    public function order(){
        return $this->hasOne(Order::class);
    }
}
