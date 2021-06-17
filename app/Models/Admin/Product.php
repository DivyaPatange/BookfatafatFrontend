<?php

namespace App\Models\Admin;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = "products";

    protected $fillable = ['vendor_id','category_id', 'sub_category_id', 'product_name', 'product_img', 'price', 'description', 'status'];
}
