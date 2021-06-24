<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BookService extends Model
{
    use HasFactory;

    protected $table = "book_services";

    protected $fillable = ['user_id', 'approved_by', 'start_date', 'end_date', 'start_time', 'end_time', 'duration', 'booking_status', 'vendor_id', 'service_id'];
}
