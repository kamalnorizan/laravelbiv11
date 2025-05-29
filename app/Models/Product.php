<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $table = 'products';
    protected $primaryKey = 'productCode';
    public $incrementing = false;
    protected $keyType = 'string';

    public function productline()
    {
        return $this->belongsTo(Productline::class, 'productLine', 'productLine');
    }

    public function orderdetails()
    {
        return $this->hasMany(Orderdetail::class, 'productCode');
    }
}
