<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    protected $table = 'orderdetails';
    protected $primaryKey = ['orderNumber', 'productCode'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function order()
    {
        return $this->belongsTo(Order::class, 'orderNumber', 'orderNumber');
    }

    public function product()
    {
        return $this->belongsTo(Product::class, 'productCode', 'productCode');
    }
}
