<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePayment extends Model
{
    use HasFactory;

    protected $table = "service_payments";

    protected $fillable = ['order_id', 'name', 'email', 'transaction_id', 'payment_mode',
    'payment_channel', 'payment_datetime', 'response_message'];
}
