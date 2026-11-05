<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Order extends Model {
    protected $fillable = [
        'branch_id', 
        'user_id', 
        'customer_name', 
        'customer_phone', 
        'customer_address', 
        'code', 
        'total', 
        'status', 
        'note', 
        'voucher_code', 
        'discount_amount',
        'payment_method'
    ];

    public function items()  { return $this->hasMany(OrderItem::class); }
    public function branch() { return $this->belongsTo(Branch::class); }
    public function user()   { return $this->belongsTo(User::class); }
}