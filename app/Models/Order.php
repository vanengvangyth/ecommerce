<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'province',
        'district',
        'village',
        'total_amount',
        'order_date',
        'status',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function OrderDetails()
    {
        return $this->hasMany(OrderDetail::class);
    }



    public function product()
{
    return $this->belongsTo(Product::class);
}

}

