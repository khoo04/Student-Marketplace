<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $fillable = [
        'total_payment',
        'transaction_no',
        'payment_status',
        'order_id',
        'user_id',
        'isPaid',
    ];

    public function buyer(){
        return $this->belongsTo(User::class);
    }

    public function order(){
        return $this->belongsTo(Order::class);
    }
}
