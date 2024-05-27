<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShippingAddress extends Model
{
    use HasFactory;

    protected $table = 'shipping_address';

     /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'address_line_1',
        'address_line_2',
        'city',
        'state',
        'zip_code',
        'user_id',
    ];

    
    /**
     * Get the user that owns the shipping address.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
