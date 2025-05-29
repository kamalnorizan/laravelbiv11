<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    protected $table = 'payments';
    protected $primaryKey = ['customerNumber', 'checkNumber'];
    public $incrementing = false;
    protected $keyType = 'string';
    public $timestamps = false;

    public function customer()
    {
        return $this->belongsTo(Customer::class, 'customerNumber', 'customerNumber');
    }
}
