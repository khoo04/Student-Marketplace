<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    const ACCOUNT_BUYER = 'buyer';
    const ACCOUNT_SELLER = 'seller';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'password',
        'approve_status',
        'phone_num',
        'types',
        'bank_name',
        'bank_acc_name',
        'bank_acc_num'
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    public function products(){
        return $this->hasMany(Product::class);
    }

    public function addresses(){
        return $this->hasMany(ShippingAddress::class,'user_id');
    }

    public function cart(){
        return $this->hasOne(Cart::class,'user_id');
    }

    public function comments(){
        return $this->hasMany(Comment::class);
    }
    
    public function payments(){
        return $this->hasMany(Payment::class);
    }

    public function orders(){
        return $this->hasMany(Order::class);
    }
}
