<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Penjualan extends Model
{
    protected $table = 'sales';

    protected $fillable = [
        'customer_name',
        'product_id',
        'price',
        'qty',
        'total'
    ];

    protected $primaryKey = 'sales_id';

    public $timestamps = false;
}
