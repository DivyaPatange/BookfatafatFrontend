<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserInfo extends Model
{
    use HasFactory;

    protected $table = "user_infos";

    protected $fillable = ['user_id', 'country', 'fullname', 'address', 'city', 'pin_code'];
}
