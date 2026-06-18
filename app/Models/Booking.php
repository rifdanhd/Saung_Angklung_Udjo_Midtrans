<?php
namespace App\Models;
 
use Illuminate\Database\Eloquent\Model;
 
class Booking extends Model
{
    protected $fillable = [
        'order_id', 'customer_name', 'customer_email', 'customer_phone',
        'visit_date', 'session', 'total_amount', 'payment_type',
        'status', 'items', 'paid_at',
    ];
 
    protected $casts = [
        'items'      => 'array',
        'paid_at'    => 'datetime',
        'visit_date' => 'date',
    ];
}