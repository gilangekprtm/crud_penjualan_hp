<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'product';

    protected $fillable = [
        'product_name',
        'price',
        'qty_stock'
    ];

    protected $primaryKey = 'product_id';

    public $timestamps = false;
}
